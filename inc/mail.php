<?php
/**
 * Form email delivery (EmailJS) and reCAPTCHA v3 checks for the contact and careers forms.
 * Browser side: src/scripts/email.js. Settings: Customizer → Dany Maid → Email & reCAPTCHA.
 *
 * - The forms still POST to WordPress first, which validates, checks reCAPTCHA and saves the
 *   Lead / Application. The browser then sends the notification through EmailJS.
 * - While EmailJS is configured, WordPress does not send its own email (no duplicates). If EmailJS
 *   fails, the browser calls /mail-fallback and WordPress sends the same email with wp_mail.
 * - EmailJS only supports reCAPTCHA v2, so the v3 token is verified here. That needs the secret key:
 *   define DM_RECAPTCHA_SECRET in wp-config.php (preferred) or fill the Customizer field. Without it,
 *   tokens are not checked and the honeypot / time trap / rate limit still apply.
 */

function dm_mail_settings() {
  return array(
    'serviceId'        => trim(dm_mod('emailjs_service_id')),
    'publicKey'        => trim(dm_mod('emailjs_public_key')),
    'templates'        => array(
      'contact' => trim(dm_mod('emailjs_template_contact')),
      'careers' => trim(dm_mod('emailjs_template_careers')),
    ),
    'recaptchaSiteKey' => trim(dm_mod('recaptcha_site_key')),
    'fallbackEndpoint' => rest_url('dany-maid/v1/mail-fallback'),
  );
}

function dm_emailjs_enabled($form) {
  $mail = dm_mail_settings();
  return $mail['serviceId'] !== '' && $mail['publicKey'] !== '' && $mail['templates'][$form] !== '';
}

function dm_recaptcha_secret() {
  return defined('DM_RECAPTCHA_SECRET') ? DM_RECAPTCHA_SECRET : trim(dm_mod('recaptcha_secret_key'));
}

/**
 * True when the request passes reCAPTCHA v3 (or when no secret key is set yet).
 * A missing token is rejected only when a secret is set, since the widget may be blocked by an
 * extension; those requests still pass through the other spam checks.
 */
function dm_verify_recaptcha($token, $action) {
  $secret = dm_recaptcha_secret();
  if ($secret === '') {
    return true;
  }
  if (!is_string($token) || $token === '') {
    return false;
  }
  $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
    'timeout' => 8,
    'body'    => array(
      'secret'   => $secret,
      'response' => $token,
      'remoteip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
    ),
  ));
  if (is_wp_error($response)) {
    return true; // Google unreachable: don't lose a real customer over it.
  }
  $result = json_decode(wp_remote_retrieve_body($response), true);
  return !empty($result['success'])
    && (!isset($result['action']) || $result['action'] === $action)
    && (float) (isset($result['score']) ? $result['score'] : 0) >= (float) apply_filters('dm_recaptcha_min_score', 0.5);
}

// POST /dany-maid/v1/mail-fallback { reference: "DM-12" | "JOB-34" }
function dm_register_mail_fallback_route() {
  register_rest_route('dany-maid/v1', '/mail-fallback', array(
    'methods'             => 'POST',
    'callback'            => 'dm_handle_mail_fallback',
    'permission_callback' => '__return_true',
  ));
}

add_action('rest_api_init', 'dm_register_mail_fallback_route');

// Sends a saved request's email once, only while it is recent and still waiting on EmailJS.
function dm_handle_mail_fallback(WP_REST_Request $request) {
  if (!preg_match('/^(DM|JOB)-(\d+)$/', (string) $request->get_param('reference'), $m)) {
    return new WP_Error('dm_bad_reference', 'invalid', array('status' => 400));
  }
  $type = $m[1] === 'DM' ? 'dm_lead' : 'dm_application';
  $post = get_post((int) $m[2]);
  if (!$post || $post->post_type !== $type || get_post_meta($post->ID, '_dm_mail_sent', true) !== 'emailjs'
    || time() - get_post_time('U', true, $post) > 15 * MINUTE_IN_SECONDS) {
    return array('ok' => true);
  }

  if ($type === 'dm_lead') {
    $data     = (array) get_post_meta($post->ID, '_dm_lead', true);
    $tracking = (array) get_post_meta($post->ID, '_dm_tracking', true);
    $sent     = dm_send_lead_email($m[0], $data, $data['service_label'], $tracking);
  } else {
    $data = (array) get_post_meta($post->ID, '_dm_application', true);
    $sent = dm_send_application_email($m[0], $data, dm_application_rows($data));
  }
  update_post_meta($post->ID, '_dm_mail_sent', $sent ? 'yes' : 'no');
  return array('ok' => true);
}

// Admin label for the _dm_mail_sent meta of a Lead / Application.
function dm_mail_status_label($post_id) {
  $status = get_post_meta($post_id, '_dm_mail_sent', true);
  $labels = array(
    'yes'     => 'Sent by WordPress',
    'emailjs' => 'Sent through EmailJS',
    'no'      => 'Not sent, follow up from here',
  );
  return isset($labels[$status]) ? $labels[$status] : $labels['no'];
}
