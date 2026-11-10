<?php
/**
 * Editable content for non-technical editors: Appearance → Customize → Dany Maid.
 * Every field is declared once here (key, label, type, default) and read in
 * templates with dm_mod('key'). Add a field here and it appears in the Customizer.
 */

function dm_customizer_schema() {
  $service_fields = array();
  $service_defaults = array(
    'recurring' => array('Recurring Cleaning', 'Weekly, biweekly, or monthly visits that keep your home consistently cared for.'),
    'deep'      => array('Deep Cleaning', 'A more detailed visit for the moments when your home needs a reset.'),
    'one-time'  => array('One-Time Cleaning', 'Hosting, catching up, or checking a task off your list: cleaning for the occasion.'),
    'move'      => array('Move-In & Move-Out', 'Cleaning planned around your moving date, whether you are arriving or leaving.'),
  );
  foreach ($service_defaults as $key => $defaults) {
    $service_fields['service_' . $key . '_title'] = array('label' => "Service card: {$defaults[0]} — title", 'default' => $defaults[0]);
    $service_fields['service_' . $key . '_text'] = array('label' => "Service card: {$defaults[0]} — one-line value", 'type' => 'textarea', 'default' => $defaults[1]);
    $service_fields['service_' . $key . '_image'] = array('label' => "Service card: {$defaults[0]} — photo (empty = illustrative stock photo)", 'type' => 'image');
  }

  $testimonial_fields = array();
  for ($i = 1; $i <= 3; $i++) {
    $testimonial_fields["testimonial_{$i}_quote"] = array('label' => "Review {$i}: exact quote (authorized)", 'type' => 'textarea', 'default' => '');
    $testimonial_fields["testimonial_{$i}_author"] = array('label' => "Review {$i}: name as permitted (e.g. Maria G.)", 'default' => '');
    $testimonial_fields["testimonial_{$i}_platform"] = array('label' => "Review {$i}: platform (Google / Yelp)", 'default' => '');
    $testimonial_fields["testimonial_{$i}_url"] = array('label' => "Review {$i}: link to the original review", 'type' => 'url', 'default' => '');
  }

  return array(
    'dm_business' => array(
      'title'  => 'Business Info (NAP & Profiles)',
      'fields' => array(
        'business_phone'    => array('label' => 'Phone', 'default' => '(916) 517-9652'),
        'business_email'    => array('label' => 'Email', 'type' => 'email', 'default' => 'Danymaid@outlook.com'),
        'business_street'   => array('label' => 'Street address', 'default' => '7433 Greenback Ln, Suite L'),
        'business_city'     => array('label' => 'City', 'default' => 'Citrus Heights'),
        'business_region'   => array('label' => 'State', 'default' => 'CA'),
        'business_zip'      => array('label' => 'ZIP', 'default' => '95610'),
        'business_hours'    => array('label' => 'Business hours (leave empty until confirmed)', 'default' => ''),
        'profile_google'    => array('label' => 'Google Business Profile URL', 'type' => 'url', 'default' => 'https://www.google.com/maps/place/Dany+Maid+House+Cleaning+Service/@38.6452818,-121.3203325,10z/data=!4m6!3m5!1s0xde7f97a575b24b:0xc013942ef7453fb5!8m2!3d38.6452818!4d-121.3203325!16s%2Fg%2F11rvblhmqy'),
        'profile_yelp'      => array('label' => 'Yelp URL', 'type' => 'url', 'default' => 'https://www.yelp.com/biz/dany-maid-fair-oaks-3'),
        'profile_facebook'  => array('label' => 'Facebook URL', 'type' => 'url', 'default' => 'https://www.facebook.com/Danymaidcleaningservices'),
        'profile_instagram' => array('label' => 'Instagram URL', 'type' => 'url', 'default' => 'https://www.instagram.com/danymaid/'),
        'profile_bbb'       => array('label' => 'BBB profile URL', 'type' => 'url', 'default' => 'https://www.bbb.org/us/ca/citrus-heights/profile/janitor-service/dany-maid-llc-1156-90094099'),
        'service_areas'     => array('label' => 'Service areas (one verified city per line)', 'type' => 'textarea', 'default' => "Citrus Heights\nSacramento\nRoseville\nFolsom\nEl Dorado Hills\nGranite Bay\nRocklin\nCarmichael\nArden-Arcade\nOrangevale\nFair Oaks\nRancho Cordova\nNatomas"),
        'footer_tagline'    => array('label' => 'Footer tagline', 'type' => 'textarea', 'default' => 'Dependable house cleaning from a trusted local team serving homes across the Sacramento area.'),
      ),
    ),
    'dm_ratings' => array(
      'title'       => 'Ratings (update before publishing)',
      'description' => 'These are snapshots, not live data. Update the numbers and the date whenever you check the profiles.',
      'fields'      => array(
        'rating_google'       => array('label' => 'Google rating', 'default' => '4.9'),
        'rating_google_count' => array('label' => 'Google review count', 'default' => '405'),
        'rating_yelp'         => array('label' => 'Yelp rating', 'default' => '4.9'),
        'rating_yelp_count'   => array('label' => 'Yelp review count', 'default' => '115'),
        'ratings_date'        => array('label' => 'Ratings checked on (e.g. October 2026)', 'default' => 'October 2026'),
      ),
    ),
    'dm_cookies' => array(
      'title'       => 'Cookie Banner',
      'description' => 'Text of the cookie consent banner. Have legal review it together with the Privacy Policy before launch.',
      'fields'      => array(
        'cookie_title'   => array('label' => 'Title', 'default' => 'We value your privacy'),
        'cookie_message' => array('label' => 'Message', 'type' => 'textarea', 'default' => 'We use essential cookies to make our site work. With your permission, we’d also like to use analytics cookies to understand how visitors use our site so we can improve it.'),
      ),
    ),
    'dm_home_hero' => array(
      'title'  => 'Home · 01 Hero',
      'fields' => array(
        'home_hero_eyebrow'   => array('label' => 'Eyebrow', 'default' => 'House cleaning · Sacramento area'),
        'home_hero_title'     => array('label' => 'H1', 'default' => 'House Cleaning You Can Feel Confident About.'),
        'home_hero_body'      => array('label' => 'Body', 'type' => 'textarea', 'default' => 'From routine cleaning to a fresh start, Dany Maid helps Sacramento-area households enjoy a cleaner home with a professional team they can trust.'),
        'home_hero_cta'       => array('label' => 'Primary CTA', 'default' => 'Get a Quote'),
        'home_hero_secondary' => array('label' => 'Secondary CTA', 'default' => 'See Our Services'),
        'home_hero_image'     => array('label' => 'Hero photo (real team at a client home)', 'type' => 'image'),
        'home_hero_image_alt' => array('label' => 'Hero photo alt text', 'default' => 'Dany Maid team member cleaning a kitchen in a Sacramento-area home'),
      ),
    ),
    'dm_home_services' => array(
      'title'  => 'Home · 02 Services',
      'fields' => array(
        'home_services_title' => array('label' => 'H2', 'default' => 'The Right Cleaning for This Moment in Your Life.'),
        'home_services_body'  => array('label' => 'Body', 'type' => 'textarea', 'default' => 'A regular routine, a deeper reset, or a new chapter in a new home. We’ll help you find a service that fits.'),
        'home_services_cta'   => array('label' => 'CTA', 'default' => 'Explore Cleaning Services'),
      ) + $service_fields,
    ),
    'dm_home_reviews' => array(
      'title'       => 'Home · 03 Reviews',
      'description' => 'The reviews widget (Trustindex) shows live Google reviews. The manual review slots below are only used if the widget is empty or its plugin is inactive; add them word for word, with the customer’s permission.',
      'fields'      => array(
        'home_reviews_title'  => array('label' => 'H2', 'default' => 'Trusted in Homes Across the Sacramento Area.'),
        'home_reviews_body'   => array('label' => 'Body', 'type' => 'textarea', 'default' => 'See what local homeowners say about their experience with Dany Maid.'),
        'home_reviews_cta'    => array('label' => 'CTA', 'default' => 'Read Customer Reviews'),
        'home_reviews_widget' => array('label' => 'Reviews widget shortcode (Trustindex)', 'default' => '[trustindex no-registration=google]'),
      ) + $testimonial_fields,
    ),
    'dm_home_trust' => array(
      'title'  => 'Home · 04 Why Dany Maid',
      'fields' => array(
        'home_trust_title' => array('label' => 'H2', 'default' => 'Trust Is Built With Every Visit.'),
        'home_trust_body'  => array('label' => 'Body', 'type' => 'textarea', 'default' => 'Our team is made up of employees, not independent contractors. We value clear communication, dependable service, and the details that make a home feel cared for.'),
        'home_trust_cta'   => array('label' => 'CTA', 'default' => 'Why Homeowners Choose Dany Maid'),
      ) + dm_numbered_fields('home_trust_pillar', 'Trust point', array(
        array('Employees, not contractors', 'Our cleaners are W2 employees of Dany Maid, not independent contractors.'),
        array('Background-checked team', 'The team members who come into your home are background-checked.'),
        array('Insured company', 'Dany Maid is an insured cleaning company.'),
        array('Local since 2013', 'Our story began in 2013 in the Sacramento area and continued as Dany Maid in 2021.'),
      )),
    ),
    'dm_home_recurring' => array(
      'title'  => 'Home · 05 Recurring Cleaning',
      'fields' => array(
        'home_recurring_title'   => array('label' => 'H2', 'default' => 'A Cleaner Home, Without Starting Over Every Time.'),
        'home_recurring_body'    => array('label' => 'Body', 'type' => 'textarea', 'default' => 'Make professional cleaning part of your routine. Choose the frequency that works for your household and let us help you keep things consistently cared for.'),
        'home_recurring_weekly'  => array('label' => 'Weekly description', 'type' => 'textarea', 'default' => 'For busy households that want their home kept up week after week.'),
        'home_recurring_biweekly' => array('label' => 'Biweekly description', 'type' => 'textarea', 'default' => 'Regular upkeep every other week, with time in between to simply enjoy it.'),
        'home_recurring_monthly' => array('label' => 'Monthly description', 'type' => 'textarea', 'default' => 'A professional clean each month to support your own routine.'),
        'home_recurring_cta'     => array('label' => 'CTA', 'default' => 'Explore Recurring Cleaning'),
      ),
    ),
    'dm_home_team' => array(
      'title'  => 'Home · 06 Our Team',
      'fields' => array(
        'home_team_title'     => array('label' => 'H2', 'default' => 'The People Behind the Clean.'),
        'home_team_body'      => array('label' => 'Body', 'type' => 'textarea', 'default' => 'Inviting someone into your home is personal. That’s why we believe the people, the communication, and the care behind each visit matter as much as the results.'),
        'home_team_cta'       => array('label' => 'CTA', 'default' => 'Meet Dany Maid'),
        'home_team_image'     => array('label' => 'Team photo (real staff, leadership or branded vehicle)', 'type' => 'image'),
        'home_team_image_alt' => array('label' => 'Team photo alt text', 'default' => 'The Dany Maid cleaning team in Citrus Heights, CA'),
      ),
    ),
    'dm_home_steps' => array(
      'title'  => 'Home · 07 How It Works',
      'fields' => array(
        'home_steps_title' => array('label' => 'H2', 'default' => 'Getting Started Is Simple.'),
        'home_steps_body'  => array('label' => 'Body', 'type' => 'textarea', 'default' => 'Tell us about your home and what you need. We’ll review the details, confirm the next steps, and help you plan your cleaning.'),
        'home_steps_cta'   => array('label' => 'CTA', 'default' => 'Request Your Quote'),
      ) + dm_numbered_fields('home_step', 'Step', array(
        array('Request a Quote', 'Share a few details about your home, the service you need, and your preferred timing.'),
        array('Confirm Details', 'Our team reviews your request and follows up to confirm the scope and next steps with you.'),
        array('Enjoy Your Clean', 'Our team arrives prepared to care for your home the way you discussed.'),
      )),
    ),
    'dm_home_areas' => array(
      'title'  => 'Home · 08 Service Areas',
      'fields' => array(
        'home_areas_title' => array('label' => 'H2', 'default' => 'Proudly Serving Our Local Communities.'),
        'home_areas_body'  => array('label' => 'Body', 'type' => 'textarea', 'default' => 'Based in Citrus Heights, we serve households across nearby Sacramento-area communities. Check your location when requesting a quote.'),
        'home_areas_cta'   => array('label' => 'CTA', 'default' => 'View Service Areas'),
      ),
    ),
    'dm_home_faq' => array(
      'title'       => 'Home · 09 FAQ',
      'description' => 'Answer in 1–2 plain sentences first. Only publish answers confirmed by operations. Leave a question empty to hide it.',
      'fields'      => array(
        'home_faq_title' => array('label' => 'H2', 'default' => 'Questions Homeowners Often Ask.'),
        'home_faq_body'  => array('label' => 'Body', 'type' => 'textarea', 'default' => 'Clear answers about our team, our services, and how to get started. Don’t see your question? Give us a call.'),
      ) + dm_numbered_fields('home_faq', 'FAQ', array(
        array('Do you serve my area?', 'We are based in Citrus Heights and serve households across nearby Sacramento-area communities. Share your ZIP code when you contact us and our team will confirm coverage for your address.'),
        array('Are your cleaners employees or independent contractors?', 'Our cleaners are W2 employees of Dany Maid, not independent contractors. The team members who come into your home are background-checked.'),
        array('Is Dany Maid insured?', 'Yes. Dany Maid is an insured cleaning company.'),
        array('How often can I schedule recurring cleaning?', 'You can choose weekly, biweekly, or monthly visits. We’ll help you pick the frequency that fits your household when we prepare your quote.'),
        array('How much does a house cleaning cost?', 'Pricing depends on your home, its condition, and the service you need. Request a personalized quote and our team will follow up with the details.'),
        array('What is the difference between a recurring cleaning and a deep cleaning?', 'Recurring cleaning keeps your home consistently cared for on a regular schedule. A deep cleaning is a more detailed visit for when your home needs a reset; our team confirms the exact scope with you before the service.'),
      ), array('question', 'answer')),
    ),
    'dm_home_contact' => array(
      'title'  => 'Home · 10 Contact Form',
      'fields' => array(
        'home_contact_title'    => array('label' => 'H2', 'default' => 'Tell Us About Your Home.'),
        'home_contact_body'     => array('label' => 'Helper text', 'type' => 'textarea', 'default' => 'Share a few details and our team will help you find the next step.'),
        'home_contact_success'  => array('label' => 'Success message', 'type' => 'textarea', 'default' => 'Thanks for reaching out. We’ve received your request and will follow up using the contact information you provided.'),
        'contact_recipient'     => array('label' => 'Send new requests to (email)', 'type' => 'email', 'default' => 'Danymaid@outlook.com'),
      ),
    ),
    'dm_seo' => array(
      'title'       => 'Home · SEO',
      'description' => 'Ignored when an SEO plugin (Yoast, Rank Math) is active. Edit it there instead.',
      'fields'      => array(
        'home_seo_title'       => array('label' => 'SEO title', 'default' => 'House Cleaning in the Sacramento Area | Dany Maid'),
        'home_seo_description' => array('label' => 'Meta description', 'type' => 'textarea', 'default' => 'Discover recurring, deep, and move-in/move-out cleaning with Dany Maid, a professional local cleaning team based in Citrus Heights.'),
      ),
    ),
  );
}

