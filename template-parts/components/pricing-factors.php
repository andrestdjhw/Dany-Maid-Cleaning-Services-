<?php
/**
 * "What affects your quote": generic factors and the approved no-price message (brief §10).
 * Args: bg ('white' | 'cream'), service (quote context).
 */

$cream   = isset($args['bg']) && $args['bg'] === 'cream';
$service = isset($args['service']) ? $args['service'] : '';
?>

<section class="<?php echo $cream ? 'bg-cream' : 'bg-white'; ?> py-20 lg:py-28" aria-labelledby="pricing-title">
  <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
    <div class="lg:col-span-5">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Pricing',
        'title'   => 'What Affects Your Quote.',
        'body'    => 'Pricing depends on your home, condition and service needs. Request a personalized quote and our team will follow up with the details.',
        'id'      => 'pricing-title',
      )); ?>
      <div data-reveal style="--reveal-delay: 150ms" class="mt-8">
        <?php dm_quote_cta('Request a Personalized Quote', 'pricing', 'primary', array('service' => $service)); ?>
      </div>
    </div>

    <ul class="grid gap-5 sm:grid-cols-2 lg:col-span-7">
      <?php foreach (dm_pricing_factors() as $i => $factor) : ?>
        <li data-reveal style="--reveal-delay: <?php echo $i * 90; ?>ms" class="group rounded-3xl p-7 ring-1 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/5 <?php echo $cream ? 'bg-white ring-brand-900/5' : 'bg-cream ring-transparent hover:bg-white hover:ring-brand-900/10'; ?>">
          <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 transition duration-500 group-hover:scale-110 group-hover:bg-brand-700 group-hover:text-white"><?php echo dm_icon($factor['icon'], 'size-6'); ?></span>
          <h3 class="mt-5 font-display text-xl font-semibold text-brand-950"><?php echo esc_html($factor['title']); ?></h3>
          <p class="mt-2 text-ink/75"><?php echo esc_html($factor['text']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
