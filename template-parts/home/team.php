<?php
/**
 * Home · 06 Our team: real people and verifiable standards.
 * Photo: Dany Maid team members with the company car (cutout, assets/images/team-car-*.webp from
 * uploads/2026/11/con-logos-en-camisa.png) standing on a turquoise panel. Stacked below lg
 * (photo first) because the cutout is the point of the section, not a background.
 */

$points = array(
  dm_mod('home_trust_pillar_1_text'),
  dm_mod('home_trust_pillar_2_text'),
  'We note your preferences and special instructions before your service.',
  'Our story began in 2013; we have been Dany Maid since 2021.',
);
?>

<section class="relative overflow-hidden bg-white py-20 sm:py-24 lg:py-28" aria-labelledby="team-title">
  <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-20 lg:px-8">
    <div data-reveal="left" class="relative">
      <div class="absolute -right-5 -top-5 hidden size-32 animate-float-slow rounded-full bg-brand-100 sm:block" aria-hidden="true"></div>
      <div class="absolute -bottom-6 -left-6 hidden size-24 animate-float rounded-full bg-leaf-200/80 sm:block" aria-hidden="true"></div>

      <div class="group relative overflow-hidden rounded-3xl bg-linear-to-br from-brand-100 via-brand-300 to-brand-500 px-3 pt-12 shadow-2xl shadow-brand-900/15 sm:rounded-[2rem] sm:px-6 sm:pt-16">
        <div class="absolute -right-16 -top-16 size-64 rounded-full bg-white/30" aria-hidden="true"></div>
        <div class="absolute -left-10 top-1/3 size-40 rounded-full bg-white/20" aria-hidden="true"></div>
        <span class="absolute left-6 top-6 animate-float text-white/80" aria-hidden="true"><?php echo dm_icon('sparkles', 'size-8'); ?></span>
        <!-- Floor shadow under the car -->
        <div class="absolute inset-x-[8%] bottom-0 h-8 rounded-[100%] bg-brand-950/25 blur-xl" aria-hidden="true"></div>
        <img
          src="<?php echo esc_url(get_theme_file_uri('assets/images/team-car-1600.webp')); ?>"
          srcset="<?php echo esc_url(get_theme_file_uri('assets/images/team-car-900.webp')); ?> 900w, <?php echo esc_url(get_theme_file_uri('assets/images/team-car-1600.webp')); ?> 1600w"
          sizes="(min-width: 1024px) 600px, 100vw"
          width="1600" height="824" loading="lazy" decoding="async"
          alt="Dany Maid team members in uniform next to a Dany Maid company car"
          class="relative w-full transition duration-1000 ease-(--ease-out-soft) group-hover:scale-[1.03]"
        >
      </div>

      <div class="absolute -bottom-6 right-6 hidden animate-float items-center gap-3 rounded-2xl bg-brand-800 px-5 py-4 text-white shadow-xl sm:flex">
        <span class="font-display text-3xl font-semibold">2013</span>
        <span class="text-sm leading-tight text-brand-100">Our story<br>began</span>
      </div>
    </div>

    <div class="relative z-10">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Our team',
        'title'   => dm_mod('home_team_title'),
        'body'    => dm_mod('home_team_body'),
        'id'      => 'team-title',
      )); ?>

      <ul class="mt-8 space-y-4">
        <?php foreach ($points as $i => $point) : ?>
          <li data-reveal style="--reveal-delay: <?php echo 100 + $i * 90; ?>ms" class="flex gap-3 text-ink/80">
            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-leaf-100 text-leaf-700"><?php echo dm_icon('check', 'size-4'); ?></span>
            <?php echo esc_html($point); ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <div data-reveal style="--reveal-delay: 450ms" class="mt-10">
        <?php dm_button(dm_mod('home_team_cta'), home_url('/about/'), 'secondary'); ?>
      </div>
    </div>
  </div>
</section>
