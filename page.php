<?php
/**
 * Default page template (Privacy Policy, legal pages, any new page without a specific template):
 * branded hero + the page editor content.
 */

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'title' => get_the_title(),
    'cta'   => '',
  )); ?>

  <section class="bg-white py-16 lg:py-24">
    <div class="prose prose-lg mx-auto max-w-3xl px-4 sm:px-6 prose-headings:font-display prose-headings:text-brand-950 prose-a:text-brand-700 prose-strong:text-brand-950 prose-li:marker:text-leaf-600">
      <?php
      while (have_posts()) {
        the_post();
        the_content();
      }
      ?>
    </div>
  </section>

  <?php get_template_part('template-parts/components/cta-band'); ?>
</main>

<?php get_footer();
