<?php
/**
 * Home · 02 Services by need: continuous horizontal carousel of image-led cards,
 * recurring highlighted as the core service.
 * The card list is rendered three times so the loop never shows a gap on wide screens;
 * the copies are inert and hidden from screen readers.
 */

$services = dm_service_list();
?>

<section id="services" class="scroll-mt-28 overflow-hidden bg-cream py-20 lg:py-28" aria-labelledby="services-title">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <?php get_template_part('template-parts/components/section-heading', null, array(
      'eyebrow' => 'Our services',
      'title'   => dm_mod('home_services_title'),
      'body'    => dm_mod('home_services_body'),
      'align'   => 'center',
      'id'      => 'services-title',
    )); ?>
  </div>

  <div data-reveal class="dm-carousel mt-14 [mask-image:linear-gradient(to_right,transparent,black_6%,black_94%,transparent)]">
    <div class="dm-carousel-track flex w-max py-4">
      <?php for ($copy = 0; $copy < 3; $copy++) : ?>
        <div class="flex" <?php echo $copy ? 'aria-hidden="true" inert' : ''; ?>>
          <?php foreach ($services as $service) {
            get_template_part('template-parts/components/service-card', null, array(
              'service'  => $service,
              'featured' => $service['key'] === 'recurring',
            ));
          } ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>

  <div data-reveal class="mt-10 text-center">
    <?php dm_button(dm_mod('home_services_cta'), home_url('/house-cleaning/'), 'secondary'); ?>
  </div>
</section>
