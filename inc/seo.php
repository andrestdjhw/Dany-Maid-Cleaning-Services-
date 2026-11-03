<?php
/**
 * Basic SEO output for the home page and LocalBusiness structured data.
 * Title/meta/OG step aside when Yoast or Rank Math is active.
 */

function dm_has_seo_plugin() {
  return defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION');
}

function dm_document_title($title) {
  if (is_front_page() && !dm_has_seo_plugin() && dm_mod('home_seo_title')) {
    return dm_mod('home_seo_title');
  }
  return $title;
}

add_filter('pre_get_document_title', 'dm_document_title');

function dm_head_meta() {
  if (!is_front_page() || dm_has_seo_plugin()) {
    return;
  }
  $title       = dm_mod('home_seo_title');
  $description = dm_mod('home_seo_description');
  $url         = home_url('/');
  $logo        = dm_logo();
  ?>
  <meta name="description" content="<?php echo esc_attr($description); ?>">
  <?php if (!is_singular()) : ?>
    <link rel="canonical" href="<?php echo esc_url($url); ?>">
  <?php endif; ?>
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Dany Maid">
  <meta property="og:title" content="<?php echo esc_attr($title); ?>">
  <meta property="og:description" content="<?php echo esc_attr($description); ?>">
  <meta property="og:url" content="<?php echo esc_url($url); ?>">
  <?php if ($logo) : ?>
    <meta property="og:image" content="<?php echo esc_url($logo['url']); ?>">
  <?php endif; ?>
  <meta name="twitter:card" content="summary_large_image">
  <?php
}

add_action('wp_head', 'dm_head_meta', 1);

// No aggregateRating on purpose: self-served review markup breaks search engine rules.
function dm_structured_data() {
  if (!is_front_page()) {
    return;
  }
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
    'areaServed'   => array_map(function ($city) {
      return array('@type' => 'City', 'name' => $city . ', CA');
    }, dm_service_areas()),
    'sameAs'       => wp_list_pluck(dm_social_links(), 'url'),
  );
  if ($logo) {
    $local_business['logo']  = $logo['url'];
    $local_business['image'] = $logo['url'];
  }

  $website = array(
    '@context'  => 'https://schema.org',
    '@type'     => 'WebSite',
    'name'      => 'Dany Maid',
    'url'       => home_url('/'),
    'publisher' => array('@id' => home_url('/#business')),
  );

  $schemas = array($local_business, $website);

  // FAQPage mirrors the visible FAQ section exactly (search engines require that).
  if ($faqs = dm_faqs()) {
    $schemas[] = array(
      '@context'   => 'https://schema.org',
      '@type'      => 'FAQPage',
      'mainEntity' => array_map(function ($faq) {
        return array(
          '@type'          => 'Question',
          'name'           => $faq['question'],
          'acceptedAnswer' => array('@type' => 'Answer', 'text' => $faq['answer']),
        );
      }, $faqs),
    );
  }

  foreach ($schemas as $schema) {
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . "</script>\n";
  }
}

add_action('wp_head', 'dm_structured_data');
