<?php
/**
 * Careers application section: steps + bilingual form (React: src/scripts/components/CareersForm.js).
 * Used at the end of /careers/ and /about/. Only one per page (the form mounts on #dm-careers-form).
 * Args: form_id (GA4 form_id), eyebrow, title, body.
 * Photo collage: real team photos (uploads/2026/11/Mesa-de-trabajo-7, StaffLeft, Office, StaffRoght .webp, 2026-11-18),
 * the StaffLeft, Office and StaffRoght photos rotated upright; all optimized to assets/images/careers-*-{480|900}.webp. On lg+ it fills the space beside the tall form;
 * phones show the first two.
 */

$args = wp_parse_args($args, array(
  'form_id' => 'careers',
  'eyebrow' => 'Apply / Aplica',
  'title'   => 'How It Works.',
  'body'    => 'Choose English or Español at the top of the form. All you need is a few minutes.',
));
$business = dm_business();
$collage = array(
  // file, alt, caption, tilt, extra classes
  array('careers-action', 'A Dany Maid team member in uniform making a bed with fresh linens', 'On the job · En acción', '-rotate-3', ''),
  array('careers-team-1', 'Dany Maid team members in uniform smiling together at the office', 'Our team · Nuestro equipo', 'rotate-2', 'mt-10'),
  array('careers-office', 'The Dany Maid office with the company logo on the screen and turquoise balloons', 'Our office · Nuestra oficina', 'rotate-2', 'hidden sm:block -mt-4'),
  array('careers-team-2', 'A group of Dany Maid team members in uniform at a team gathering', 'Team day · Día de equipo', '-rotate-2', 'hidden sm:block mt-6'),
);
$steps = array(
  array('Apply online', 'Fill out the short form below. It takes about 3 minutes.'),
  array('We call you', 'Our team reviews every application and calls the people who are a good fit.'),
  array('Meet the team', 'We talk about the role, the schedule and the next steps together.'),
);
?>

  <section id="apply" class="relative scroll-mt-28 overflow-hidden bg-brand-900 py-20 lg:py-28" aria-labelledby="apply-title">
    <div class="pointer-events-none absolute -right-32 top-0 size-96 animate-float-slow rounded-full bg-brand-700/50 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -left-20 bottom-0 size-80 animate-float rounded-full bg-leaf-500/15 blur-3xl" aria-hidden="true"></div>

    <div class="relative mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
      <div class="lg:col-span-4">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => $args['eyebrow'],
          'title'   => $args['title'],
          'body'    => $args['body'],
          'dark'    => true,
          'id'      => 'apply-title',
        )); ?>

        <ol class="mt-10 space-y-6">
          <?php foreach ($steps as $i => $step) : ?>
            <li data-reveal style="--reveal-delay: <?php echo 100 + $i * 90; ?>ms" class="flex gap-4">
              <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-leaf-500 font-display text-lg font-semibold text-brand-950"><?php echo $i + 1; ?></span>
              <span>
                <span class="block font-display text-xl font-semibold text-white"><?php echo esc_html($step[0]); ?></span>
                <span class="mt-1 block text-brand-100"><?php echo esc_html($step[1]); ?></span>
              </span>
            </li>
          <?php endforeach; ?>
        </ol>

        <div data-reveal style="--reveal-delay: 400ms" class="mt-10 rounded-3xl bg-white/[0.07] p-6 ring-1 ring-white/15">
          <p class="text-sm font-extrabold uppercase tracking-[0.14em] text-leaf-300">Questions? / ¿Preguntas?</p>
          <a href="<?php echo esc_url($business['phoneHref']); ?>" data-location="<?php echo esc_attr($args['form_id']); ?>" class="mt-3 flex items-center gap-3 font-display text-2xl font-semibold text-white hover:underline">
            <?php echo dm_icon('phone', 'size-6 text-leaf-300'); ?><?php echo esc_html($business['phone']); ?>
          </a>
        </div>

        <!-- Polaroid collage of the real team -->
        <ul class="mt-12 grid grid-cols-2 gap-x-4 gap-y-6 sm:gap-x-6" aria-label="Life at Dany Maid">
          <?php foreach ($collage as $i => $photo) : ?>
            <li data-reveal="zoom" style="--reveal-delay: <?php echo 150 + $i * 120; ?>ms" class="<?php echo esc_attr($photo[4]); ?>">
              <figure class="group <?php echo esc_attr($photo[3]); ?> rounded-2xl bg-white p-2 pb-3 shadow-2xl shadow-brand-950/50 transition duration-500 ease-(--ease-out-soft) hover:z-10 hover:rotate-0 hover:scale-105">
                <div class="aspect-[4/5] overflow-hidden rounded-xl bg-brand-100">
                  <img
                    src="<?php echo esc_url(dm_versioned_asset("assets/images/{$photo[0]}-900.webp")); ?>"
                    srcset="<?php echo esc_url(dm_versioned_asset("assets/images/{$photo[0]}-480.webp")); ?> 480w, <?php echo esc_url(dm_versioned_asset("assets/images/{$photo[0]}-900.webp")); ?> 900w"
                    sizes="(min-width: 1024px) 190px, 50vw"
                    width="900" height="1347" loading="lazy" decoding="async"
                    alt="<?php echo esc_attr($photo[1]); ?>"
                    class="size-full object-cover transition duration-700 group-hover:scale-105"
                  >
                </div>
                <figcaption class="mt-2 text-center text-xs font-bold text-brand-800"><?php echo esc_html($photo[2]); ?></figcaption>
              </figure>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div data-reveal="zoom" class="lg:col-span-8">
        <!-- React: src/scripts/components/CareersForm.js -->
        <div id="dm-careers-form" data-form-id="<?php echo esc_attr($args['form_id']); ?>" class="min-h-160 rounded-[2rem] bg-white p-6 shadow-2xl shadow-brand-950/40 sm:p-10">
          <noscript>
            <p class="text-ink/80">To apply, please call us at <a class="font-bold text-brand-700" href="<?php echo esc_url($business['phoneHref']); ?>"><?php echo esc_html($business['phone']); ?></a>.</p>
          </noscript>
        </div>
      </div>
    </div>
  </section>
