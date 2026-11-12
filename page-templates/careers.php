<?php
/**
 * Template Name: Careers
 *
 * /careers/: why work at Dany Maid + the bilingual (EN/ES) application form
 * (React: src/scripts/components/CareersForm.js, backend inc/careers.php).
 * Copy only states what the brief verifies (W2 employees, local company since 2013, insured);
 * pay, benefits and training details should be added once HR confirms them.
 */

$business = dm_business();
$reasons  = array(
  array('identification', 'A real W2 job', 'Our cleaners are W2 employees of Dany Maid, not independent contractors.'),
  array('user-group', 'A local team', 'We are based in Citrus Heights and work in homes across nearby Sacramento-area communities.'),
  array('calendar', 'Full-time or part-time', 'Tell us which days you can work and we will talk about the schedule that fits.'),
  array('chat', 'English or Spanish', 'Apply in the language you prefer. Puedes llenar la solicitud en español.'),
);

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow'   => 'Careers',
    'title'     => 'Join the Dany Maid Team.',
    'intro'     => 'We are looking for reliable, detail-oriented people who take pride in caring for our clients’ homes. Apply online in English or Spanish.',
    'cta'       => 'Apply Now',
    'cta_url'   => '#apply',
    'image'     => 0,
    'stock'     => 'team-supplies',
  )); ?>

  <section class="relative overflow-hidden bg-white py-20 lg:py-28" aria-labelledby="why-work-title">
    <div class="mx-auto grid max-w-7xl items-center gap-14 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
      <div class="lg:col-span-6">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => 'Why work with us',
          'title'   => 'A Local Company That Values Its People.',
          'body'    => 'Our story began in 2013. Today Dany Maid is a team of employees who show up for each other and for the families we serve.',
          'id'      => 'why-work-title',
        )); ?>

        <ul class="mt-10 grid gap-4 sm:grid-cols-2">
          <?php foreach ($reasons as $i => $reason) : ?>
            <li data-reveal style="--reveal-delay: <?php echo $i * 90; ?>ms" class="group rounded-3xl bg-cream p-6 ring-1 ring-brand-900/5 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/10">
              <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-100 text-brand-700 transition duration-500 group-hover:bg-cta group-hover:text-white"><?php echo dm_icon($reason[0], 'size-6'); ?></span>
              <h3 class="mt-5 font-display text-xl font-semibold text-brand-950"><?php echo esc_html($reason[1]); ?></h3>
              <p class="mt-2 leading-relaxed text-ink/75"><?php echo esc_html($reason[2]); ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div data-reveal="right" class="relative lg:col-span-6">
        <div class="absolute -right-5 -top-5 hidden size-32 animate-float-slow rounded-full bg-brand-100 sm:block" aria-hidden="true"></div>
        <div class="absolute -bottom-6 -left-6 hidden size-24 animate-float rounded-full bg-leaf-200/80 sm:block" aria-hidden="true"></div>

        <div class="group relative overflow-hidden rounded-3xl bg-linear-to-br from-brand-100 via-brand-300 to-brand-500 px-3 pt-12 shadow-2xl shadow-brand-900/15 sm:rounded-[2rem] sm:px-6 sm:pt-16">
          <div class="absolute -right-16 -top-16 size-64 rounded-full bg-white/30" aria-hidden="true"></div>
          <div class="absolute -left-10 top-1/3 size-40 rounded-full bg-white/20" aria-hidden="true"></div>
          <span class="absolute left-6 top-6 animate-float text-white/80" aria-hidden="true"><?php echo dm_icon('sparkles', 'size-8'); ?></span>
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

        <div class="absolute -bottom-6 right-6 flex animate-float items-center gap-3 rounded-2xl bg-white px-5 py-4 shadow-xl ring-1 ring-brand-900/5">
          <span class="flex size-10 items-center justify-center rounded-full bg-leaf-500 text-white"><?php echo dm_icon('sparkles', 'size-5'); ?></span>
          <span class="text-sm font-bold leading-tight text-brand-950">Now hiring<br><span class="font-semibold text-ink/65">Se busca personal</span></span>
        </div>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/careers/apply', null, array('form_id' => 'careers')); ?>
</main>

<?php get_footer();
