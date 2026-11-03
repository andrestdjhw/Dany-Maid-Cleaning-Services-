<?php
/**
 * Home · 07 How it works: three steps, no live-booking promise.
 */

$step_icons = array(1 => 'pencil', 2 => 'chat', 3 => 'sparkles');
?>

<section class="bg-cream py-20 lg:py-28" aria-labelledby="steps-title">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <?php get_template_part('template-parts/components/section-heading', null, array(
      'eyebrow' => 'How it works',
      'title'   => dm_mod('home_steps_title'),
      'body'    => dm_mod('home_steps_body'),
      'align'   => 'center',
      'id'      => 'steps-title',
    )); ?>

    <div data-reveal class="relative mt-14">
      <!-- Connector line drawn behind the cards on desktop -->
      <div class="reveal-line absolute left-[16%] right-[16%] top-14 hidden h-0.5 bg-[repeating-linear-gradient(90deg,var(--color-brand-300)_0_10px,transparent_10px_18px)] md:block" aria-hidden="true"></div>

      <ol class="relative grid gap-6 md:grid-cols-3">
        <?php foreach ($step_icons as $i => $icon) : ?>
          <li data-reveal style="--reveal-delay: <?php echo $i * 150; ?>ms" class="group relative rounded-3xl bg-white p-8 shadow-sm ring-1 ring-brand-900/10 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/10">
            <div class="flex items-center justify-between">
              <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-700 text-white shadow-lg shadow-brand-900/20 transition duration-500 group-hover:-rotate-6 group-hover:scale-110"><?php echo dm_icon($icon, 'size-6'); ?></span>
              <span class="font-display text-5xl font-semibold text-brand-100 transition duration-500 group-hover:text-leaf-300" aria-hidden="true">0<?php echo $i; ?></span>
            </div>
            <h3 class="mt-6 font-display text-xl font-semibold text-brand-950">
              <span class="sr-only">Step <?php echo $i; ?>: </span><?php echo esc_html(dm_mod("home_step_{$i}_title")); ?>
            </h3>
            <p class="mt-2 text-ink/75"><?php echo esc_html(dm_mod("home_step_{$i}_text")); ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div data-reveal class="mt-12 text-center">
      <?php dm_quote_cta(dm_mod('home_steps_cta'), 'how_it_works'); ?>
    </div>
  </div>
</section>
