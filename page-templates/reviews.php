<?php
/**
 * Template Name: Reviews
 *
 * Real reviews only (brief §08): live Trustindex widget for Google, links to the real Google and
 * Yelp profiles, and authorized manual quotes as a fallback if the widget is unavailable.
 */

$widget       = dm_reviews_widget();
$testimonials = dm_testimonials();
$business     = dm_business();
$yelp         = dm_mod('profile_yelp');

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow' => 'Customer reviews',
    'title'   => 'See What Our Customers Are Saying.',
    'intro'   => 'Real reviews from homeowners across the Sacramento area, shared on Google and Yelp.',
  )); ?>

  <section class="bg-white py-20 lg:py-28" aria-labelledby="ratings-title">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <h2 id="ratings-title" class="sr-only">Ratings and reviews</h2>
      <div data-reveal class="mx-auto max-w-4xl">
        <?php get_template_part('template-parts/components/rating-badges', null, array('variant' => 'card')); ?>
      </div>

      <?php if ($widget !== '') : ?>
        <div class="dm-reviews-widget mt-14"><?php echo $widget; ?></div>
      <?php elseif ($testimonials) : ?>
        <div class="mt-14 grid gap-6 md:grid-cols-3">
          <?php foreach ($testimonials as $i => $t) : ?>
            <figure data-reveal style="--reveal-delay: <?php echo $i * 120; ?>ms" class="flex flex-col rounded-3xl bg-cream p-8">
              <blockquote class="flex-1 text-lg leading-relaxed text-ink/85"><p><?php echo esc_html($t['quote']); ?></p></blockquote>
              <figcaption class="mt-6 border-t border-brand-900/10 pt-5 text-sm">
                <span class="block font-bold text-brand-950"><?php echo esc_html($t['author']); ?></span>
                <?php if ($t['platform'] && $t['url']) : ?>
                  <a href="<?php echo esc_url($t['url']); ?>" target="_blank" rel="noopener" class="font-semibold text-brand-700 hover:underline">Review on <?php echo esc_html($t['platform']); ?><span class="sr-only"> (opens in a new tab)</span></a>
                <?php endif; ?>
              </figcaption>
            </figure>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Share your experience -->
  <section class="bg-cream py-20 lg:py-24" aria-labelledby="share-title">
    <div data-reveal class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
      <h2 id="share-title" class="font-display text-3xl font-semibold text-balance text-brand-950 sm:text-4xl">Had a Cleaning With Us? Share Your Experience.</h2>
      <p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed text-ink/75">Your feedback helps local families choose with confidence and helps our team keep improving.</p>
      <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
        <?php if ($business['mapsUrl']) : ?>
          <a href="<?php echo esc_url($business['mapsUrl']); ?>" target="_blank" rel="noopener" class="<?php echo esc_attr(dm_button_classes('primary')); ?>">
            <?php echo dm_brand_icon('google', 'size-5'); ?>Review Us on Google<span class="sr-only"> (opens in a new tab)</span>
          </a>
        <?php endif; ?>
        <?php if ($yelp) : ?>
          <a href="<?php echo esc_url($yelp); ?>" target="_blank" rel="noopener" class="<?php echo esc_attr(dm_button_classes('secondary')); ?>">
            <?php echo dm_brand_icon('yelp', 'size-5'); ?>See Us on Yelp<span class="sr-only"> (opens in a new tab)</span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/components/proof-strip', null, array('bg' => 'white')); ?>
  <?php get_template_part('template-parts/components/cta-band'); ?>
</main>

<?php get_footer();
