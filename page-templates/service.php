<?php
/**
 * Template Name: Service Page
 *
 * One template for every service (brief §07): hero → benefit → what's included (editable) →
 * pricing → process → FAQ → proof → CTA. Copy comes from dm_service_page() in inc/pages.php;
 * the approved checklist is typed into this page's WordPress editor.
 */

$page = dm_current_page();
$key  = $page && !empty($page['service']) ? $page['service'] : 'recurring';
$copy = dm_service_page($key);
$service = current(array_filter(dm_service_list(), function ($s) use ($key) {
  return $s['key'] === $key;
}));
$scope = dm_page_content();

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow'   => $copy['eyebrow'],
    'title'     => $copy['h1'],
    'intro'     => $copy['intro'],
    'cta'       => $copy['cta'],
    'service'   => $key,
    'secondary' => array('label' => 'See All Services', 'url' => dm_page_url('house-cleaning')),
    'image'     => $service['image'],
    'stock'     => $service['stock'],
  )); ?>

  <!-- Benefit -->
  <section class="bg-white py-20 lg:py-28" aria-labelledby="benefit-title">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-20 lg:px-8">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Why it helps',
        'title'   => $copy['why_title'],
        'body'    => $copy['why_body'],
        'id'      => 'benefit-title',
      )); ?>

      <ul class="grid gap-4">
        <?php foreach ($copy['highlights'] as $i => $highlight) : ?>
          <li data-reveal="right" style="--reveal-delay: <?php echo $i * 110; ?>ms" class="group flex items-center gap-5 rounded-3xl bg-cream p-6 transition duration-500 hover:-translate-y-0.5 hover:bg-white hover:shadow-xl hover:shadow-brand-900/5">
            <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-leaf-500 text-brand-950 transition duration-500 group-hover:rotate-6"><?php echo dm_icon('check', 'size-6'); ?></span>
            <span class="font-display text-xl font-semibold text-brand-950"><?php echo esc_html($highlight); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <?php if ($key === 'recurring') : ?>
      <div class="mx-auto mt-16 max-w-7xl px-4 sm:px-6 lg:px-8">
        <ul class="grid gap-4 md:grid-cols-3">
          <?php foreach (array('Weekly' => 'home_recurring_weekly', 'Biweekly' => 'home_recurring_biweekly', 'Monthly' => 'home_recurring_monthly') as $label => $mod) : ?>
            <li data-reveal class="rounded-3xl bg-brand-900 p-7 text-white">
              <span class="flex size-11 items-center justify-center rounded-xl bg-leaf-500 text-brand-950"><?php echo dm_icon('arrow-path', 'size-5'); ?></span>
              <h3 class="mt-5 font-display text-2xl font-semibold"><?php echo esc_html($label); ?></h3>
              <p class="mt-2 text-brand-100"><?php echo esc_html(dm_mod($mod)); ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
  </section>

  <!-- What's included -->
  <section class="bg-cream py-20 lg:py-28" aria-labelledby="scope-title">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
      <div class="lg:col-span-7">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => 'Scope',
          'title'   => 'What’s Included.',
          'id'      => 'scope-title',
        )); ?>
        <div data-reveal style="--reveal-delay: 120ms" class="mt-8 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-brand-900/5">
          <?php if ($scope) : ?>
            <div class="prose prose-lg max-w-none prose-headings:font-display prose-headings:text-brand-950 prose-a:text-brand-700 prose-strong:text-brand-950 prose-li:marker:text-leaf-600">
              <?php echo $scope; ?>
            </div>
          <?php else : ?>
            <p class="text-lg leading-relaxed text-ink/80">Every home is different, so we confirm exactly what your cleaning includes when we prepare your quote—including your priority areas and any special instructions.</p>
            <?php if (current_user_can('edit_pages')) : ?>
              <p class="mt-4 rounded-xl border-2 border-dashed border-brand-200 p-4 text-sm font-semibold text-brand-900">Pending: add the approved checklist for this service in the page editor (Pages → <?php echo esc_html(get_the_title()); ?>). Only editors see this note.</p>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>

      <aside data-reveal="right" class="lg:col-span-5 lg:pt-24">
        <div class="rounded-3xl bg-brand-900 p-8 text-white">
          <h3 class="font-display text-2xl font-semibold">Add-ons &amp; exclusions</h3>
          <p class="mt-3 leading-relaxed text-brand-100">Some tasks may require an add-on or a separate service. Our team will tell you before your visit what is and isn’t included, so there are no surprises.</p>
          <?php if ($key === 'deep') : ?>
            <p class="mt-3 leading-relaxed text-brand-100">Deep cleaning does not include restoration work such as water, fire, or mold damage remediation.</p>
          <?php endif; ?>
          <div class="mt-6">
            <?php dm_quote_cta('Ask About Your Home', 'scope', 'light', array('service' => $key)); ?>
          </div>
        </div>
      </aside>
    </div>
  </section>

  <?php get_template_part('template-parts/components/pricing-factors', null, array('bg' => 'white', 'service' => $key)); ?>

  <?php get_template_part('template-parts/home/steps'); ?>

  <!-- Service FAQ -->
  <section class="bg-white py-20 lg:py-28" aria-labelledby="service-faq-title">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
      <div class="lg:col-span-5">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => 'FAQ',
          'title'   => 'Questions About ' . $service['title'] . '.',
          'id'      => 'service-faq-title',
        )); ?>
      </div>
      <div class="lg:col-span-7">
        <?php get_template_part('template-parts/components/faq-list', null, array('items' => $copy['faq'], 'name' => 'service-faq')); ?>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/components/proof-strip', null, array('bg' => 'cream')); ?>

  <?php get_template_part('template-parts/components/cta-band', null, array(
    'title'   => $copy['h1'],
    'body'    => 'Share a few details about your home and our team will help you plan the next step.',
    'cta'     => $copy['cta'],
    'service' => $key,
  )); ?>
</main>

<?php get_footer();
