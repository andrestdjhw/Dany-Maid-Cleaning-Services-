<?php
/**
 * Home · 09 FAQ: accordion + FAQPage schema via template-parts/components/faq-list.php.
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

    <div class="lg:col-span-7">
      <?php get_template_part('template-parts/components/faq-list', null, array('items' => $faqs)); ?>
    </div>
  </div>
</section>
