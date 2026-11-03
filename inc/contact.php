<?php
/**
 * Contact form backend for the React ContactForm component.
 * POST /wp-json/dany-maid/v1/contact → validates, stores the request as a "Lead"
 * (so nothing is lost if email fails) and emails the team.
 */

const DM_CONTACT_METHODS = array('call' => 'Phone call', 'text' => 'Text message', 'email' => 'Email');

function dm_register_lead_post_type() {
  register_post_type('dm_lead', array(
    'labels'          => array(
      'name'          => 'Leads',
      'singular_name' => 'Lead',
      'edit_item'     => 'Lead details',
      'search_items'  => 'Search leads',
    ),
    'public'          => false,
    'show_ui'         => true,
    'menu_icon'       => 'dashicons-email-alt',
    'menu_position'   => 25,
    'supports'        => array('title'),
    'capability_type' => 'post',
    'capabilities'    => array('create_posts' => 'do_not_allow'),
    'map_meta_cap'    => true,
  ));
}

add_action('init', 'dm_register_lead_post_type');

function dm_contact_service_options() {
  $options = array();
  foreach (dm_service_list() as $service) {
    $options[$service['key']] = $service['title'];
  }
  $options['not-sure'] = 'Not sure yet';
  return $options;
}

function dm_register_contact_route() {
  register_rest_route('dany-maid/v1', '/contact', array(
    'methods'             => 'POST',
    'callback'            => 'dm_handle_contact',
    'permission_callback' => '__return_true',
  ));
}

add_action('rest_api_init', 'dm_register_contact_route');

// Returns field => message for every invalid field (same rules as ContactForm.js).
function dm_validate_contact($data) {
  $errors = array();
  if (mb_strlen($data['name']) < 2) {
    $errors['name'] = 'Please enter your name.';
  }
  if (!is_email($data['email'])) {
    $errors['email'] = 'Please enter a valid email address.';
  }
  $digits = preg_replace('/\D/', '', $data['phone']);
  if ($data['phone'] !== '' && !preg_match('/^1?\d{10}$/', $digits)) {
    $errors['phone'] = 'Please enter a 10-digit phone number.';
  }
  if (!preg_match('/^\d{5}$/', $data['zip'])) {
    $errors['zip'] = 'Please enter a 5-digit ZIP code.';
  }
  if (!array_key_exists($data['service'], dm_contact_service_options())) {
    $errors['service'] = 'Please choose a service.';
  }
  if (!array_key_exists($data['contact_method'], DM_CONTACT_METHODS)) {
    $errors['contact_method'] = 'Please choose how we should contact you.';
  } elseif ($data['contact_method'] !== 'email' && $digits === '') {
    $errors['phone'] = 'Please add a phone number so we can call or text you.';
  } elseif ($data['contact_method'] === 'text' && !$data['sms_consent']) {
    $errors['sms_consent'] = 'Please agree to receive text messages, or choose another contact method.';
  }
  if (mb_strlen($data['message']) > 2000) {
    $errors['message'] = 'Please keep your message under 2,000 characters.';
  }
  return $errors;
}

