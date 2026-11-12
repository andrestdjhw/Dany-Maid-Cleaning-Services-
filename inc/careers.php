<?php
/**
 * Careers application backend for the React CareersForm component (bilingual EN/ES).
 * POST /wp-json/dany-maid/v1/careers → validates, stores the application as an "Application"
 * (so nothing is lost if email fails) and emails HR (Customizer → Careers → HR email).
 *
 * Option keys must match src/scripts/components/CareersForm.js. The email is always written in
 * English; it notes which language the applicant used.
 * No criminal-history question on purpose (California Fair Chance Act: only after a conditional offer).
 */

function dm_careers_options() {
  return array(
    'position'   => array('cleaner' => 'House cleaner', 'team_lead' => 'Team lead (with cleaning experience)', 'other' => 'Other / not sure'),
    'schedule'   => array('full' => 'Full-time', 'part' => 'Part-time', 'either' => 'Either'),
    'experience' => array('none' => 'No experience, willing to learn', 'lt1' => 'Less than 1 year', '1to3' => '1 to 3 years', '3plus' => 'More than 3 years'),
    'days'       => array('mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday'),
    'languages'  => array('en' => 'English', 'es' => 'Spanish', 'other' => 'Other'),
    'yesno'      => array('yes' => 'Yes', 'no' => 'No'),
    'referral'   => array('' => '', 'google' => 'Google', 'facebook' => 'Facebook / Instagram', 'friend' => 'A friend or family member', 'job_site' => 'Job website (Indeed, etc.)', 'other' => 'Other'),
    'lang'       => array('en' => 'English', 'es' => 'Spanish'),
  );
}

function dm_register_application_post_type() {
  register_post_type('dm_application', array(
    'labels'          => array(
      'name'          => 'Job Applications',
      'menu_name'     => 'Applications',
      'singular_name' => 'Application',
      'edit_item'     => 'Application details',
      'search_items'  => 'Search applications',
    ),
    'public'          => false,
    'show_ui'         => true,
    'menu_icon'       => 'dashicons-id-alt',
    'menu_position'   => 26,
    'supports'        => array('title'),
    'capability_type' => 'post',
    'capabilities'    => array('create_posts' => 'do_not_allow'),
    'map_meta_cap'    => true,
  ));
}

add_action('init', 'dm_register_application_post_type');

function dm_register_careers_route() {
  register_rest_route('dany-maid/v1', '/careers', array(
    'methods'             => 'POST',
    'callback'            => 'dm_handle_application',
    'permission_callback' => '__return_true',
  ));
}

add_action('rest_api_init', 'dm_register_careers_route');

// Returns field => code for every invalid field (same rules as CareersForm.js, which shows the
// message in the applicant's language).
function dm_validate_application($data) {
  $o      = dm_careers_options();
  $errors = array();
  if (mb_strlen($data['name']) < 2) {
    $errors['name'] = 'required';
  }
  if (!preg_match('/^1?\d{10}$/', preg_replace('/\D/', '', $data['phone']))) {
    $errors['phone'] = 'invalid';
  }
  if ($data['email'] !== '' && !is_email($data['email'])) {
    $errors['email'] = 'invalid';
  }
  if (mb_strlen($data['city']) < 2) {
    $errors['city'] = 'required';
  }
  foreach (array('position', 'schedule', 'experience') as $key) {
    if (!array_key_exists($data[$key], $o[$key])) {
      $errors[$key] = 'required';
    }
  }
  foreach (array('transportation', 'work_authorized', 'pets') as $key) {
    if (!array_key_exists($data[$key], $o['yesno'])) {
      $errors[$key] = 'required';
    }
  }
  if (!$data['days']) {
    $errors['days'] = 'required';
  }
  if (!$data['languages']) {
    $errors['languages'] = 'required';
  }
  if (mb_strlen($data['about']) > 2000) {
    $errors['about'] = 'too_long';
  }
  if (!$data['consent']) {
    $errors['consent'] = 'required';
  }
  return $errors;
}

