<?php
/**
 * Home · 04 Why Dany Maid: verifiable proof (W2 / background checks / insurance / since 2013).
 */

$pillar_icons = array(1 => 'user-group', 2 => 'identification', 3 => 'shield-check', 4 => 'calendar');
?>

<section class="bg-cream py-20 lg:py-28" aria-labelledby="trust-title">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
      <div class="lg:col-span-5">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => 'Why Dany Maid',
          'title'   => dm_mod('home_trust_title'),
          'body'    => dm_mod('home_trust_body'),
          'id'      => 'trust-title',
        )); ?>
        <div class="mt-8">
          <?php dm_text_link(dm_mod('home_trust_cta'), home_url('/why-dany-maid/')); ?>
        </div>

        <!-- Dany Maid's own seals (assets/images/: cert-badge from CertBadge.png, quality-badge from QACert.webp) -->
        <div data-reveal style="--reveal-delay: 150ms" class="mt-10 flex items-center justify-start gap-4 sm:gap-6">
          <img src="<?php echo esc_url(get_theme_file_uri('assets/images/cert-badge-400.webp')); ?>" width="400" height="400" loading="lazy" decoding="async" alt="Dany Maid Verified Employees badge: background checked, safe and trusted" class="size-32 animate-float object-contain drop-shadow-[0_12px_18px_rgba(15,43,54,0.25)] sm:size-40">
          <img src="<?php echo esc_url(get_theme_file_uri('assets/images/quality-badge-512.webp')); ?>" width="512" height="512" loading="lazy" decoding="async" alt="Dany Maid Quality Guaranteed seal" style="animation-delay: -3s" class="size-32 animate-float object-contain drop-shadow-[0_12px_18px_rgba(15,43,54,0.25)] sm:size-40">
        </div>
      </div>

      <ul class="grid gap-5 sm:grid-cols-2 lg:col-span-7">
        <?php foreach ($pillar_icons as $i => $icon) : ?>
          <li data-reveal style="--reveal-delay: <?php echo $i * 100; ?>ms" class="group rounded-3xl bg-white p-7 shadow-sm ring-1 ring-brand-900/5 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/10 hover:ring-brand-900/10">
            <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 transition duration-500 group-hover:scale-110 group-hover:bg-brand-700 group-hover:text-white"><?php echo dm_icon($icon, 'size-6'); ?></span>
            <h3 class="mt-5 font-display text-xl font-semibold text-brand-950"><?php echo esc_html(dm_mod("home_trust_pillar_{$i}_title")); ?></h3>
            <p class="mt-2 text-ink/75"><?php echo esc_html(dm_mod("home_trust_pillar_{$i}_text")); ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
