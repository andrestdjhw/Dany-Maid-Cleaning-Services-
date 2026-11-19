<?php
/**
 * Pet friendly: confirmed by the client (2026-11-11), no extra cost for homes with pets.
 * Used on the home page and on Why Dany Maid.
 * Args: bg ('white' | 'cream' | 'tint' = brand-50), position (GA4 position of the quote CTA).
 */

$args = wp_parse_args($args, array('bg' => 'white', 'position' => 'home_pets'));
?>

<section class="relative overflow-hidden <?php echo $args['bg'] === 'cream' ? 'bg-cream' : ($args['bg'] === 'tint' ? 'bg-brand-50' : 'bg-white'); ?> py-20 lg:py-28" aria-labelledby="pets-title">
  <div class="pointer-events-none absolute -left-24 top-10 size-80 animate-float-slow rounded-full bg-leaf-100 blur-3xl" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -right-24 bottom-0 size-72 animate-float rounded-full bg-brand-50 blur-3xl" aria-hidden="true"></div>

  <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
    <div class="lg:col-span-6">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Pet friendly',
        'title'   => 'Pet Friendly, at No Extra Cost.',
        'body'    => 'Your pets are part of the family, and they are welcome during your cleaning. Having pets at home does not add any extra cost to your service with Dany Maid.',
        'id'      => 'pets-title',
      )); ?>

      <ul class="mt-8 space-y-4">
        <?php foreach (array(
          'No additional charge for homes with pets.',
          'Tell us about your pets when you request a quote, so our team knows who they will meet.',
          'Share any special instructions, like gates, closed rooms, or feeding routines.',
        ) as $i => $point) : ?>
          <li data-reveal style="--reveal-delay: <?php echo 100 + $i * 90; ?>ms" class="flex gap-3 text-ink/80">
            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-leaf-100 text-leaf-700"><?php echo dm_icon('check', 'size-4'); ?></span>
            <?php echo esc_html($point); ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <div data-reveal style="--reveal-delay: 400ms" class="mt-10">
        <?php dm_quote_cta('Get a Quote', $args['position']); ?>
      </div>
    </div>

    <div data-reveal="zoom" class="relative lg:col-span-6">
      <div class="absolute -right-5 -top-5 hidden size-28 animate-float-slow rounded-full bg-leaf-200/80 sm:block" aria-hidden="true"></div>
      <span class="absolute -top-8 left-10 z-10 hidden -rotate-12 animate-float text-leaf-500 sm:block" aria-hidden="true"><?php echo dm_icon('paw', 'size-10'); ?></span>
      <span class="absolute -right-6 bottom-24 z-10 hidden rotate-12 animate-float-slow text-brand-300 sm:block" aria-hidden="true"><?php echo dm_icon('paw', 'size-8'); ?></span>

      <!-- Photo: uploads/2026/11/PetFriendlyActualizado.png (2026-11-17), optimized to assets/images/pet-friendly-*.webp -->
      <div class="group relative aspect-[4/3] overflow-hidden rounded-3xl shadow-2xl shadow-brand-900/15 sm:rounded-[2rem]">
        <img
          src="<?php echo esc_url(dm_versioned_asset('assets/images/pet-friendly-1536.webp')); ?>"
          srcset="<?php echo esc_url(dm_versioned_asset('assets/images/pet-friendly-800.webp')); ?> 800w, <?php echo esc_url(dm_versioned_asset('assets/images/pet-friendly-1536.webp')); ?> 1536w"
          sizes="(min-width: 1024px) 640px, 100vw"
          width="1536" height="1024" loading="lazy" decoding="async"
          alt="A Dany Maid team member petting a happy golden retriever in a client's living room"
          class="size-full object-cover object-[center_45%] transition duration-1000 ease-(--ease-out-soft) group-hover:scale-105"
        >
      </div>

      <div class="absolute -bottom-6 left-4 flex animate-float items-center gap-3 rounded-2xl bg-white py-3 pl-3 pr-5 shadow-xl ring-1 ring-brand-900/5 sm:-left-6">
        <span class="flex size-12 shrink-0 items-center justify-center rounded-full bg-leaf-500 text-white"><?php echo dm_icon('paw', 'size-7'); ?></span>
        <span class="leading-tight">
          <span class="block font-display text-3xl font-semibold text-brand-950">$0</span>
          <span class="text-sm font-bold text-brand-800">extra for homes with pets</span>
        </span>
      </div>
    </div>
  </div>
</section>
