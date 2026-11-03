<?php
/**
 * Closing CTA band for inner pages. Args: title, body, cta (label), service (quote context).
 */

$args = wp_parse_args($args, array(
  'title'   => 'Ready for a cleaner home?',
  'body'    => 'Tell us about your home and our team will help you find the next step.',
  'cta'     => 'Get a Quote',
  'service' => '',
));
$business = dm_business();
?>

<section class="relative overflow-hidden bg-brand-900 py-16 lg:py-20">
  <div class="pointer-events-none absolute -right-24 -top-24 size-80 animate-float-slow rounded-full bg-leaf-500/15 blur-3xl" aria-hidden="true"></div>
  <div data-reveal class="relative mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-4 sm:px-6 lg:flex-row lg:items-center lg:px-8">
    <div class="max-w-2xl">
      <h2 class="font-display text-3xl font-semibold text-balance text-white sm:text-4xl"><?php echo esc_html($args['title']); ?></h2>
      <p class="mt-3 text-lg text-brand-100"><?php echo esc_html($args['body']); ?></p>
    </div>
    <div class="flex flex-col gap-3 sm:flex-row">
      <?php dm_quote_cta($args['cta'], 'cta_band', 'light', array('service' => $args['service'])); ?>
      <a href="<?php echo esc_url($business['phoneHref']); ?>" data-location="cta_band" class="<?php echo esc_attr(dm_button_classes('ghost')); ?> whitespace-nowrap">
        <?php echo dm_icon('phone', 'size-5'); ?><?php echo esc_html($business['phone']); ?>
      </a>
    </div>
  </div>
</section>
