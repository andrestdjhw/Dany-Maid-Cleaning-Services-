<?php
/**
 * Image-led service card (photo fills the card, copy sits on a gradient at the bottom).
 * Args: service (item from dm_service_list()), featured (bool), source (tracking page name),
 *       layout ('carousel' fixed width, stacked full-width landscape on phones | 'grid' fills its column).
 */

$service  = $args['service'];
$featured = !empty($args['featured']);
$source   = isset($args['source']) ? $args['source'] : 'home';
$sizing   = isset($args['layout']) && $args['layout'] === 'grid'
  ? 'aspect-[3/4] w-full'
  : 'aspect-[4/3] w-full sm:mr-6 sm:aspect-[3/4] sm:w-80 sm:shrink-0 lg:w-[22rem]';
?>

<article class="group relative <?php echo $sizing; ?> overflow-hidden rounded-3xl bg-brand-900 shadow-lg shadow-brand-900/15 transition duration-500 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-brand-900/25 <?php echo $featured ? 'ring-2 ring-leaf-500 ring-offset-2 ring-offset-cream' : ''; ?>">
  <?php
  dm_photo(
    $service['image'],
    $service['stock'],
    '',
    'absolute inset-0 size-full object-cover transition duration-1000 ease-out group-hover:scale-110',
    '(min-width: 1024px) 352px, (min-width: 640px) 320px, 100vw'
  );
  ?>
  <div class="absolute inset-0 bg-linear-to-t from-brand-950/95 via-brand-950/35 to-brand-950/0 transition duration-500 group-hover:via-brand-950/50" aria-hidden="true"></div>

  <?php if ($featured) : ?>
    <span class="absolute left-5 top-5 rounded-full bg-leaf-500 px-3 py-1 text-xs font-extrabold uppercase tracking-wide text-brand-950 shadow">Our core service</span>
  <?php endif; ?>

  <div class="absolute inset-x-0 bottom-0 p-6">
    <span class="flex size-11 items-center justify-center rounded-xl bg-white/15 text-white ring-1 ring-white/25 backdrop-blur transition duration-500 group-hover:-rotate-6 group-hover:bg-leaf-500 group-hover:text-brand-950 group-hover:ring-leaf-500">
      <?php echo dm_icon($service['icon'], 'size-6'); ?>
    </span>
    <h3 class="mt-4 font-display text-2xl font-semibold text-white"><?php echo esc_html($service['title']); ?></h3>
    <p class="mt-1.5 line-clamp-2 text-sm leading-relaxed text-brand-100"><?php echo esc_html($service['text']); ?></p>
    <a href="<?php echo esc_url($service['url']); ?>" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-white after:absolute after:inset-0 after:rounded-3xl focus-visible:outline-none focus-visible:after:outline-2 focus-visible:after:-outline-offset-4 focus-visible:after:outline-white" data-track="select_service" data-service="<?php echo esc_attr($service['key']); ?>" data-source="<?php echo esc_attr($source); ?>">
      Learn more<span class="sr-only"> about <?php echo esc_html($service['title']); ?></span>
      <span class="transition duration-300 group-hover:translate-x-1.5"><?php echo dm_icon('arrow-right', 'size-4'); ?></span>
    </a>
  </div>
</article>
