<?php
/**
 * Template Name: Service Areas
 *
 * /service-areas/ hub (brief §09): only cities confirmed in the Customizer list, no fictitious
 * branches, and a human route for anyone outside the list. City landing pages (P1) link from here later.
 */

$business  = dm_business();
$home_base = $business['city'];
$faqs      = array(
  array('question' => 'Do you serve my area?', 'answer' => 'We are based in ' . $home_base . ' and serve households across nearby Sacramento-area communities, including the cities listed on this page. Share your ZIP code when you contact us and our team will confirm coverage for your address.'),
  array('question' => 'My city isn’t listed. Can I still ask?', 'answer' => 'Yes. Send us your ZIP code and a few details about your home, and our team will let you know whether we can help.'),
  array('question' => 'How can I request a quote?', 'answer' => 'Use the form on our Contact page or call ' . $business['phone'] . '. A member of our local team will follow up to confirm the details and next steps.'),
);

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow' => 'Service areas',
    'title'   => 'House Cleaning Across the Sacramento Area.',
    'intro'   => 'Based in ' . $home_base . ', we serve households across nearby Sacramento-area communities. Check your location when requesting a quote.',
    'background' => attachment_url_to_postid(wp_upload_dir()['baseurl'] . '/2026/11/California--scaled.jpg'),
  )); ?>

  <section class="bg-white py-20 lg:py-28" aria-labelledby="cities-title">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Where we clean',
        'title'   => 'Communities We Serve.',
        'body'    => 'Select a county or a city to see it on the map.',
        'align'   => 'center',
        'id'      => 'cities-title',
      )); ?>

      <!-- React: src/scripts/components/ServiceAreaMap.js (this list is the no-JS / SEO fallback) -->
      <div id="dm-area-map" data-reveal class="mt-14 min-h-96">
        <?php foreach (dm_service_areas_by_county() as $group) : ?>
          <h3 class="mt-8 font-display text-xl font-semibold text-brand-950 first:mt-0"><?php echo esc_html($group['county']); ?></h3>
          <ul class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4">
            <?php foreach ($group['cities'] as $city) : ?>
              <li class="flex items-center gap-2 rounded-xl bg-cream px-3 py-2.5 text-sm font-semibold text-brand-950">
                <?php echo dm_icon('map-pin', 'size-4 text-brand-600'); ?><?php echo esc_html($city); ?>, CA
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
      </div>

      <p data-reveal class="mx-auto mt-10 max-w-2xl text-center text-ink/70">Don’t see your city? <a href="<?php echo esc_url(dm_page_url('contact')); ?>" class="font-bold text-brand-700 hover:underline">Send us your ZIP code</a> and our team will let you know if we can help.</p>
    </div>
  </section>

  <!-- Services available in these areas -->
  <section class="bg-cream py-20 lg:py-24" aria-labelledby="area-services-title">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Our services',
        'title'   => 'Cleaning Services in Your Area.',
        'id'      => 'area-services-title',
      )); ?>
      <ul class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach (dm_service_list() as $i => $service) : ?>
          <li data-reveal style="--reveal-delay: <?php echo $i * 90; ?>ms">
            <a href="<?php echo esc_url($service['url']); ?>" data-track="select_service" data-service="<?php echo esc_attr($service['key']); ?>" data-source="service_areas" class="group flex h-full items-center gap-4 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-brand-900/5 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
              <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 transition duration-500 group-hover:bg-brand-700 group-hover:text-white"><?php echo dm_icon($service['icon'], 'size-6'); ?></span>
              <span class="flex-1 font-display text-lg font-semibold text-brand-950"><?php echo esc_html($service['title']); ?></span>
              <span class="text-brand-700 transition group-hover:translate-x-1"><?php echo dm_icon('arrow-right', 'size-5'); ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section class="bg-white py-20 lg:py-28" aria-labelledby="areas-faq-title">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
      <div class="lg:col-span-5">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => 'FAQ',
          'title'   => 'Questions About Our Service Area.',
          'id'      => 'areas-faq-title',
        )); ?>
      </div>
      <div class="lg:col-span-7">
        <?php get_template_part('template-parts/components/faq-list', null, array('items' => $faqs, 'name' => 'areas-faq')); ?>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/components/cta-band', null, array('title' => 'Check Your Area and Get a Quote.')); ?>
</main>

<?php get_footer();
