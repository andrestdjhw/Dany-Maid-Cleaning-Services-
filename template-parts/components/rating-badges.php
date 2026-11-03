<?php
/**
 * Google / Yelp rating badges linking to the real profiles.
 * Args: variant => 'compact' (inline, hero) | 'card' (larger, proof sections).
 */

$variant = isset($args['variant']) ? $args['variant'] : 'compact';
$ratings = dm_ratings();
if (!$ratings) {
  return;
}
?>

<?php if ($variant === 'compact') : ?>
  <ul class="flex flex-wrap items-center gap-3" aria-label="Customer ratings">
    <?php foreach ($ratings as $r) : ?>
      <li>
        <a href="<?php echo esc_url($r['url']); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm shadow-sm ring-1 ring-brand-900/10 transition hover:ring-brand-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
          <span class="text-amber-500"><?php echo dm_icon('star', 'size-4'); ?></span>
          <span class="font-extrabold text-brand-950"><?php echo esc_html($r['rating']); ?></span>
          <span class="text-ink/70">on <?php echo esc_html($r['platform']); ?><?php if ($r['count']) : ?> · <?php echo esc_html($r['count']); ?> reviews<?php endif; ?></span>
          <span class="sr-only">(opens in a new tab)</span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else : ?>
  <div>
    <ul class="grid gap-4 sm:grid-cols-2">
      <?php foreach ($ratings as $r) : ?>
        <li>
          <a href="<?php echo esc_url($r['url']); ?>" target="_blank" rel="noopener" class="group relative flex h-full items-center gap-5 overflow-hidden rounded-3xl bg-linear-to-br from-brand-800 to-leaf-700 p-6 text-white shadow-lg shadow-brand-900/20 transition duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-brand-900/30 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
            <span class="pointer-events-none absolute -bottom-6 -right-6 text-white/10 transition duration-700 group-hover:rotate-12 group-hover:scale-110" aria-hidden="true"><?php echo dm_brand_icon(strtolower($r['platform']), 'size-32'); ?></span>
            <span class="relative font-display text-5xl font-semibold tabular-nums" data-count="<?php echo esc_attr($r['rating']); ?>"><?php echo esc_html($r['rating']); ?></span>
            <span class="relative flex flex-col gap-1">
              <span class="flex gap-0.5 text-amber-300" aria-hidden="true"><?php for ($s = 0; $s < 5; $s++) { echo dm_icon('star', 'size-4'); } ?></span>
              <span class="font-bold"><?php echo esc_html($r['platform']); ?> rating</span>
              <?php if ($r['count']) : ?>
                <span class="text-sm text-brand-50"><span class="tabular-nums" data-count="<?php echo esc_attr($r['count']); ?>"><?php echo esc_html($r['count']); ?></span> reviews · <span class="whitespace-nowrap font-bold text-white underline-offset-4 group-hover:underline">See profile</span></span>
              <?php endif; ?>
              <span class="sr-only">(opens in a new tab)</span>
            </span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if (dm_mod('ratings_date')) : ?>
      <p class="mt-3 text-sm text-ink/60">Ratings as listed on each platform, <?php echo esc_html(dm_mod('ratings_date')); ?>.</p>
    <?php endif; ?>
  </div>
<?php endif; ?>
