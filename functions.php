<?php

require_once get_theme_file_path('/inc/site-data.php');
require_once get_theme_file_path('/inc/customizer.php');
require_once get_theme_file_path('/inc/helpers.php');
require_once get_theme_file_path('/inc/icons.php');
require_once get_theme_file_path('/inc/seo.php');
require_once get_theme_file_path('/inc/contact.php');
require_once get_theme_file_path('/inc/careers.php');
require_once get_theme_file_path('/inc/pages.php');
require_once get_theme_file_path('/inc/scope.php');
require_once get_theme_file_path('/inc/backup.php');

function dm_load_assets() {
  $asset = include get_theme_file_path('/build/index.asset.php');

  wp_enqueue_style('dm-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Nunito+Sans:opsz,wght@6..12,400;6..12,600;6..12,700;6..12,800&display=swap', array(), null);
  wp_enqueue_style('ourmaincss', get_theme_file_uri('/build/index.css'), array(), filemtime(get_theme_file_path('/build/index.css')));

  wp_enqueue_script('ourmainjs', get_theme_file_uri('/build/index.js'), $asset['dependencies'], $asset['version'], true);
  wp_add_inline_script('ourmainjs', 'window.danyMaid = ' . wp_json_encode(dm_react_data()) . ';', 'before');
}

add_action('wp_enqueue_scripts', 'dm_load_assets');

function dm_resource_hints($urls, $relation_type) {
  if ($relation_type === 'preconnect') {
    $urls[] = 'https://fonts.googleapis.com';
    $urls[] = array('href' => 'https://fonts.gstatic.com', 'crossorigin');
  }
  return $urls;
}

add_filter('wp_resource_hints', 'dm_resource_hints', 10, 2);

// Enables the scroll-reveal styles before first paint. If the main bundle never runs,
// the class is removed again so content is never left hidden.
function dm_js_class() {
  echo "<script>document.documentElement.classList.add('dm-js');setTimeout(function(){if(!window.dmRevealReady)document.documentElement.classList.remove('dm-js')},3500)</script>\n";
}

add_action('wp_head', 'dm_js_class', 0);

// Google Consent Mode v2 defaults. Must print before GTM/GA4 so no tag runs without consent;
// a choice saved earlier (src/scripts/consent.js) is re-applied on every page load.
function dm_consent_defaults() {
  ?>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('consent', 'default', {ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied', analytics_storage: 'denied', functionality_storage: 'granted', security_storage: 'granted', wait_for_update: 500});
    try {
      var dmConsent = JSON.parse(localStorage.getItem('dm_consent'));
      if (dmConsent && dmConsent.v === 1 && Date.now() - dmConsent.ts < 180 * 864e5) {
        var dmAds = dmConsent.marketing ? 'granted' : 'denied';
        gtag('consent', 'update', {analytics_storage: dmConsent.analytics ? 'granted' : 'denied', ad_storage: dmAds, ad_user_data: dmAds, ad_personalization: dmAds});
      }
    } catch (e) {}
  </script>
  <?php
}

add_action('wp_head', 'dm_consent_defaults', 0);

function dm_add_support() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo', array('flex-width' => true, 'flex-height' => true));
  add_theme_support('html5', array('search-form', 'gallery', 'caption', 'style', 'script'));

  register_nav_menus(array(
    'primary' => 'Primary Navigation (Navbar)',
    'footer'  => 'Footer Company Links',
  ));
}

add_action('after_setup_theme', 'dm_add_support');