function dm_handle_application(WP_REST_Request $request) {
  // Honeypot and time trap, as in the contact form.
  if (trim((string) $request->get_param('company')) !== '') {
    return array('ok' => true, 'reference' => null);
  }
  if ((int) $request->get_param('elapsed') < 5000) {
    return new WP_Error('dm_too_fast', 'too_fast', array('status' => 400));
  }

  $ip_key   = 'dm_careers_' . md5(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
  $attempts = (int) get_transient($ip_key);
  if ($attempts >= 5) {
    return new WP_Error('dm_rate_limited', 'rate_limited', array('status' => 429));
  }
  set_transient($ip_key, $attempts + 1, 10 * MINUTE_IN_SECONDS);

  $o = dm_careers_options();
  // Keeps only known keys from a checkbox list, in the canonical order.
  $pick = function ($param, $allowed) use ($request) {
    $given = array_map('sanitize_key', array_filter((array) $request->get_param($param), 'is_scalar'));
    return array_values(array_intersect(array_keys($allowed), $given));
  };

  $data = array(
    'name'            => sanitize_text_field((string) $request->get_param('name')),
    'phone'           => sanitize_text_field((string) $request->get_param('phone')),
    'email'           => sanitize_email((string) $request->get_param('email')),
    'city'            => sanitize_text_field((string) $request->get_param('city')),
    'position'        => sanitize_key((string) $request->get_param('position')),
    'schedule'        => sanitize_key((string) $request->get_param('schedule')),
    'days'            => $pick('days', $o['days']),
    'experience'      => sanitize_key((string) $request->get_param('experience')),
    'transportation'  => sanitize_key((string) $request->get_param('transportation')),
    'work_authorized' => sanitize_key((string) $request->get_param('work_authorized')),
    'languages'       => $pick('languages', $o['languages']),
    'pets'            => sanitize_key((string) $request->get_param('pets')),
    'about'           => sanitize_textarea_field((string) $request->get_param('about')),
    'referral'        => sanitize_key((string) $request->get_param('referral')),
    'consent'         => (bool) $request->get_param('consent'),
    'lang'            => $request->get_param('lang') === 'es' ? 'es' : 'en',
  );
  if (!array_key_exists($data['referral'], $o['referral'])) {
    $data['referral'] = '';
  }

  $errors = dm_validate_application($data);
  if ($errors) {
    return new WP_Error('dm_invalid', 'invalid', array('status' => 422, 'fields' => $errors));
  }

  $rows = dm_application_rows($data);
  $id   = wp_insert_post(array(
    'post_type'   => 'dm_application',
    'post_status' => 'publish',
    'post_title'  => sprintf('%s, %s (%s)', $data['name'], $o['position'][$data['position']], $data['city']),
    'meta_input'  => array('_dm_application' => $data),
  ), true);

  if (is_wp_error($id)) {
    return new WP_Error('dm_save_failed', 'save_failed', array('status' => 500));
  }

  $reference = 'JOB-' . $id;
  $mail_sent = dm_send_application_email($reference, $data, $rows);
  update_post_meta($id, '_dm_mail_sent', $mail_sent ? 'yes' : 'no');

  return array('ok' => true, 'reference' => $reference);
}

// Label => readable value (English), shared by the HR email and the admin screen.
function dm_application_rows($data) {
  $o    = dm_careers_options();
  $list = function ($keys, $labels) {
    return implode(', ', array_map(function ($key) use ($labels) {
      return $labels[$key];
    }, $keys));
  };
  $get = function ($group, $key) use ($o) {
    return isset($o[$group][$key]) ? $o[$group][$key] : '';
  };

  return array(
    'Name'                              => $data['name'],
    'Phone'                             => $data['phone'],
    'Email'                             => $data['email'] !== '' ? $data['email'] : '(not given)',
    'City'                              => $data['city'],
    'Position'                          => $get('position', $data['position']),
    'Schedule'                          => $get('schedule', $data['schedule']),
    'Available days'                    => $list($data['days'], $o['days']),
    'Cleaning experience'               => $get('experience', $data['experience']),
    'Reliable transportation'           => $get('yesno', $data['transportation']),
    'Authorized to work in the U.S.'    => $get('yesno', $data['work_authorized']),
    'Languages'                         => $list($data['languages'], $o['languages']),
    'Comfortable in homes with pets'    => $get('yesno', $data['pets']),
    'Heard about us'                    => $data['referral'] !== '' ? $get('referral', $data['referral']) : '(not given)',
    'Form language'                     => $get('lang', $data['lang']),
    'About them'                        => $data['about'] !== '' ? $data['about'] : '(nothing added)',
  );
}

function dm_careers_recipient() {
  $to = dm_mod('careers_recipient');
  return is_email($to) ? $to : dm_mod('contact_recipient');
}

function dm_send_application_email($reference, $data, $rows) {
  $to = dm_careers_recipient();
  if (!is_email($to)) {
    return false;
  }

  $lines = array("New job application {$reference} from the website", '');
  foreach ($rows as $label => $value) {
    $lines[] = $label === 'About them' ? "\n{$label}:\n{$value}" : "{$label}: {$value}";
  }
  $lines[] = '';
  $lines[] = 'All applications: ' . admin_url('edit.php?post_type=dm_application');

  $headers = array();
  if ($data['email'] !== '') {
    $headers[] = 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>';
  }

  $o = dm_careers_options();
  return wp_mail(
    $to,
    sprintf('New job application %s: %s, %s', $reference, $data['name'], $o['position'][$data['position']]),
    implode("\n", $lines),
    $headers
  );
}

// Read-only details box on the Application edit screen.
function dm_application_meta_box() {
  add_meta_box('dm_application_details', 'Application details', function ($post) {
    $data = (array) get_post_meta($post->ID, '_dm_application', true);
    if (!isset($data['name'])) {
      echo '<p>No details saved.</p>';
      return;
    }
    $rows = array(
      'Reference' => 'JOB-' . $post->ID,
      'Received'  => get_the_date('M j, Y g:i a', $post),
    ) + dm_application_rows($data) + array(
      'Email notification' => get_post_meta($post->ID, '_dm_mail_sent', true) === 'yes' ? 'Sent' : 'Not sent, follow up from here',
    );
    echo '<table class="widefat striped"><tbody>';
    foreach ($rows as $label => $value) {
      printf('<tr><th style="width:220px">%s</th><td>%s</td></tr>', esc_html($label), nl2br(esc_html($value)));
    }
    echo '</tbody></table>';
  }, 'dm_application', 'normal', 'high');
}

add_action('add_meta_boxes_dm_application', 'dm_application_meta_box');
