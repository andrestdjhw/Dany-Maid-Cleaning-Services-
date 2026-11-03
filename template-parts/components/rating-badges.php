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
          <a href="<?php echo esc_url($r['url']); ?>" target="_blank" rel="noopener" class="group flex h-full items-center gap-5 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-brand-900/10 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/10 hover:ring-brand-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
            <span class="font-display text-5xl font-semibold text-brand-950 tabular-nums" data-count="<?php echo esc_attr($r['rating']); ?>"><?php echo esc_html($r['rating']); ?></span>
            <span class="flex flex-col gap-1">
              <span class="flex gap-0.5 text-amber-500" aria-hidden="true"><?php echo dm_icon('star', 'size-5'); ?></span>
              <span class="font-bold text-brand-950"><?php echo esc_html($r['platform']); ?> rating</span>
              <?php if ($r['count']) : ?>
                <span class="text-sm text-ink/70"><span class="tabular-nums" data-count="<?php echo esc_attr($r['count']); ?>"><?php echo esc_html($r['count']); ?></span> reviews · <span class="whitespace-nowrap font-semibold text-brand-700 group-hover:underline">See profile</span></span>
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
