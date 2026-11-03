<?php
/**
 * Home · 05 Recurring priority: weekly / biweekly / monthly, without promising a fixed cleaner.
 */

$frequencies = array(
  'Weekly'   => dm_mod('home_recurring_weekly'),
  'Biweekly' => dm_mod('home_recurring_biweekly'),
  'Monthly'  => dm_mod('home_recurring_monthly'),
);
?>

<section class="relative overflow-hidden bg-brand-900 py-20 lg:py-28" aria-labelledby="recurring-title">
  <div class="pointer-events-none absolute -left-32 bottom-0 size-96 rounded-full bg-brand-700/40 blur-3xl" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -right-20 -top-20 size-80 rounded-full bg-leaf-500/15 blur-3xl" aria-hidden="true"></div>

  <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-20 lg:px-8">
    <div>
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Recurring house cleaning',
        'title'   => dm_mod('home_recurring_title'),
        'body'    => dm_mod('home_recurring_body'),
        'dark'    => true,
        'id'      => 'recurring-title',
      )); ?>
      <div data-reveal style="--reveal-delay: 150ms" class="mt-8 flex flex-col gap-3 sm:flex-row">
        <?php dm_button(dm_mod('home_recurring_cta'), home_url('/recurring-house-cleaning/'), 'light', array('track' => 'select_service', 'service' => 'recurring', 'source' => 'home')); ?>
        <?php dm_quote_cta('Get a Quote', 'recurring', 'ghost', array('service' => 'recurring')); ?>
      </div>
    </div>

    <ul class="grid gap-4">
      <?php $i = 0; foreach ($frequencies as $label => $text) : ?>
        <li data-reveal="right" style="--reveal-delay: <?php echo $i++ * 120; ?>ms" class="group flex items-start gap-5 rounded-3xl bg-white/[0.07] p-6 ring-1 ring-white/15 backdrop-blur-sm transition duration-500 hover:bg-white/[0.12] hover:ring-leaf-300/50">
          <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-leaf-500 text-brand-950 transition duration-700 group-hover:rotate-180"><?php echo dm_icon('arrow-path', 'size-6'); ?></span>
          <div>
            <h3 class="font-display text-2xl font-semibold text-white"><?php echo esc_html($label); ?></h3>
            <p class="mt-1 text-brand-100"><?php echo esc_html($text); ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
