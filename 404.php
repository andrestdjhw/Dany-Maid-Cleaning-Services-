<?php
/**
 * 404: friendly dead-end recovery with the main destinations.
 */

$links = array(
  array('label' => 'House Cleaning Services', 'url' => dm_page_url('house-cleaning'), 'icon' => 'sparkles'),
  array('label' => 'Service Areas', 'url' => dm_page_url('service-areas'), 'icon' => 'map-pin'),
  array('label' => 'Customer Reviews', 'url' => dm_page_url('reviews'), 'icon' => 'heart'),
  array('label' => 'Contact Us', 'url' => dm_page_url('contact'), 'icon' => 'chat'),
);

get_header(); ?>

<main id="main">
  <section class="relative overflow-hidden bg-cream py-24 lg:py-32" aria-labelledby="notfound-title">
    <div class="pointer-events-none absolute -right-40 -top-40 size-128 animate-float-slow rounded-full bg-brand-100/60 blur-3xl" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-3xl px-4 text-center sm:px-6">
      <p class="animate-fade-up font-display text-8xl font-semibold text-brand-200">404</p>
      <h1 id="notfound-title" style="animation-delay: 100ms" class="mt-4 animate-fade-up font-display text-4xl font-semibold text-balance text-brand-950 sm:text-5xl">This Page Has Been Tidied Away.</h1>
      <p style="animation-delay: 180ms" class="mt-5 animate-fade-up text-lg text-ink/75">We couldn’t find what you were looking for. Here are a few places to start.</p>

      <ul style="animation-delay: 260ms" class="mt-10 grid animate-fade-up gap-3 text-left sm:grid-cols-2">
        <?php foreach ($links as $link) : ?>
          <li>
            <a href="<?php echo esc_url($link['url']); ?>" class="group flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-brand-900/5 transition duration-300 hover:-translate-y-0.5 hover:shadow-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700">
              <span class="flex size-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 transition group-hover:bg-brand-700 group-hover:text-white"><?php echo dm_icon($link['icon'], 'size-5'); ?></span>
              <span class="flex-1 font-bold text-brand-950"><?php echo esc_html($link['label']); ?></span>
              <span class="text-brand-700 transition group-hover:translate-x-1"><?php echo dm_icon('arrow-right', 'size-5'); ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>

      <div style="animation-delay: 340ms" class="mt-10 animate-fade-up">
        <?php dm_button('Back to Home', home_url('/'), 'secondary'); ?>
      </div>
    </div>
  </section>
</main>

<?php get_footer();
