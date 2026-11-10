<?php
/**
 * Home · 02 Company introduction video (with sound), right after the first screen.
 * File: assets/video/intro-720.mp4 (from uploads/2026/11/web.mp4); subtitles are burned in.
 * preload="none": nothing downloads until the visitor presses play. src/scripts/intro-video.js
 * swaps the native controls for the big play button, tracks plays and pauses off-screen.
 * Without JS the native controls stay.
 */
?>

<section class="relative overflow-hidden bg-white py-20 lg:py-28" aria-labelledby="intro-title">
  <div class="pointer-events-none absolute -right-32 top-10 size-96 animate-float-slow rounded-full bg-brand-100/70 blur-3xl" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -left-24 bottom-0 size-72 animate-float rounded-full bg-leaf-100/80 blur-3xl" aria-hidden="true"></div>

  <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
    <div class="text-center lg:col-span-5 lg:text-left">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Meet Dany Maid',
        'title'   => 'A Personal Welcome From Our Founder.',
        'body'    => 'Get to know the people behind Dany Maid and what to expect when our team comes to your home. It takes about a minute and a half.',
        'id'      => 'intro-title',
      )); ?>

      <p data-reveal style="--reveal-delay: 150ms" class="mt-6 inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-brand-800 shadow-sm ring-1 ring-brand-900/10">
        <?php echo dm_icon('play', 'size-4'); ?> 1:23 · Sound on · Captions included
      </p>

      <div data-reveal style="--reveal-delay: 250ms" class="mt-8 hidden lg:block">
        <?php dm_quote_cta('Get a Quote', 'intro_video'); ?>
      </div>
    </div>

    <div data-reveal="zoom" class="relative lg:col-span-7">
      <div class="absolute -bottom-5 -right-5 hidden size-32 animate-float rounded-full bg-leaf-200/70 sm:block" aria-hidden="true"></div>
      <div class="absolute -left-4 -top-4 hidden size-20 animate-float-slow rounded-full border-8 border-brand-200/70 sm:block" aria-hidden="true"></div>

      <div data-intro-video class="relative aspect-video overflow-hidden rounded-3xl bg-brand-950 shadow-2xl shadow-brand-900/25 ring-1 ring-brand-900/10 sm:rounded-[2rem]">
        <video
          src="<?php echo esc_url(get_theme_file_uri('/assets/video/intro-720.mp4')); ?>"
          poster="<?php echo esc_url(get_theme_file_uri('/assets/images/intro-poster.webp')); ?>"
          class="size-full object-cover"
          controls playsinline preload="none"
          aria-label="Dany Maid introduction video, with captions"
        ></video>

        <button type="button" data-intro-play hidden aria-label="Play the Dany Maid introduction video (with sound)" class="group absolute inset-0 flex items-end justify-start bg-linear-to-t from-brand-950/70 via-brand-950/10 to-transparent p-4 text-left text-white transition duration-500 hover:from-brand-950/60 sm:p-6 focus-visible:outline-4 focus-visible:-outline-offset-4 focus-visible:outline-leaf-300">
          <span class="flex items-center gap-3 sm:gap-4">
          <span class="relative flex size-14 shrink-0 items-center justify-center sm:size-18">
            <span class="absolute inset-0 animate-ping rounded-full bg-white/40 [animation-duration:2s]" aria-hidden="true"></span>
            <span class="relative flex size-full items-center justify-center rounded-full bg-white text-brand-700 shadow-2xl transition duration-500 ease-(--ease-out-soft) group-hover:scale-110 group-hover:bg-leaf-500 group-hover:text-brand-950">
              <?php echo dm_icon('play', 'ml-0.5 size-6 sm:size-8'); ?>
            </span>
          </span>
          <!-- Phones: button only, so the label never sits on the burned-in captions -->
          <span class="hidden flex-col sm:flex">
            <span class="font-display text-lg font-semibold leading-tight sm:text-2xl" data-intro-label>Watch our introduction</span>
            <span class="text-xs font-semibold text-white/80 sm:text-sm">1:23 · Sound on</span>
          </span>
          </span>
        </button>
      </div>
    </div>

    <div data-reveal class="hidden text-center sm:block lg:hidden">
      <?php dm_quote_cta('Get a Quote', 'intro_video'); ?>
    </div>
  </div>
</section>
