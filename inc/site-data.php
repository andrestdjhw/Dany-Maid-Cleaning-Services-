<?php
/**
 * Business data shared by the PHP templates and the React components.
 * Editable values live in the Customizer (see inc/customizer.php); this file
 * only defines structure (slugs, icons) and assembles the data.
 */

// Services (residential, plus Airbnb and commercial from the client's services sheet).
// Titles and card text are editable in the Customizer. Photo: assets/images/service-{key}-*.webp
// ('stock' overrides the name). Real Dany Maid photos (uploads/2026/11/Mesa-de-trabajo-*.webp, 2026-11-19)
// 'alt' and 'focus' are used by the service page hero.
function dm_services() {
  return array(
    'recurring'  => array('slug' => 'recurring-house-cleaning', 'icon' => 'arrow-path', 'alt' => 'Two Dany Maid team members vacuuming and tidying a dining room', 'focus' => 'object-[50%_62%]'),
    'deep'       => array('slug' => 'deep-cleaning', 'icon' => 'sparkles', 'alt' => 'A Dany Maid team member wiping down a dining chair', 'focus' => 'object-[50%_45%]'),
    'one-time'   => array('slug' => 'one-time-cleaning', 'icon' => 'calendar', 'alt' => 'A Dany Maid team member making a bed with fresh sheets', 'focus' => 'object-[50%_58%]'),
    'move'       => array('slug' => 'move-in-move-out-cleaning', 'icon' => 'truck', 'alt' => 'A clean, bright kitchen and dining area', 'focus' => 'object-center'),
    'airbnb'     => array('slug' => 'airbnb-cleaning', 'icon' => 'key', 'alt' => 'A Dany Maid team member changing the bed linens', 'focus' => 'object-[50%_28%]'),
    'commercial' => array('slug' => 'commercial-cleaning', 'icon' => 'building', 'alt' => 'Aerial view of Dany Maid company cars parked in front of a commercial plaza', 'focus' => 'object-[60%_center]'),
  );
}

function dm_service_list() {
  $list = array();
  foreach (dm_services() as $key => $service) {
    $list[] = array(
      'key'   => $key,
      'icon'  => $service['icon'],
      'url'   => home_url('/' . $service['slug'] . '/'),
      'title' => dm_mod('service_' . $key . '_title'),
      'text'  => dm_mod('service_' . $key . '_text'),
      'image' => (int) dm_mod('service_' . $key . '_image'),
      'stock' => isset($service['stock']) ? $service['stock'] : 'service-' . $key,
      'alt'   => $service['alt'],
      'focus' => $service['focus'],
    );
  }
  return $list;
}

function dm_service_areas() {
  return array_values(array_filter(array_map('trim', explode("\n", dm_mod('service_areas')))));
}

// County of each listed city (for the service-areas map). Cities not listed here go under "Other areas".
function dm_city_counties() {
  return array(
    'Sacramento County' => array('Citrus Heights', 'Sacramento', 'Natomas', 'Carmichael', 'Arden-Arcade', 'Orangevale', 'Fair Oaks', 'Rancho Cordova', 'Folsom'),
    'Placer County'     => array('Roseville', 'Rocklin', 'Granite Bay'),
    'El Dorado County'  => array('El Dorado Hills'),
  );
}

// Service areas grouped by county, keeping the Customizer order: [{county, cities[]}].
function dm_service_areas_by_county() {
  $lookup = array();
  foreach (dm_city_counties() as $county => $cities) {
    foreach ($cities as $city) {
      $lookup[strtolower($city)] = $county;
    }
  }
  $groups = array();
  foreach (dm_service_areas() as $city) {
    $county = isset($lookup[strtolower($city)]) ? $lookup[strtolower($city)] : 'Other areas';
    $groups[$county][] = $city;
  }
  $result = array();
  foreach ($groups as $county => $cities) {
    $result[] = array('county' => $county, 'cities' => $cities);
  }
  return $result;
}

function dm_business() {
  $street = dm_mod('business_street');
  $city   = dm_mod('business_city');
  $region = dm_mod('business_region');
  $zip    = dm_mod('business_zip');
  $phone  = dm_mod('business_phone');

  return array(
    'name'      => 'Dany Maid',
    'legalName' => 'Dany Maid LLC',
    'phone'     => $phone,
    'phoneHref' => 'tel:+1' . preg_replace('/\D/', '', $phone),
    'email'     => dm_mod('business_email'),
    'street'    => $street,
    'city'      => $city,
    'region'    => $region,
    'zip'       => $zip,
    'mapsUrl'   => dm_mod('profile_google'),
    'hours'     => dm_mod('business_hours'),
  );
}

function dm_social_links() {
  $links = array(
    array('key' => 'google', 'label' => 'Google', 'url' => dm_mod('profile_google')),
    array('key' => 'yelp', 'label' => 'Yelp', 'url' => dm_mod('profile_yelp')),
    array('key' => 'facebook', 'label' => 'Facebook', 'url' => dm_mod('profile_facebook')),
    array('key' => 'instagram', 'label' => 'Instagram', 'url' => dm_mod('profile_instagram')),
    array('key' => 'bbb', 'label' => 'BBB', 'url' => dm_mod('profile_bbb')),
  );
  return array_values(array_filter($links, function ($link) {
    return !empty($link['url']);
  }));
}

