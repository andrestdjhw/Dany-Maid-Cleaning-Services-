<?php
/**
 * Home · 08 Service areas + closing CTA. Only cities confirmed in the Customizer list.
 */

$home_base = dm_business()['city'];
?>

<section class="bg-brand-50 py-20 lg:py-28" aria-labelledby="areas-title">
  <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
    <div class="lg:col-span-5">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Service areas',
        'title'   => dm_mod('home_areas_title'),
        'body'    => dm_mod('home_areas_body'),
        'id'      => 'areas-title',
      )); ?>
      <div data-reveal style="--reveal-delay: 150ms" class="mt-8 flex flex-col gap-3 sm:flex-row">
        <?php dm_quote_cta('Get a Quote', 'service_areas'); ?>
        <?php dm_button(dm_mod('home_areas_cta'), home_url('/service-areas/'), 'secondary'); ?>
      </div>
    </div>

    <ul class="grid content-start grid-cols-2 gap-2 sm:gap-3 lg:col-span-7 lg:grid-cols-3">
      <?php foreach (dm_service_areas() as $i => $city) :
        $is_base = strcasecmp($city, $home_base) === 0; ?>
        <li data-reveal="zoom" style="--reveal-delay: <?php echo $i * 50; ?>ms" class="flex items-center gap-2 rounded-2xl transition duration-300 hover:-translate-y-0.5 hover:shadow-md px-3 py-3 text-sm font-semibold sm:gap-3 sm:px-4 sm:py-3.5 sm:text-base <?php echo $is_base ? 'bg-brand-700 text-white shadow-md' : 'bg-white text-brand-950 ring-1 ring-brand-900/10'; ?>">
          <span class="<?php echo $is_base ? 'text-leaf-300' : 'text-brand-600'; ?>"><?php echo dm_icon('map-pin', 'size-5'); ?></span>
          <span>
            <?php echo esc_html($city); ?>
            <?php if ($is_base) : ?><span class="block text-xs font-bold uppercase tracking-wide text-brand-100">Home base</span><?php endif; ?>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
