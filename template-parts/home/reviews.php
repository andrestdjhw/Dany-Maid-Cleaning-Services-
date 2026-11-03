<?php
/**
 * Home · 03 Reviews: live Trustindex widget; authorized manual quotes as fallback.
 */

$testimonials = dm_testimonials();

$widget = dm_reviews_widget();
?>

<section id="reviews" class="scroll-mt-28 bg-white py-20 lg:py-28" aria-labelledby="reviews-title">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid items-end gap-10 lg:grid-cols-2">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Customer reviews',
        'title'   => dm_mod('home_reviews_title'),
        'body'    => dm_mod('home_reviews_body'),
        'id'      => 'reviews-title',
      )); ?>
      <div data-reveal="right">
        <?php get_template_part('template-parts/components/rating-badges', null, array('variant' => 'card')); ?>
      </div>
    </div>

    <?php if ($widget !== '') : ?>
      <div class="dm-reviews-widget mt-14">
        <?php echo $widget; ?>
      </div>
    <?php elseif ($testimonials) : ?>
      <div class="mt-14 grid gap-6 md:grid-cols-3">
        <?php foreach ($testimonials as $i => $t) : ?>
          <figure data-reveal style="--reveal-delay: <?php echo $i * 120; ?>ms" class="flex flex-col rounded-3xl bg-cream p-8 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/5">
            <span class="font-display text-6xl leading-none text-brand-200" aria-hidden="true">&ldquo;</span>
            <blockquote class="-mt-4 flex-1 text-lg leading-relaxed text-ink/85">
              <p><?php echo esc_html($t['quote']); ?></p>
            </blockquote>
            <figcaption class="mt-6 border-t border-brand-900/10 pt-5 text-sm">
              <span class="block font-bold text-brand-950"><?php echo esc_html($t['author']); ?></span>
              <?php if ($t['platform']) : ?>
                <?php if ($t['url']) : ?>
                  <a href="<?php echo esc_url($t['url']); ?>" target="_blank" rel="noopener" class="font-semibold text-brand-700 hover:underline">Review on <?php echo esc_html($t['platform']); ?><span class="sr-only"> (opens in a new tab)</span></a>
                <?php else : ?>
                  <span class="text-ink/70">Review on <?php echo esc_html($t['platform']); ?></span>
                <?php endif; ?>
              <?php endif; ?>
            </figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    <?php elseif (current_user_can('edit_theme_options')) : ?>
      <p class="mt-10 rounded-2xl border-2 border-dashed border-brand-200 p-6 text-sm font-semibold text-brand-900">
        Pending: add up to three authorized, word-for-word reviews in Customize → Dany Maid → Home · 03 Reviews. Only editors see this note.
      </p>
    <?php endif; ?>

    <div data-reveal class="mt-12">
      <?php dm_text_link(dm_mod('home_reviews_cta'), home_url('/reviews/')); ?>
    </div>
  </div>
</section>
