<?php
/**
 * Home · moving ribbon of verified service areas between the hero and the services section.
 * The list is rendered twice for a seamless loop; the copy is hidden from screen readers.
 * CTA turquoise with white bold text, like the buttons and the top bar.
 */

$cities = dm_service_areas();
if (!$cities) {
  return;
}
?>

<div class="group overflow-hidden bg-cta py-4 text-white">
  <p class="sr-only">Serving <?php echo esc_html(implode(', ', $cities)); ?>.</p>
  <div class="flex w-max animate-marquee group-hover:[animation-play-state:paused]" aria-hidden="true">
    <?php for ($copy = 0; $copy < 2; $copy++) : ?>
      <ul class="flex shrink-0 items-center">
        <?php foreach ($cities as $city) : ?>
          <li class="flex items-center gap-6 pr-6 font-display text-lg font-semibold whitespace-nowrap">
            <?php echo esc_html($city); ?>
            <span class="text-white/75"><?php echo dm_icon('sparkles', 'size-4'); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endfor; ?>
  </div>
</div>
