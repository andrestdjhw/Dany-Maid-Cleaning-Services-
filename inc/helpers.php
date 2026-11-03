<?php
/**
 * Small template helpers shared by the page templates.
 */

// Single quote destination (the Contact page, shared with the "Contact" menu item);
// the service/city context travels as query args.
function dm_quote_url($context = array()) {
  return add_query_arg(array_filter($context), home_url('/contact/'));
}

function dm_button_classes($variant = 'primary') {
  $base = 'group/btn inline-flex items-center justify-center gap-2 rounded-full px-6 py-3.5 text-base font-bold transition duration-300 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 focus-visible:outline-2 focus-visible:outline-offset-2';
  $variants = array(
    'primary'   => 'bg-brand-700 text-white shadow-sm shadow-brand-900/20 hover:bg-brand-800 focus-visible:outline-brand-700',
    'secondary' => 'border-2 border-brand-700 bg-white text-brand-800 hover:bg-brand-50 focus-visible:outline-brand-700',
    'light'     => 'bg-white text-brand-900 shadow-sm hover:bg-brand-50 focus-visible:outline-white',
    'ghost'     => 'border-2 border-white/70 text-white hover:bg-white/10 focus-visible:outline-white',
  );
  return $base . ' ' . $variants[$variant];
}

/**
 * Generic link button. $track adds data-track attributes read by src/index.js.
 */
function dm_button($label, $url, $variant = 'primary', $track = array()) {
  $attrs = '';
  foreach ($track as $name => $value) {
    $attrs .= sprintf(' data-%s="%s"', esc_attr($name), esc_attr($value));
  }
  printf(
    '<a href="%s" class="%s"%s>%s<span class="transition-transform duration-300 group-hover/btn:translate-x-1">%s</span></a>',
    esc_url($url),
    esc_attr(dm_button_classes($variant)),
    $attrs,
    esc_html($label),
    dm_icon('arrow-right', 'size-5')
  );
}

// Reusable "Get a Quote" CTA: same destination everywhere, tracked as quote_cta_click.
function dm_quote_cta($label, $position, $variant = 'primary', $context = array()) {
  dm_button($label, dm_quote_url($context), $variant, array(
    'track'    => 'quote_cta_click',
    'position' => $position,
  ));
}

function dm_text_link($label, $url, $track = array()) {
  $attrs = '';
  foreach ($track as $name => $value) {
    $attrs .= sprintf(' data-%s="%s"', esc_attr($name), esc_attr($value));
  }
  printf(
    '<a href="%s" class="group inline-flex items-center gap-2 font-bold text-brand-700 underline-offset-4 hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700"%s>%s<span class="transition group-hover:translate-x-0.5">%s</span></a>',
    esc_url($url),
    $attrs,
    esc_html($label),
    dm_icon('arrow-right', 'size-5')
  );
}

// Theme stock photo (assets/images/{name}-{800|1400}.webp) as a responsive <img>.
function dm_stock_image($name, $alt, $class, $sizes, $eager = false) {
  $file = get_theme_file_path("/assets/images/{$name}-1400.webp");
  if (!file_exists($file)) {
    return '';
  }
  list($width, $height) = getimagesize($file);
  return sprintf(
    '<img src="%1$s" srcset="%2$s 800w, %1$s 1400w" sizes="%3$s" width="%4$d" height="%5$d" alt="%6$s" class="%7$s" loading="%8$s" decoding="async"%9$s>',
    esc_url(get_theme_file_uri("/assets/images/{$name}-1400.webp")),
    esc_url(get_theme_file_uri("/assets/images/{$name}-800.webp")),
    esc_attr($sizes),
    $width,
    $height,
    esc_attr($alt),
    esc_attr($class),
    $eager ? 'eager' : 'lazy',
    $eager ? ' fetchpriority="high"' : ''
  );
}

// Renders a Customizer image, or the theme's illustrative stock photo while no real photo is set.
function dm_photo($id, $stock, $alt, $class, $sizes, $eager = false) {
  if ($id) {
    echo wp_get_attachment_image($id, 'large', false, array(
      'class'         => $class,
      'alt'           => $alt,
      'sizes'         => $sizes,
      'loading'       => $eager ? 'eager' : 'lazy',
      'fetchpriority' => $eager ? 'high' : 'auto',
    ));
    return;
  }
  // Stock photos are illustrative, so they get a neutral alt instead of claiming to show the team.
  echo dm_stock_image($stock, '', $class, $sizes, $eager);
}

// Live reviews widget (Trustindex plugin). Rendered only if its shortcode is registered,
// so deactivating the plugin falls back to the manual testimonials instead of printing raw text.
function dm_reviews_widget() {
  $shortcode = trim(dm_mod('home_reviews_widget'));
  if ($shortcode === '' || !preg_match('/^\[([\w-]+)/', $shortcode, $tag) || !shortcode_exists($tag[1])) {
    return '';
  }
  return trim(do_shortcode($shortcode));
}

// Rendered WordPress editor content of the current page ('' when empty), used as each
// template's editable block (e.g. a service's approved checklist).
function dm_page_content() {
  $post = get_queried_object();
  if (!$post instanceof WP_Post || trim($post->post_content) === '') {
    return '';
  }
  return apply_filters('the_content', $post->post_content);
}

// FAQ items from the Customizer; empty questions are skipped.
function dm_faqs() {
  $items = array();
  for ($i = 1; $i <= 6; $i++) {
    $question = trim(dm_mod("home_faq_{$i}_title"));
    $answer   = trim(dm_mod("home_faq_{$i}_text"));
    if ($question !== '' && $answer !== '') {
      $items[] = array('question' => $question, 'answer' => $answer);
    }
  }
  return $items;
}

function dm_testimonials() {
  $items = array();
  for ($i = 1; $i <= 3; $i++) {
    $quote = trim(dm_mod("testimonial_{$i}_quote"));
    if ($quote === '') {
      continue;
    }
    $items[] = array(
      'quote'    => $quote,
      'author'   => dm_mod("testimonial_{$i}_author"),
      'platform' => dm_mod("testimonial_{$i}_platform"),
      'url'      => dm_mod("testimonial_{$i}_url"),
    );
  }
  return $items;
}
