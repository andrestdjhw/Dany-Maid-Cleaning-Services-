<?php
/**
 * Home · 09 FAQ: semantic <details> accordion (one open at a time), mirrored as FAQPage schema in inc/seo.php.
 */

$faqs = dm_faqs();
if (!$faqs) {
  return;
}
$business = dm_business();
?>

<section id="faq" class="scroll-mt-28 bg-white py-20 lg:py-28" aria-labelledby="faq-title">
  <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
    <div class="lg:col-span-5">
      <div class="lg:sticky lg:top-32">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => 'FAQ',
          'title'   => dm_mod('home_faq_title'),
          'body'    => dm_mod('home_faq_body'),
          'id'      => 'faq-title',
        )); ?>

        <div data-reveal style="--reveal-delay: 150ms" class="mt-8 flex items-center gap-4 rounded-3xl bg-cream p-6">
          <span class="flex size-12 shrink-0 animate-float items-center justify-center rounded-2xl bg-brand-700 text-white"><?php echo dm_icon('chat', 'size-6'); ?></span>
          <div>
            <p class="font-bold text-brand-950">Still have a question?</p>
            <a href="<?php echo esc_url($business['phoneHref']); ?>" data-location="faq" class="font-semibold text-brand-700 hover:underline">Call <?php echo esc_html($business['phone']); ?></a>
          </div>
        </div>
      </div>
    </div>

    <div class="space-y-3 lg:col-span-7">
      <?php foreach ($faqs as $i => $faq) : ?>
        <details name="dm-faq" data-reveal style="--reveal-delay: <?php echo $i * 70; ?>ms" class="dm-faq group rounded-3xl bg-cream ring-1 ring-transparent transition-colors duration-300 open:bg-white open:shadow-xl open:shadow-brand-900/5 open:ring-brand-900/10" <?php echo $i === 0 ? 'open' : ''; ?>>
          <summary class="flex cursor-pointer list-none items-center justify-between gap-6 rounded-3xl p-6 font-display text-lg font-semibold text-brand-950 transition hover:text-brand-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 sm:text-xl [&::-webkit-details-marker]:hidden">
            <?php echo esc_html($faq['question']); ?>
            <span class="relative flex size-9 shrink-0 items-center justify-center rounded-full bg-white text-brand-700 shadow-sm transition duration-300 group-open:rotate-45 group-open:bg-brand-700 group-open:text-white" aria-hidden="true">
              <span class="absolute h-0.5 w-3.5 rounded-full bg-current"></span>
              <span class="absolute h-3.5 w-0.5 rounded-full bg-current"></span>
            </span>
          </summary>
          <div class="px-6 pb-6 pr-16 leading-relaxed text-ink/75">
            <p><?php echo esc_html($faq['answer']); ?></p>
          </div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
