<?php
/**
 * Home · 01 Hero: what we do, for whom and where; primary CTA and immediate trust.
 * Desktop (lg+): copy and photo side by side. Below lg the photo becomes the full-bleed
 * background behind the copy (dark veil, light text) so it doesn't sit alone under the text.
 */

$business = dm_business();
?>

<section class="relative flex flex-1 overflow-hidden bg-brand-950 lg:bg-cream" aria-labelledby="hero-title">
  <div class="pointer-events-none absolute -right-40 -top-40 hidden size-128 animate-float-slow rounded-full bg-brand-100/60 blur-3xl lg:block" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -left-24 bottom-0 hidden size-72 animate-float rounded-full bg-leaf-100/70 blur-3xl lg:block" aria-hidden="true"></div>

  <div class="mx-auto grid w-full max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 sm:py-20 lg:relative lg:grid-cols-12 lg:gap-16 lg:px-8 lg:py-12 short:py-6">
    <div class="relative z-10 mx-auto max-w-2xl text-center lg:col-span-6 lg:mx-0 lg:max-w-none lg:text-left">
      <p class="animate-fade-up inline-flex items-center gap-2 rounded-full bg-white px-4 py-1.5 text-sm font-bold text-brand-800 shadow-sm ring-1 ring-brand-900/10">
        <span class="relative flex size-2">
          <span class="absolute inline-flex size-full animate-ping rounded-full bg-leaf-500 opacity-60"></span>
          <span class="relative inline-flex size-2 rounded-full bg-leaf-500"></span>
        </span>
        <?php echo esc_html(dm_mod('home_hero_eyebrow')); ?>
      </p>

      <h1 id="hero-title" style="animation-delay: 100ms" class="animate-fade-up mt-6 font-display text-4xl font-semibold leading-[1.08] tracking-tight text-balance text-white sm:text-5xl lg:text-6xl lg:text-brand-950 short:mt-4 short:text-5xl">
        <?php echo esc_html(dm_mod('home_hero_title')); ?>
      </h1>

      <p style="animation-delay: 200ms" class="animate-fade-up mx-auto mt-6 max-w-xl text-lg leading-relaxed text-white/90 sm:text-xl lg:mx-0 lg:text-ink/80 short:mt-4 short:text-lg">
        <?php echo esc_html(dm_mod('home_hero_body')); ?>
      </p>

      <!-- Hidden on tablet (sm–lg): the header's Get a Quote is enough there -->
      <div style="animation-delay: 300ms" class="animate-fade-up mt-8 flex flex-col gap-3 sm:hidden lg:flex lg:flex-row lg:justify-start short:mt-6">
        <?php dm_quote_cta(dm_mod('home_hero_cta'), 'hero'); ?>
        <?php dm_button(dm_mod('home_hero_secondary'), '#services', 'secondary'); ?>
      </div>

      <!-- Phones: hidden (CTAs only). sm–lg: centered 2×2 grid of frosted chips; lg+: plain two-column checklist -->
      <ul class="mx-auto mt-10 hidden max-w-lg sm:grid grid-cols-2 gap-2 text-left text-xs font-semibold text-white sm:text-sm lg:mx-0 lg:max-w-none lg:gap-x-6 lg:gap-y-3 lg:text-brand-950 short:mt-6">
        <?php for ($i = 1; $i <= 4; $i++) : ?>
          <li style="animation-delay: <?php echo 350 + $i * 80; ?>ms" class="animate-fade-up flex items-center gap-2 rounded-2xl bg-white/10 py-2 pl-2 pr-3 ring-1 ring-white/15 backdrop-blur-sm lg:gap-2.5 lg:bg-transparent lg:p-0 lg:ring-0 lg:backdrop-blur-none">
            <span class="flex size-6 shrink-0 items-center justify-center rounded-full bg-leaf-100 text-leaf-700"><?php echo dm_icon('check', 'size-4'); ?></span>
            <?php echo esc_html(dm_mod("home_trust_pillar_{$i}_title")); ?>
          </li>
        <?php endfor; ?>
      </ul>

      <div style="animation-delay: 750ms" class="animate-fade-up mt-8 hidden sm:block short:mt-5 [&>ul]:justify-center lg:[&>ul]:justify-start">
        <?php get_template_part('template-parts/components/rating-badges', null, array('variant' => 'compact')); ?>
      </div>
    </div>

    <div style="animation-delay: 150ms" class="animate-fade-in-zoom absolute inset-0 lg:relative lg:inset-auto lg:col-span-6 lg:min-h-112 lg:self-stretch">
      <div class="absolute -bottom-6 -left-6 hidden size-40 animate-float rounded-full bg-leaf-200/70 lg:block" aria-hidden="true"></div>
      <div class="absolute -right-4 -top-4 hidden size-24 animate-float-slow rounded-full border-8 border-brand-200/70 lg:block" aria-hidden="true"></div>

      <div class="relative h-full overflow-hidden lg:absolute lg:inset-0 lg:rounded-[2rem] lg:shadow-2xl lg:shadow-brand-900/20">
        <?php
        dm_photo(
          dm_mod('home_hero_image'),
          'hero-living-room',
          dm_mod('home_hero_image_alt'),
          'size-full animate-slow-zoom object-cover',
          '(min-width: 1024px) 600px, 100vw',
          true
        );
        ?>
        <!-- Below lg: dark veil so the white copy reads over the photo. lg+: soft bottom shade only. -->
        <div class="absolute inset-0 bg-linear-to-b from-brand-950/80 via-brand-950/70 to-brand-950/85 lg:bg-linear-to-t lg:from-brand-950/30 lg:via-transparent lg:to-transparent" aria-hidden="true"></div>
      </div>

      <!-- Opens the quote form in src/scripts/components/QuoteModal.js; plain link to /contact/ without JS -->
      <a href="<?php echo esc_url(dm_quote_url()); ?>" data-quote-modal data-track="quote_cta_click" data-position="hero_badge" aria-haspopup="dialog" class="group absolute bottom-8 left-6 hidden max-w-xs animate-float rounded-2xl focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white lg:block">
        <span class="flex items-center gap-4 rounded-2xl bg-white/95 p-4 shadow-xl ring-1 ring-brand-900/5 backdrop-blur transition duration-500 ease-(--ease-out-soft) group-hover:-translate-y-1 group-hover:scale-[1.03] group-hover:shadow-2xl group-hover:shadow-brand-900/30 group-hover:ring-brand-600/40">
          <span class="relative flex size-11 shrink-0 items-center justify-center rounded-xl bg-brand-700 text-white transition duration-500 group-hover:rotate-[-8deg] group-hover:bg-leaf-500 group-hover:text-brand-950">
            <span class="absolute inset-0 animate-ping rounded-xl bg-brand-500 opacity-30 group-hover:opacity-0" aria-hidden="true"></span>
            <?php echo dm_icon('home', 'relative size-6'); ?>
          </span>
          <span class="text-sm leading-snug text-ink/80">
            <span class="block font-bold text-brand-950">Based in <?php echo esc_html($business['city']); ?></span>
            Serving homes across the Sacramento area
            <span class="mt-1.5 flex items-center gap-1.5 font-bold text-brand-700">
              Get a Quote
              <span class="transition-transform duration-300 group-hover:translate-x-1"><?php echo dm_icon('arrow-right', 'size-4'); ?></span>
            </span>
          </span>
        </span>
      </a>
    </div>
  </div>
</section>
