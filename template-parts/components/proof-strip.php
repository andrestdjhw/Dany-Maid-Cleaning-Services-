<?php
/**
 * Compact trust proof for inner pages: the four verified trust points + linked ratings.
 * Args: bg ('white' | 'cream').
 */

$cream = isset($args['bg']) && $args['bg'] === 'cream';
$icons = array(1 => 'user-group', 2 => 'identification', 3 => 'shield-check', 4 => 'calendar');
?>

<section class="<?php echo $cream ? 'bg-cream' : 'bg-white'; ?> py-20 lg:py-24" aria-labelledby="proof-title">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid items-end gap-10 lg:grid-cols-2">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Why Dany Maid',
        'title'   => dm_mod('home_trust_title'),
        'body'    => dm_mod('home_trust_body'),
        'id'      => 'proof-title',
      )); ?>
      <div data-reveal="right">
        <?php get_template_part('template-parts/components/rating-badges', null, array('variant' => 'card')); ?>
      </div>
    </div>

    <ul class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach ($icons as $i => $icon) : ?>
        <li data-reveal style="--reveal-delay: <?php echo $i * 80; ?>ms" class="flex items-center gap-4 rounded-2xl p-5 ring-1 <?php echo $cream ? 'bg-white ring-brand-900/5' : 'bg-cream ring-transparent'; ?>">
          <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-brand-700 text-white"><?php echo dm_icon($icon, 'size-5'); ?></span>
          <span class="font-bold text-brand-950"><?php echo esc_html(dm_mod("home_trust_pillar_{$i}_title")); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>

    <div data-reveal class="mt-10">
      <?php dm_text_link(dm_mod('home_trust_cta'), dm_page_url('why-dany-maid')); ?>
    </div>
  </div>
</section>
