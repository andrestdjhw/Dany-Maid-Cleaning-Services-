<?php

get_header(); ?>

<main id="main">
  <?php
  // Home sections, in order. Each one lives in template-parts/home/{name}.php.
  foreach (array('hero', 'ribbon', 'services', 'reviews', 'trust', 'recurring', 'team', 'steps', 'areas', 'faq', 'contact') as $section) {
    get_template_part('template-parts/home/' . $section);
  }
  ?>
</main>

<?php get_footer();
