<?php
/**
 * Home · 08 Service areas + closing CTA. Only cities confirmed in the Customizer list.
 * Background: California map video (lazy-loaded by src/scripts/bg-video.js), with the cities
 * scrolling in rows that alternate direction. Each row renders its cities three times so the
 * loop is seamless; the copies are hidden from screen readers.
 */

$home_base = dm_business()['city'];
$cities    = dm_service_areas();
$durations = array('34s', '40s', '37s');

// Split into up to 3 balanced rows (13 cities → 5, 4, 4), keeping the Customizer order.
$rows   = array();
$offset = 0;
for ($r = 0; $r < 3; $r++) {
  $size = intdiv(count($cities), 3) + ($r < count($cities) % 3 ? 1 : 0);
  if ($size > 0) {
    $rows[] = array_slice($cities, $offset, $size);
  }
  $offset += $size;
}
?>

<section class="relative overflow-hidden bg-brand-50 py-20 lg:py-28" aria-labelledby="areas-title">
  <video
    data-bg-video
    data-src-lg="<?php echo esc_url(get_theme_file_uri('/assets/video/california-map-720.mp4')); ?>"
    data-src-sm="<?php echo esc_url(get_theme_file_uri('/assets/video/california-map-540.mp4')); ?>"
    poster="<?php echo esc_url(get_theme_file_uri('/assets/images/california-map-poster.webp')); ?>"
    class="absolute inset-0 size-full object-cover"
    muted loop playsinline preload="none" aria-hidden="true"
  ></video>
  <!-- Light veil keeps the copy readable; lighter on the right so the map shows through -->
  <div class="absolute inset-0 bg-linear-to-b from-brand-50/90 via-brand-50/75 to-brand-50/90 lg:bg-linear-to-r lg:from-brand-50/95 lg:via-brand-50/70 lg:to-brand-50/35" aria-hidden="true"></div>

  <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
    <div class="lg:col-span-5">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Service areas',
        'title'   => dm_mod('home_areas_title'),
        'body'    => dm_mod('home_areas_body'),
        'id'      => 'areas-title',
      )); ?>
      <div data-reveal style="--reveal-delay: 150ms" class="mt-8 flex flex-col gap-3 sm:flex-row">
        <?php dm_quote_cta('Get a Quote', 'service_areas'); ?>
        <?php dm_button(dm_mod('home_areas_cta'), dm_page_url('service-areas'), 'secondary'); ?>
      </div>
    </div>

    <div data-reveal class="dm-marquee min-w-0 space-y-3 overflow-hidden lg:col-span-7 [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)]">
      <p class="sr-only">We serve <?php echo esc_html(implode(', ', $cities)); ?>.</p>
      <?php foreach ($rows as $r => $row) : ?>
        <div class="dm-marquee-row flex w-max <?php echo $r % 2 ? '' : 'dm-marquee-reverse'; ?>" style="--marquee-duration: <?php echo esc_attr($durations[$r % 3]); ?>" aria-hidden="true">
          <?php for ($copy = 0; $copy < 3; $copy++) : ?>
            <ul class="flex py-1.5" <?php echo $copy ? 'data-marquee-copy' : ''; ?>>
              <?php foreach ($row as $city) :
                $is_base = strcasecmp($city, $home_base) === 0; ?>
                <li class="mr-3 flex items-center gap-2 whitespace-nowrap rounded-2xl px-4 py-3 text-sm font-semibold shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md sm:gap-3 sm:px-5 sm:py-3.5 sm:text-base <?php echo $is_base ? 'bg-brand-700 text-white shadow-md' : 'bg-white/90 text-brand-950 ring-1 ring-brand-900/10 backdrop-blur'; ?>">
                  <span class="<?php echo $is_base ? 'text-leaf-300' : 'text-brand-600'; ?>"><?php echo dm_icon('map-pin', 'size-5'); ?></span>
                  <span>
                    <?php echo esc_html($city); ?>
                    <?php if ($is_base) : ?><span class="block text-xs font-bold uppercase tracking-wide text-brand-100">Home base</span><?php endif; ?>
                  </span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endfor; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