// Builds "{prefix}_{n}_title" / "{prefix}_{n}_text" fields from [title, text] pairs.
// $names only changes the labels editors see (e.g. question / answer).
function dm_numbered_fields($prefix, $label, $items, $names = array('title', 'text')) {
  $fields = array();
  foreach ($items as $i => $item) {
    $n = $i + 1;
    $fields["{$prefix}_{$n}_title"] = array('label' => "{$label} {$n}: {$names[0]}", 'default' => $item[0]);
    $fields["{$prefix}_{$n}_text"] = array('label' => "{$label} {$n}: {$names[1]}", 'type' => 'textarea', 'default' => $item[1]);
  }
  return $fields;
}

function dm_customizer_defaults() {
  static $defaults = null;
  if ($defaults === null) {
    $defaults = array();
    foreach (dm_customizer_schema() as $section) {
      foreach ($section['fields'] as $key => $field) {
        $defaults[$key] = isset($field['default']) ? $field['default'] : '';
      }
    }
  }
  return $defaults;
}

function dm_mod($key) {
  $defaults = dm_customizer_defaults();
  return get_theme_mod($key, isset($defaults[$key]) ? $defaults[$key] : '');
}

function dm_customize_register($wp_customize) {
  $wp_customize->add_panel('dm_theme', array(
    'title'    => 'Dany Maid',
    'priority' => 10,
  ));

  $sanitizers = array(
    'text'     => 'sanitize_text_field',
    'textarea' => 'sanitize_textarea_field',
    'url'      => 'esc_url_raw',
    'email'    => 'sanitize_email',
    'image'    => 'absint',
  );

  $priority = 0;
  foreach (dm_customizer_schema() as $section_id => $section) {
    $wp_customize->add_section($section_id, array(
      'title'       => $section['title'],
      'description' => isset($section['description']) ? $section['description'] : '',
      'panel'       => 'dm_theme',
      'priority'    => $priority += 10,
    ));

    foreach ($section['fields'] as $key => $field) {
      $type = isset($field['type']) ? $field['type'] : 'text';

      $wp_customize->add_setting($key, array(
        'default'           => isset($field['default']) ? $field['default'] : '',
        'sanitize_callback' => $sanitizers[$type],
      ));

      if ($type === 'image') {
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, $key, array(
          'label'     => $field['label'],
          'section'   => $section_id,
          'mime_type' => 'image',
        )));
      } else {
        $wp_customize->add_control($key, array(
          'label'   => $field['label'],
          'section' => $section_id,
          'type'    => $type,
        ));
      }
    }
  }
}

add_action('customize_register', 'dm_customize_register');
