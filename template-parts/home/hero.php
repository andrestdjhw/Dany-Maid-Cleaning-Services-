<?php
/**
 * Home · 01 Hero: what we do, for whom and where; primary CTA and immediate trust.
 * Full-bleed background video playlist (src/scripts/bg-playlist.js), with a dark veil so the white copy reads on top:
 *   1. team waving by the cars  (assets/video/hero-team-*.mp4,    from uploads/2026/11/DANY-MAIN22.mp4)
 *   2. fleet tracking shot      (assets/video/hero-fleet-1-*.mp4, from uploads/2026/11/web2.mp4)
 *   3. fleet tracking shot      (assets/video/hero-fleet-2-*.mp4, from uploads/2026/11/web4.mp4)
 * Two stacked <video> elements crossfade (1 s) from one clip to the next and loop back to the first.
 * Each clip loads only when it is next. lg+: 1080p (Lanczos upscale of the 720p sources, light sharpening,
 * 8 Mbps); below lg: 720p (3.2 Mbps). Stronger sharpening smeared the faces. No audio. Reduced motion keeps the poster.
 */

$business = dm_business();
?>

<section class="relative flex flex-1 flex-col overflow-hidden bg-brand-950 sm:flex-row" aria-labelledby="hero-title">
  <?php
  $hero_clips = array();
  foreach (array('team', 'fleet-1', 'fleet-2') as $clip) {
    $hero_clips[] = array(
      'lg' => dm_versioned_asset("assets/video/hero-{$clip}-1080.mp4"),
      'sm' => dm_versioned_asset("assets/video/hero-{$clip}-720.mp4"),
    );
  }
  ?>
  <div data-bg-playlist="<?php echo esc_attr(wp_json_encode($hero_clips)); ?>" class="relative h-[42svh] min-h-60 shrink-0 sm:absolute sm:inset-0 sm:h-auto" aria-hidden="true">
    <video
      poster="<?php echo esc_url(dm_versioned_asset('assets/images/hero-main-poster.webp')); ?>"
      class="absolute inset-0 size-full object-cover object-[center_60%] transition-opacity duration-1000"
      muted playsinline preload="none"
    ></video>
    <video
      class="absolute inset-0 size-full object-cover object-[center_60%] opacity-0 transition-opacity duration-1000"
      muted playsinline preload="none"
    ></video>
    <!-- Phones: the video sits above the copy, uncovered; only its bottom edge fades into the section -->
    <div class="absolute inset-x-0 bottom-0 h-1/4 bg-linear-to-t from-brand-950 to-transparent sm:hidden"></div>
  </div>
  <!-- Tablet: even veil behind centered copy. lg+: dark on the left (copy), clear on the right so the team shows. -->
  <div class="absolute inset-0 hidden sm:block bg-linear-to-b sm:from-brand-950/80 sm:via-brand-950/65 sm:to-brand-950/85 lg:bg-linear-to-r lg:from-brand-950/90 lg:via-brand-950/60 lg:to-brand-950/5" aria-hidden="true"></div>

  <div class="relative mx-auto flex w-full max-w-7xl items-start px-4 pb-10 pt-2 sm:items-center sm:px-6 sm:py-20 lg:px-8 lg:py-16 short:py-8">
    <div class="relative z-10 mx-auto max-w-2xl text-center lg:mx-0 lg:max-w-xl lg:text-left xl:max-w-2xl">
      <p class="animate-fade-up inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-xs font-bold sm:px-4 sm:py-1.5 sm:text-sm text-brand-800 shadow-sm ring-1 ring-brand-900/10">
        <span class="relative flex size-2">
          <span class="absolute inline-flex size-full animate-ping rounded-full bg-leaf-500 opacity-60"></span>
          <span class="relative inline-flex size-2 rounded-full bg-leaf-500"></span>
        </span>
        <?php echo esc_html(dm_mod('home_hero_eyebrow')); ?>
      </p>

      <h1 id="hero-title" style="animation-delay: 100ms" class="animate-fade-up mt-4 font-display text-[2rem] sm:mt-6 font-semibold leading-[1.08] tracking-tight text-balance text-white sm:text-5xl lg:text-6xl short:mt-4 short:text-5xl">
        <?php echo esc_html(dm_mod('home_hero_title')); ?>
      </h1>

      <p style="animation-delay: 200ms" class="animate-fade-up mx-auto mt-4 max-w-xl text-base leading-relaxed text-white/90 sm:mt-6 sm:text-xl lg:mx-0 short:mt-4 short:text-lg">
        <?php echo esc_html(dm_mod('home_hero_body')); ?>
      </p>

      <!-- Hidden on tablet (sm–lg): the header's Get a Quote is enough there -->
      <div style="animation-delay: 300ms" class="animate-fade-up mt-6 flex flex-col gap-3 sm:hidden lg:flex lg:flex-row lg:justify-start short:mt-6">
        <?php dm_quote_cta(dm_mod('home_hero_cta'), 'hero'); ?>
        <?php dm_button(dm_mod('home_hero_secondary'), '#services', 'ghost'); ?>
      </div>

      <div style="animation-delay: 400ms" class="animate-fade-up mt-10 hidden sm:block short:mt-5 [&>ul]:justify-center lg:[&>ul]:justify-start">
        <?php get_template_part('template-parts/components/rating-badges', null, array('variant' => 'compact')); ?>
      </div>
    </div>
    <!-- Compact quote badge (lg+). Opens the quote form in src/scripts/components/QuoteModal.js; plain link to /contact/ without JS.
         Magic hat: after 3 s the card pops out of an upside-down top hat (src/scripts/hero-hat.js, .dm-hat CSS in src/index.css).
         Reduced motion or no JS: the card is simply there. -->
    <div data-hero-hat class="dm-hat absolute bottom-8 right-8 hidden animate-float lg:block">
    <a href="<?php echo esc_url(dm_quote_url()); ?>" data-quote-modal data-track="quote_cta_click" data-position="hero_badge" aria-haspopup="dialog" class="group relative block rounded-2xl focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
      <span class="dm-hat-card flex items-center gap-3 rounded-2xl bg-white/95 py-2.5 pl-2.5 pr-4 shadow-xl ring-1 ring-brand-900/5 backdrop-blur transition duration-500 ease-(--ease-out-soft) group-hover:-translate-y-1 group-hover:shadow-2xl group-hover:shadow-brand-900/30 group-hover:ring-cta/40">
        <span class="relative flex size-9 shrink-0 items-center justify-center rounded-xl bg-brand-700 text-white transition duration-500 group-hover:rotate-[-8deg] group-hover:bg-cta">
          <span class="absolute inset-0 animate-ping rounded-xl bg-brand-500 opacity-30 group-hover:opacity-0" aria-hidden="true"></span>
          <?php echo dm_icon('home', 'relative size-5'); ?>
        </span>
        <span class="text-xs leading-snug">
          <span class="block font-bold text-brand-950">Based in <?php echo esc_html($business['city']); ?></span>
          <span class="flex items-center gap-1 font-bold text-brand-700">
            Get a Quote
            <span class="transition-transform duration-300 group-hover:translate-x-1"><?php echo dm_icon('arrow-right', 'size-3.5'); ?></span>
          </span>
        </span>
      </span>
    </a>
      <span class="dm-hat-spark left-[18%] top-[-14px] text-leaf-300" aria-hidden="true"><?php echo dm_icon('sparkles', 'size-5'); ?></span>
      <span class="dm-hat-spark right-[14%] top-[-22px] text-white [animation-delay:1.1s]" aria-hidden="true"><?php echo dm_icon('sparkles', 'size-6'); ?></span>
      <span class="dm-hat-spark right-[-14px] top-[30%] text-brand-200 [animation-delay:1.2s]" aria-hidden="true"><?php echo dm_icon('sparkles', 'size-4'); ?></span>
      <svg class="dm-hat-hat" viewBox="0 0 72 56" width="92" height="72" aria-hidden="true" focusable="false">
        <path d="M16 12h40l-4 38q-16 6-32 0z" fill="#0f2b36"/>
        <path d="M17.3 22h37.4l-.6 7H17.9z" fill="#4dabc1"/>
        <path d="M24 16l-2 30" stroke="#ffffff" stroke-opacity=".18" stroke-width="3" stroke-linecap="round"/>
        <ellipse cx="36" cy="12" rx="34" ry="8" fill="#215564"/>
        <ellipse cx="36" cy="12" rx="22" ry="4.5" fill="#06141a"/>
      </svg>
    </div>
  </div>
</section>
