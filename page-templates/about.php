<?php
/**
 * Template Name: About
 *
 * Company story (brief §08): 2013 is when the company began, 2021 when it became Dany Maid —
 * never "13 years as Dany Maid". The founders' story is taken word for word from Miguel Sandoval's
 * welcome video (uploads/2026/11/DANYMaidWelcomeVideo.mp4, burned-in subtitles). Text typed in the
 * page editor (Pages → About) replaces it.
 */

$business = dm_business();
$timeline = array(
  array('year' => '2013', 'title' => 'Our story begins', 'text' => 'Miguel and Claudia Sandoval start the company, cleaning their clients’ homes themselves.'),
  array('year' => '2021', 'title' => 'Becoming Dany Maid', 'text' => 'We continue as Dany Maid, building a local cleaning team focused on dependable service and lasting customer relationships.'),
  array('year' => 'Today', 'title' => 'A local team in ' . $business['city'], 'text' => 'Trained teams, leaders who inspect every job, additional supervision and an administrative team that coordinates services and assists our clients.'),
);

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow'   => 'About Dany Maid',
    'title'     => 'A Local Cleaning Company Built on Trust.',
    'intro'     => 'Our story began in 2013. Since becoming Dany Maid in 2021, we have continued building a local cleaning team focused on dependable service and lasting customer relationships.',
    'secondary' => array('label' => 'Why Dany Maid', 'url' => dm_page_url('why-dany-maid')),
    // Real photo (uploads/2026/11/AboutUsHero.webp, 2026-11-18 → assets/images/team-founders-*.webp).
    // The focus keeps both faces in frame in the 4:3 desktop crop and the phone background.
    'stock'       => 'team-founders',
    'image_alt'   => 'Dany Maid founders Miguel and Claudia Sandoval smiling together in a bright kitchen',
    'image_focus' => 'object-[50%_35%]',
  )); ?>

  <section class="bg-white py-20 lg:py-28" aria-labelledby="story-title">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
      <div class="lg:col-span-5">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => 'Our story',
          'title'   => 'More Than a Decade of Caring for Local Homes.',
          'id'      => 'story-title',
        )); ?>
        <?php if ($content = dm_page_content()) : ?>
          <div data-reveal class="prose prose-lg mt-6 prose-headings:font-display prose-headings:text-brand-950 prose-a:text-brand-700">
            <?php echo $content; ?>
          </div>
        <?php else : ?>
          <div class="mt-6 space-y-5 text-lg leading-relaxed text-ink/80">
            <p data-reveal>Dany Maid was founded by Miguel Sandoval and his wife, Claudia. They started the company cleaning their clients’ homes themselves.</p>
            <p data-reveal style="--reveal-delay: 100ms">Along the way, they learned something very important: when someone opens the doors of their home to us, they are giving us their trust. That is why, throughout all these years, we have worked to build much more than just a cleaning service.</p>
            <p data-reveal style="--reveal-delay: 200ms">Today we have trained teams, leaders who inspect every job, additional supervision, and an administrative team that coordinates services and assists our clients. We created this structure with one purpose: so you can trust the quality of our work, not just on the first visit, but on every single one.</p>
          </div>

          <figure data-reveal style="--reveal-delay: 300ms" class="mt-8 rounded-3xl bg-brand-50 p-6 ring-1 ring-brand-900/5">
            <span class="text-leaf-600" aria-hidden="true"><?php echo dm_icon('chat', 'size-7'); ?></span>
            <blockquote class="mt-3 font-display text-xl font-semibold leading-snug text-brand-950">“When someone opens the doors of their home to us, they are giving us their trust.”</blockquote>
            <figcaption class="mt-3 text-sm font-bold text-brand-700">Miguel Sandoval, Founder</figcaption>
          </figure>
        <?php endif; ?>
      </div>

      <ol class="relative space-y-6 border-l-2 border-brand-100 pl-8 lg:col-span-7 lg:ml-8">
        <?php foreach ($timeline as $i => $step) : ?>
          <li data-reveal="right" style="--reveal-delay: <?php echo $i * 140; ?>ms" class="relative rounded-3xl bg-cream p-7">
            <span class="absolute -left-[2.6rem] top-8 flex size-5 items-center justify-center rounded-full bg-leaf-500 ring-4 ring-white" aria-hidden="true"></span>
            <p class="font-display text-3xl font-semibold text-brand-700"><?php echo esc_html($step['year']); ?></p>
            <h3 class="mt-1 font-display text-xl font-semibold text-brand-950"><?php echo esc_html($step['title']); ?></h3>
            <p class="mt-2 text-ink/75"><?php echo esc_html($step['text']); ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <?php get_template_part('template-parts/home/trust'); ?>

  <!-- Where we are -->
  <section class="bg-leaf-100 py-20 lg:py-24" aria-labelledby="location-title">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Where we are',
        'title'   => 'Based in ' . $business['city'] . ', Serving the Sacramento Area.',
        'body'    => 'We serve households across nearby Sacramento-area communities. Check your location when requesting a quote.',
        'id'      => 'location-title',
      )); ?>
      <div data-reveal="right" class="rounded-3xl bg-brand-900 p-8 text-white">
        <p class="flex items-start gap-3 text-lg">
          <?php echo dm_icon('map-pin', 'size-6 shrink-0 text-leaf-300'); ?>
          <span><?php echo esc_html($business['street']); ?><br><?php echo esc_html($business['city'] . ', ' . $business['region'] . ' ' . $business['zip']); ?></span>
        </p>
        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
          <?php dm_button('View Service Areas', dm_page_url('service-areas'), 'light'); ?>
          <?php if ($business['mapsUrl']) : ?>
            <a href="<?php echo esc_url($business['mapsUrl']); ?>" target="_blank" rel="noopener" class="<?php echo esc_attr(dm_button_classes('ghost')); ?>">Open in Google Maps<span class="sr-only"> (opens in a new tab)</span></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/components/cta-band'); ?>

  <?php get_template_part('template-parts/careers/apply', null, array(
    'form_id' => 'about_careers',
    'eyebrow' => 'Careers / Empleo',
    'title'   => 'Join Our Team.',
    'body'    => 'We are hiring. Apply in English or Spanish; choose your language at the top of the form. It takes about 3 minutes.',
  )); ?>
</main>

<?php get_footer();
