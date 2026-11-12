<?php
/**
 * Careers application section: steps + bilingual form (React: src/scripts/components/CareersForm.js).
 * Used at the end of /careers/ and /about/. Only one per page (the form mounts on #dm-careers-form).
 * Args: form_id (GA4 form_id), eyebrow, title, body.
 */

$args = wp_parse_args($args, array(
  'form_id' => 'careers',
  'eyebrow' => 'Apply / Aplica',
  'title'   => 'How It Works.',
  'body'    => 'Choose English or Español at the top of the form. All you need is a few minutes.',
));
$business = dm_business();
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