function dm_ratings() {
  $ratings = array(
    array('platform' => 'Google', 'rating' => dm_mod('rating_google'), 'count' => dm_mod('rating_google_count'), 'url' => dm_mod('profile_google')),
    array('platform' => 'Yelp', 'rating' => dm_mod('rating_yelp'), 'count' => dm_mod('rating_yelp_count'), 'url' => dm_mod('profile_yelp')),
  );
  return array_values(array_filter($ratings, function ($r) {
    return $r['rating'] !== '' && $r['url'] !== '';
  }));
}

function dm_logo() {
  $id = get_theme_mod('custom_logo');
  if (!$id) {
    $id = attachment_url_to_postid(wp_upload_dir()['baseurl'] . '/2026/11/DANY-LOGO-scaled.png');
  }
  if (!$id) {
    return null;
  }
  $src = wp_get_attachment_image_src($id, 'medium');
  return array(
    'url'    => $src[0],
    'srcset' => wp_get_attachment_image_srcset($id, 'medium'),
    'width'  => $src[1],
    'height' => $src[2],
    'alt'    => 'Dany Maid',
  );
}

// Default navigation, used until a menu is assigned in Appearance → Menus.
function dm_default_primary_menu() {
  $children = array(array('label' => 'All House Cleaning Services', 'url' => home_url('/house-cleaning/'), 'children' => array()));
  foreach (dm_service_list() as $service) {
    $children[] = array('label' => $service['title'], 'url' => $service['url'], 'children' => array());
  }

  return array(
    array('label' => 'Services', 'url' => home_url('/house-cleaning/'), 'children' => $children),
    array('label' => 'Why Dany Maid', 'url' => home_url('/why-dany-maid/'), 'children' => array()),
    array('label' => 'Service Areas', 'url' => home_url('/service-areas/'), 'children' => array()),
    array('label' => 'Reviews', 'url' => home_url('/reviews/'), 'children' => array()),
    array('label' => 'About', 'url' => home_url('/about/'), 'children' => array()),
    // Careers goes straight to the job application form (#apply on the Careers page). Contact stays in the footer and the Get a Quote buttons.
    array('label' => 'Careers', 'url' => home_url('/careers/#apply'), 'children' => array()),
  );
}

function dm_default_footer_menu() {
  $links = array(
    array('label' => 'Why Dany Maid', 'url' => home_url('/why-dany-maid/')),
    array('label' => 'About', 'url' => home_url('/about/')),
    array('label' => 'Reviews', 'url' => home_url('/reviews/')),
    array('label' => 'Service Areas', 'url' => home_url('/service-areas/')),
    array('label' => 'Contact', 'url' => home_url('/contact/')),
    array('label' => 'Careers', 'url' => home_url('/careers/')),
  );
  return array_map(function ($link) {
    return $link + array('children' => array());
  }, $links);
}

// Converts an assigned WP menu into a nested tree; falls back to the defaults above.
function dm_menu_tree($location, $fallback) {
  $locations = get_nav_menu_locations();
  if (empty($locations[$location])) {
    return $fallback;
  }
  $items = wp_get_nav_menu_items($locations[$location]);
  if (!$items) {
    return $fallback;
  }

  $nodes = array();
  foreach ($items as $item) {
    $nodes[$item->ID] = array('label' => $item->title, 'url' => $item->url, 'parent' => (int) $item->menu_item_parent, 'children' => array());
  }
  $tree = array();
  // Walk bottom-up so each child already holds its own children when attached.
  foreach (array_reverse(array_keys($nodes)) as $id) {
    $node = $nodes[$id];
    if ($node['parent'] && isset($nodes[$node['parent']])) {
      array_unshift($nodes[$node['parent']]['children'], $node);
    } else {
      array_unshift($tree, $node);
    }
  }
  return $tree;
}

// Everything the Navbar and Footer React components need.
function dm_react_data() {
  return array(
    'homeUrl'      => home_url('/'),
    'quoteUrl'     => dm_quote_url(),
    'logo'         => dm_logo(),
    // All-white version of the logo for the dark footer (made from DANY-LOGO-scaled.png: colour → white, white outline → transparent)
    'footerLogo'   => dm_versioned_asset('assets/images/logo-white-900.webp'),
    'business'     => dm_business(),
    'social'       => dm_social_links(),
    'services'     => dm_service_list(),
    'serviceAreas' => dm_service_areas(),
    'areaGroups'   => dm_service_areas_by_county(),
    'primaryMenu'  => dm_menu_tree('primary', dm_default_primary_menu()),
    'footerMenu'   => dm_menu_tree('footer', dm_default_footer_menu()),
    'footerTagline' => dm_mod('footer_tagline'),
    'privacyUrl'   => get_privacy_policy_url(),
    'termsUrl'     => dm_page_url('terms-and-conditions'),
    // Every page template already ends with its own CTA (contact form or cta-band).
    'hideFooterCta' => is_front_page() || is_page(),
    'cookies'      => array(
      'title'   => dm_mod('cookie_title'),
      'message' => dm_mod('cookie_message'),
    ),
    'contact'      => array(
      'endpoint'       => rest_url('dany-maid/v1/contact'),
      'successMessage' => dm_mod('home_contact_success'),
    ),
    'careers'      => array(
      'endpoint' => rest_url('dany-maid/v1/careers'),
    ),
    'mail'         => dm_mail_settings(),
  );
}
