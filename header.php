<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class('bg-white font-sans text-ink antialiased'); ?>>
    <?php wp_body_open(); ?>
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-bold focus:text-brand-800 focus:shadow-lg">Skip to content</a>

    <!-- React: src/scripts/components/Navbar.js -->
    <div id="dm-navbar" class="sticky top-(--dm-admin-bar) z-50 min-h-20 bg-white lg:min-h-32">
      <noscript>
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="font-display text-2xl font-bold text-brand-800">Dany Maid</a>
          <a href="<?php echo esc_url(dm_quote_url()); ?>" class="<?php echo esc_attr(dm_button_classes()); ?>">Get a Quote</a>
        </div>
      </noscript>
    </div>
