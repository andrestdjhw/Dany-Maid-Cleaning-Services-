<?php
/**
 * Home · 01 Hero: what we do, for whom and where; primary CTA and immediate trust.
 * Full-bleed background video of the Dany Maid team (assets/video/hero-color-*.mp4, from
 * uploads/2026/11/COLOR.mp4) at every width, with a dark veil so the white copy reads on top.
 * src/scripts/bg-video.js loads the 4.5 Mbps file on lg+, a lighter 720p one below; both lightly sharpened; reduced motion keeps the poster.
 */

$business = dm_business();
?>

<section class="relative flex flex-1 overflow-hidden bg-brand-950" aria-labelledby="hero-title">
  <video
    data-bg-video
    data-src-lg="<?php echo esc_url(get_theme_file_uri('/assets/video/hero-color-720.mp4')); ?>"
    data-src-sm="<?php echo esc_url(get_theme_file_uri('/assets/video/hero-color-720-mobile.mp4')); ?>"
    poster="<?php echo esc_url(get_theme_file_uri('/assets/images/hero-color-poster.webp')); ?>"
    class="absolute inset-0 size-full object-cover object-[center_60%]"
    muted loop playsinline preload="none" aria-hidden="true"
  ></video>
  <!-- Phones/tablet: even veil behind centered copy. lg+: dark on the left (copy), clear on the right so the team shows. -->
  <div class="absolute inset-0 bg-linear-to-b from-brand-950/80 via-brand-950/65 to-brand-950/85 lg:bg-linear-to-r lg:from-brand-950/90 lg:via-brand-950/60 lg:to-brand-950/5" aria-hidden="true"></div>

  <div class="relative mx-auto flex w-full max-w-7xl items-center px-4 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-16 short:py-8">
    <div class="relative z-10 mx-auto max-w-2xl text-center lg:mx-0 lg:max-w-xl lg:text-left xl:max-w-2xl">
      <p class="animate-fade-up inline-flex items-center gap-2 rounded-full bg-white px-4 py-1.5 text-sm font-bold text-brand-800 shadow-sm ring-1 ring-brand-900/10">
        <span class="relative flex size-2">
          <span class="absolute inline-flex size-full animate-ping rounded-full bg-leaf-500 opacity-60"></span>
          <span class="relative inline-flex size-2 rounded-full bg-leaf-500"></span>
        </span>
        <?php echo esc_html(dm_mod('home_hero_eyebrow')); ?>
      </p>

      <h1 id="hero-title" style="animation-delay: 100ms" class="animate-fade-up mt-6 font-display text-4xl font-semibold leading-[1.08] tracking-tight text-balance text-white sm:text-5xl lg:text-6xl short:mt-4 short:text-5xl">
        <?php echo esc_html(dm_mod('home_hero_title')); ?>
      </h1>

      <p style="animation-delay: 200ms" class="animate-fade-up mx-auto mt-6 max-w-xl text-lg leading-relaxed text-white/90 sm:text-xl lg:mx-0 short:mt-4 short:text-lg">
        <?php echo esc_html(dm_mod('home_hero_body')); ?>
      </p>

      <!-- Hidden on tablet (sm–lg): the header's Get a Quote is enough there -->
      <div style="animation-delay: 300ms" class="animate-fade-up mt-8 flex flex-col gap-3 sm:hidden lg:flex lg:flex-row lg:justify-start short:mt-6">
        <?php dm_quote_cta(dm_mod('home_hero_cta'), 'hero'); ?>
        <?php dm_button(dm_mod('home_hero_secondary'), '#services', 'ghost'); ?>
      </div>

      <!-- Phones: hidden (CTAs only). sm+: 2×2 grid of frosted chips -->
      <ul class="mx-auto mt-10 hidden max-w-lg sm:grid grid-cols-2 gap-2 text-left text-xs font-semibold text-white sm:text-sm lg:mx-0 lg:max-w-none lg:gap-x-3 short:mt-6">
        <?php for ($i = 1; $i <= 4; $i++) : ?>
          <li style="animation-delay: <?php echo 350 + $i * 80; ?>ms" class="animate-fade-up flex items-center gap-2 rounded-2xl bg-white/10 py-2 pl-2 pr-3 ring-1 ring-white/15 backdrop-blur-sm">
            <span class="flex size-6 shrink-0 items-center justify-center rounded-full bg-leaf-100 text-leaf-700"><?php echo dm_icon('check', 'size-4'); ?></span>
            <?php echo esc_html(dm_mod("home_trust_pillar_{$i}_title")); ?>
          </li>
        <?php endfor; ?>
      </ul>

      <div style="animation-delay: 750ms" class="animate-fade-up mt-8 hidden sm:block short:mt-5 [&>ul]:justify-center lg:[&>ul]:justify-start">
        <?php get_template_part('template-parts/components/rating-badges', null, array('variant' => 'compact')); ?>
      </div>
    </div>


    <!-- Opens the quote form in src/scripts/components/QuoteModal.js; plain link to /contact/ without JS -->
    <a href="<?php echo esc_url(dm_quote_url()); ?>" data-quote-modal data-track="quote_cta_click" data-position="hero_badge" aria-haspopup="dialog" class="group absolute bottom-10 right-8 hidden max-w-xs animate-float rounded-2xl focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white lg:block">
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
</section>
