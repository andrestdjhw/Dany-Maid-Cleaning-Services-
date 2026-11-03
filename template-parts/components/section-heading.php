<?php
/**
 * Section eyebrow + H2 + intro. Args: eyebrow, title, body, align ('left' | 'center'), dark (bool), id (H2 id).
 */

$align = isset($args['align']) ? $args['align'] : 'left';
$dark  = !empty($args['dark']);
?>

<div data-reveal class="<?php echo $align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-xl'; ?>">
  <?php if (!empty($args['eyebrow'])) : ?>
    <p class="inline-flex items-center gap-3 text-sm font-extrabold uppercase tracking-[0.14em] <?php echo $dark ? 'text-leaf-300' : 'text-brand-700'; ?>">
      <span class="reveal-line h-0.5 w-8 rounded-full <?php echo $dark ? 'bg-leaf-300' : 'bg-leaf-500'; ?>" aria-hidden="true"></span>
      <?php echo esc_html($args['eyebrow']); ?>
    </p>
  <?php endif; ?>
  <h2 <?php echo !empty($args['id']) ? 'id="' . esc_attr($args['id']) . '"' : ''; ?> class="mt-3 font-display text-3xl font-semibold leading-tight tracking-tight text-balance sm:text-4xl lg:text-[2.75rem] <?php echo $dark ? 'text-white' : 'text-brand-950'; ?>"><?php echo esc_html($args['title']); ?></h2>
  <?php if (!empty($args['body'])) : ?>
    <p class="mt-5 text-lg leading-relaxed <?php echo $dark ? 'text-brand-100' : 'text-ink/75'; ?>"><?php echo esc_html($args['body']); ?></p>
  <?php endif; ?>
</div>