function dm_handle_contact(WP_REST_Request $request) {
  // Honeypot: bots fill the hidden "company" field. Pretend success so they move on.
  if (trim((string) $request->get_param('company')) !== '') {
    return array('ok' => true, 'reference' => null);
  }
  // Time trap: humans need more than 3 seconds to fill the form.
  if ((int) $request->get_param('elapsed') < 3000) {
    return new WP_Error('dm_too_fast', 'Please take a moment to review your details and try again.', array('status' => 400));
  }

  $ip_key = 'dm_contact_' . md5(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
  $attempts = (int) get_transient($ip_key);
  if ($attempts >= 8) {
    return new WP_Error('dm_rate_limited', 'Too many requests. Please call us instead.', array('status' => 429));
  }
  set_transient($ip_key, $attempts + 1, 10 * MINUTE_IN_SECONDS);

  $data = array(
    'name'           => sanitize_text_field((string) $request->get_param('name')),
    'email'          => sanitize_email((string) $request->get_param('email')),
    'phone'          => sanitize_text_field((string) $request->get_param('phone')),
    'zip'            => sanitize_text_field((string) $request->get_param('zip')),
    'service'        => sanitize_key((string) $request->get_param('service')),
    'contact_method' => sanitize_key((string) $request->get_param('contact_method')),
    'sms_consent'    => (bool) $request->get_param('sms_consent'),
    'message'        => sanitize_textarea_field((string) $request->get_param('message')),
  );

  $errors = dm_validate_contact($data);
  if ($errors) {
    return new WP_Error('dm_invalid', 'Please check the highlighted fields.', array('status' => 422, 'fields' => $errors));
  }

  $services = dm_contact_service_options();
  $tracking = array_map('sanitize_text_field', array_filter((array) $request->get_param('tracking'), 'is_scalar'));

  $lead_id = wp_insert_post(array(
    'post_type'   => 'dm_lead',
    'post_status' => 'publish',
    'post_title'  => sprintf('%s — %s — %s', $data['name'], $services[$data['service']], $data['zip']),
    'meta_input'  => array(
      '_dm_lead'     => $data + array('service_label' => $services[$data['service']]),
      '_dm_tracking' => $tracking,
    ),
  ), true);

  if (is_wp_error($lead_id)) {
    return new WP_Error('dm_save_failed', 'We could not save your request.', array('status' => 500));
  }

  $reference = 'DM-' . $lead_id;
  $mail_sent = dm_send_lead_email($reference, $data, $services[$data['service']], $tracking);
  update_post_meta($lead_id, '_dm_mail_sent', $mail_sent ? 'yes' : 'no');

  return array('ok' => true, 'reference' => $reference);
}

function dm_send_lead_email($reference, $data, $service_label, $tracking) {
  $to = dm_mod('contact_recipient');
  if (!is_email($to)) {
    return false;
  }

  $lines = array(
    "New request {$reference} from the website",
    '',
    "Name: {$data['name']}",
    "Email: {$data['email']}",
    'Phone: ' . ($data['phone'] !== '' ? $data['phone'] : '—'),
    "ZIP: {$data['zip']}",
    "Service: {$service_label}",
    'Preferred contact: ' . DM_CONTACT_METHODS[$data['contact_method']],
    'SMS consent: ' . ($data['sms_consent'] ? 'Yes' : 'No'),
    '',
    'Message:',
    $data['message'] !== '' ? $data['message'] : '—',
  );
  if ($tracking) {
    $lines[] = '';
    $lines[] = 'Tracking:';
    foreach ($tracking as $key => $value) {
      $lines[] = "{$key}: {$value}";
    }
  }
  $lines[] = '';
  $lines[] = 'All leads: ' . admin_url('edit.php?post_type=dm_lead');

  return wp_mail(
    $to,
    "New cleaning request {$reference} — {$service_label} ({$data['zip']})",
    implode("\n", $lines),
    array('Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>')
  );
}

// Read-only details box on the Lead edit screen.
function dm_lead_meta_box() {
  add_meta_box('dm_lead_details', 'Request details', function ($post) {
    $lead     = (array) get_post_meta($post->ID, '_dm_lead', true);
    $tracking = (array) get_post_meta($post->ID, '_dm_tracking', true);
    $rows     = array(
      'Reference'         => 'DM-' . $post->ID,
      'Received'          => get_the_date('M j, Y g:i a', $post),
      'Name'              => isset($lead['name']) ? $lead['name'] : '',
      'Email'             => isset($lead['email']) ? $lead['email'] : '',
      'Phone'             => isset($lead['phone']) ? $lead['phone'] : '',
      'ZIP'               => isset($lead['zip']) ? $lead['zip'] : '',
      'Service'           => isset($lead['service_label']) ? $lead['service_label'] : '',
      'Preferred contact' => isset($lead['contact_method']) && array_key_exists($lead['contact_method'], DM_CONTACT_METHODS) ? DM_CONTACT_METHODS[$lead['contact_method']] : '',
      'SMS consent'       => !empty($lead['sms_consent']) ? 'Yes' : 'No',
      'Message'           => isset($lead['message']) ? $lead['message'] : '',
      'Email notification' => get_post_meta($post->ID, '_dm_mail_sent', true) === 'yes' ? 'Sent' : 'Not sent — follow up from here',
    );
    foreach ($tracking as $key => $value) {
      $rows['Tracking: ' . $key] = $value;
    }
    echo '<table class="widefat striped"><tbody>';
    foreach ($rows as $label => $value) {
      printf('<tr><th style="width:180px">%s</th><td>%s</td></tr>', esc_html($label), nl2br(esc_html($value)));
    }
    echo '</tbody></table>';
  }, 'dm_lead', 'normal', 'high');
}

add_action('add_meta_boxes_dm_lead', 'dm_lead_meta_box');
