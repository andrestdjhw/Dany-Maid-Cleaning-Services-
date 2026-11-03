<?php
/**
 * Home · 06 Our team / why us: real people and verifiable standards.
 */

$points = array(
  dm_mod('home_trust_pillar_1_text'),
  dm_mod('home_trust_pillar_2_text'),
  'We note your preferences and special instructions before your service.',
  'Our story began in 2013; we have been Dany Maid since 2021.',
);
?>

<section class="overflow-hidden bg-white py-20 lg:py-28" aria-labelledby="team-title">
  <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-20 lg:px-8">
    <div data-reveal="left" class="relative">
      <div class="absolute -right-5 -top-5 hidden size-32 animate-float-slow rounded-full bg-brand-100 lg:block" aria-hidden="true"></div>
      <div class="absolute -bottom-6 -left-6 hidden size-24 animate-float rounded-full bg-leaf-200/80 lg:block" aria-hidden="true"></div>
      <div class="group relative aspect-[4/3] overflow-hidden rounded-[2rem] shadow-2xl shadow-brand-900/15">
        <?php
        dm_photo(
          dm_mod('home_team_image'),
          'team-supplies',
          dm_mod('home_team_image_alt'),
          'size-full object-cover object-[center_70%] transition duration-1000 ease-out group-hover:scale-105',
          '(min-width: 1024px) 600px, 100vw'
        );
        ?>
      </div>
      <div class="absolute -bottom-6 right-6 flex animate-float items-center gap-3 rounded-2xl bg-brand-700 px-5 py-4 text-white shadow-xl">
        <span class="font-display text-3xl font-semibold">2013</span>
        <span class="text-sm leading-tight text-brand-100">Our story<br>began</span>
      </div>
    </div>

    <div>
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
