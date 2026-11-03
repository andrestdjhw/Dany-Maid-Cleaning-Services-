<?php
/**
 * Home · 01 Hero: what we do, for whom and where; primary CTA and immediate trust.
 */

$business = dm_business();
?>

<section class="relative overflow-hidden bg-cream" aria-labelledby="hero-title">
  <div class="pointer-events-none absolute -right-40 -top-40 size-128 animate-float-slow rounded-full bg-brand-100/60 blur-3xl" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -left-24 bottom-0 size-72 animate-float rounded-full bg-leaf-100/70 blur-3xl" aria-hidden="true"></div>

  <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 py-14 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8 lg:py-24">
    <div class="lg:col-span-6">
      <p class="animate-fade-up inline-flex items-center gap-2 rounded-full bg-white px-4 py-1.5 text-sm font-bold text-brand-800 shadow-sm ring-1 ring-brand-900/10">
        <span class="relative flex size-2">
          <span class="absolute inline-flex size-full animate-ping rounded-full bg-leaf-500 opacity-60"></span>
          <span class="relative inline-flex size-2 rounded-full bg-leaf-500"></span>
        </span>
        <?php echo esc_html(dm_mod('home_hero_eyebrow')); ?>
      </p>

      <h1 id="hero-title" style="animation-delay: 100ms" class="animate-fade-up mt-6 font-display text-4xl font-semibold leading-[1.08] tracking-tight text-balance text-brand-950 sm:text-5xl lg:text-6xl">
        <?php echo esc_html(dm_mod('home_hero_title')); ?>
      </h1>

      <p style="animation-delay: 200ms" class="animate-fade-up mt-6 max-w-xl text-lg leading-relaxed text-ink/80 sm:text-xl">
        <?php echo esc_html(dm_mod('home_hero_body')); ?>
      </p>

      <div style="animation-delay: 300ms" class="animate-fade-up mt-8 flex flex-col gap-3 sm:flex-row">
        <?php dm_quote_cta(dm_mod('home_hero_cta'), 'hero'); ?>
        <?php dm_button(dm_mod('home_hero_secondary'), '#services', 'secondary'); ?>
      </div>

      <ul class="mt-10 grid gap-x-6 gap-y-3 text-sm font-semibold text-brand-950 sm:grid-cols-2">
        <?php for ($i = 1; $i <= 4; $i++) : ?>
          <li style="animation-delay: <?php echo 350 + $i * 80; ?>ms" class="animate-fade-up flex items-center gap-2.5">
            <span class="flex size-6 shrink-0 items-center justify-center rounded-full bg-leaf-100 text-leaf-700"><?php echo dm_icon('check', 'size-4'); ?></span>
            <?php echo esc_html(dm_mod("home_trust_pillar_{$i}_title")); ?>
          </li>
        <?php endfor; ?>
      </ul>

      <div style="animation-delay: 750ms" class="animate-fade-up mt-8">
        <?php get_template_part('template-parts/components/rating-badges', null, array('variant' => 'compact')); ?>
      </div>
    </div>

    <div style="animation-delay: 150ms" class="animate-fade-in-zoom relative lg:col-span-6">
      <div class="absolute -bottom-6 -left-6 hidden size-40 animate-float rounded-full bg-leaf-200/70 lg:block" aria-hidden="true"></div>
      <div class="absolute -right-4 -top-4 hidden size-24 animate-float-slow rounded-full border-8 border-brand-200/70 lg:block" aria-hidden="true"></div>

      <div class="relative aspect-[4/3] overflow-hidden rounded-[2rem] shadow-2xl shadow-brand-900/20 lg:aspect-[4/5]">
        <?php
        dm_photo(
          dm_mod('home_hero_image'),
          'hero-living-room',
          dm_mod('home_hero_image_alt'),
          'size-full animate-slow-zoom object-cover',
          '(min-width: 1024px) 600px, 100vw',
          'Illustrative stock photo. Replace with a real Dany Maid photo in Customize → Dany Maid → Home · 01 Hero.',
          true
        );
        ?>
        <div class="absolute inset-0 bg-linear-to-t from-brand-950/30 via-transparent to-transparent" aria-hidden="true"></div>
      </div>

      <div class="relative -mt-10 ml-4 mr-4 flex animate-float items-center gap-4 rounded-2xl bg-white/95 p-4 shadow-xl ring-1 ring-brand-900/5 backdrop-blur sm:absolute sm:bottom-8 sm:left-6 sm:right-auto sm:m-0 sm:max-w-xs">
        <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-brand-700 text-white"><?php echo dm_icon('home', 'size-6'); ?></span>
        <p class="text-sm leading-snug text-ink/80">
          <span class="block font-bold text-brand-950">Based in <?php echo esc_html($business['city']); ?></span>
          Serving homes across the Sacramento area
        </p>
      </div>
    </div>
  </div>
</section>
