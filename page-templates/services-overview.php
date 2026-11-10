<?php
/**
 * Template Name: Services Overview
 *
 * /house-cleaning/: overview of every residential service, linking to each service page.
 */

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow' => 'Our services',
    'title'   => 'House Cleaning Services in the Sacramento Area.',
    'intro'   => 'A regular routine, a deeper reset, or a new chapter in a new home. We’ll help you find a service that fits.',
    'stock'   => 'hero-living-room',
  )); ?>

  <section class="bg-white py-20 lg:py-28" aria-labelledby="services-list-title">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Choose a service',
        'title'   => dm_mod('home_services_title'),
        'align'   => 'center',
        'id'      => 'services-list-title',
      )); ?>

      <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <?php foreach (dm_service_list() as $i => $service) : ?>
          <div data-reveal style="--reveal-delay: <?php echo $i * 110; ?>ms">
            <?php get_template_part('template-parts/components/service-card', null, array(
              'service'  => $service,
              'featured' => $service['key'] === 'recurring',
              'source'   => 'services_overview',
              'layout'   => 'grid',
            )); ?>
          </div>
        <?php endforeach; ?>
      </div>

      <?php if ($content = dm_page_content()) : ?>
        <div data-reveal class="prose prose-lg mx-auto mt-16 max-w-3xl prose-headings:font-display prose-headings:text-brand-950 prose-a:text-brand-700">
          <?php echo $content; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <?php get_template_part('template-parts/home/recurring'); ?>
  <?php get_template_part('template-parts/home/steps'); ?>
  <?php get_template_part('template-parts/components/pricing-factors', null, array('bg' => 'white')); ?>
  <?php get_template_part('template-parts/components/proof-strip', null, array('bg' => 'cream')); ?>
  <?php get_template_part('template-parts/components/cta-band'); ?>
</main>

<?php get_footer();
