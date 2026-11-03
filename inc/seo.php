<?php
/**
 * Basic SEO output: title/meta/OG for the home page and the registered pages (inc/pages.php),
 * plus LocalBusiness, BreadcrumbList and Service structured data.
 * Title/meta/OG step aside when Yoast or Rank Math is active.
 */

function dm_has_seo_plugin() {
  return defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION');
}

// Title/description/url for the current view, or null when the theme has nothing specific.
function dm_seo_for_current() {
  if (is_front_page()) {
    return array('title' => dm_mod('home_seo_title'), 'description' => dm_mod('home_seo_description'), 'url' => home_url('/'));
  }
  $page = dm_current_page();
  if ($page) {
    return array('title' => $page['seo_title'], 'description' => $page['description'], 'url' => get_permalink(get_queried_object_id()));
  }
  return null;
}

function dm_document_title($title) {
  $seo = dm_has_seo_plugin() ? null : dm_seo_for_current();
  return $seo && $seo['title'] ? $seo['title'] : $title;
}

add_filter('pre_get_document_title', 'dm_document_title');

function dm_head_meta() {
  $seo = dm_has_seo_plugin() ? null : dm_seo_for_current();
  if (!$seo) {
    return;
  }
  $logo = dm_logo();
  ?>
  <meta name="description" content="<?php echo esc_attr($seo['description']); ?>">
  <?php if (!is_singular()) : ?>
    <link rel="canonical" href="<?php echo esc_url($seo['url']); ?>">
  <?php endif; ?>
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Dany Maid">
  <meta property="og:title" content="<?php echo esc_attr($seo['title']); ?>">
  <meta property="og:description" content="<?php echo esc_attr($seo['description']); ?>">
  <meta property="og:url" content="<?php echo esc_url($seo['url']); ?>">
  <?php if ($logo) : ?>
    <meta property="og:image" content="<?php echo esc_url($logo['url']); ?>">
  <?php endif; ?>
  <meta name="twitter:card" content="summary_large_image">
  <?php
}

add_action('wp_head', 'dm_head_meta', 1);

function dm_print_schema($schema) {
  echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
}

function dm_area_served() {
  return array_map(function ($city) {
    return array('@type' => 'City', 'name' => $city . ', CA');
  }, dm_service_areas());
}

// No aggregateRating on purpose: self-served review markup breaks search engine rules.
function dm_structured_data() {
  if (is_front_page()) {
    $business = dm_business();
    $logo     = dm_logo();

    $local_business = array(
      '@context'     => 'https://schema.org',
      '@type'        => 'LocalBusiness',
      '@id'          => home_url('/#business'),
      'name'         => $business['name'],
      'legalName'    => $business['legalName'],
      'url'          => home_url('/'),
      'telephone'    => $business['phone'],
      'email'        => $business['email'],
      'foundingDate' => '2013',
      'address'      => array(
        '@type'           => 'PostalAddress',
        'streetAddress'   => $business['street'],
        'addressLocality' => $business['city'],
        'addressRegion'   => $business['region'],
        'postalCode'      => $business['zip'],
        'addressCountry'  => 'US',
      ),
      'areaServed'   => dm_area_served(),
      'sameAs'       => wp_list_pluck(dm_social_links(), 'url'),
    );
    if ($logo) {
      $local_business['logo']  = $logo['url'];
      $local_business['image'] = $logo['url'];
    }

    dm_print_schema($local_business);
    dm_print_schema(array(
      '@context'  => 'https://schema.org',
      '@type'     => 'WebSite',
      'name'      => 'Dany Maid',
      'url'       => home_url('/'),
      'publisher' => array('@id' => home_url('/#business')),
    ));
    return;
  }

  if (!is_page()) {
    return;
  }

  dm_print_schema(array(
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => array_map(function ($crumb, $i) {
      return array('@type' => 'ListItem', 'position' => $i + 1, 'name' => $crumb['label'], 'item' => $crumb['url']);
    }, dm_breadcrumbs(), array_keys(dm_breadcrumbs())),
  ));

  $page = dm_current_page();
  if ($page && !empty($page['service'])) {
    dm_print_schema(array(
      '@context'    => 'https://schema.org',
      '@type'       => 'Service',
      'name'        => $page['title'],
      'serviceType' => $page['title'],
      'description' => $page['description'],
      'url'         => get_permalink(get_queried_object_id()),
      'provider'    => array('@type' => 'LocalBusiness', '@id' => home_url('/#business'), 'name' => 'Dany Maid'),
      'areaServed'  => dm_area_served(),
    ));
  }
}

add_action('wp_head', 'dm_structured_data');
