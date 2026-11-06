<?php

get_header(); ?>

<main id="main">
  <!-- Hero + city ribbon fill the first screen below the sticky header -->
  <div class="flex min-h-[calc(100svh-var(--dm-header)-var(--dm-admin-bar)-var(--dm-bottom-bar))] flex-col">
    <?php get_template_part('template-parts/home/hero'); ?>
    <?php get_template_part('template-parts/home/ribbon'); ?>
  </div>

  <?php
  // Remaining home sections, in order. Each one lives in template-parts/home/{name}.php.
  foreach (array('services', 'reviews', 'trust', 'recurring', 'team', 'steps', 'areas', 'faq', 'contact') as $section) {
    get_template_part('template-parts/home/' . $section);
  }
  ?>
</main>

<?php get_footer();
