<?php
/**
 * Section eyebrow + H2 + intro. Args: eyebrow, title, body, align ('left' | 'center'),
 * dark (true = light text everywhere; 'below-lg' = light text only below lg, for sections whose
 * photo becomes the background on smaller screens), id (H2 id).
 */

$align = isset($args['align']) ? $args['align'] : 'left';
$mode  = empty($args['dark']) ? 'light' : ($args['dark'] === 'below-lg' ? 'split' : 'dark');

// Literal class strings per mode (Tailwind only compiles classes it finds written out).
$tone = array(
  'eyebrow' => array('light' => 'text-brand-700', 'dark' => 'text-leaf-300', 'split' => 'text-leaf-300 lg:text-brand-700'),
  'line'    => array('light' => 'bg-leaf-500', 'dark' => 'bg-leaf-300', 'split' => 'bg-leaf-300 lg:bg-leaf-500'),
  'title'   => array('light' => 'text-brand-950', 'dark' => 'text-white', 'split' => 'text-white lg:text-brand-950'),
  'body'    => array('light' => 'text-ink/75', 'dark' => 'text-brand-100', 'split' => 'text-brand-100 lg:text-ink/75'),
);
$c = array_map(fn($row) => $row[$mode], $tone);
?>

<div data-reveal class="<?php echo $align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-xl'; ?>">
  <?php if (!empty($args['eyebrow'])) : ?>
    <p class="inline-flex items-center gap-3 text-sm font-extrabold uppercase tracking-[0.14em] <?php echo $c['eyebrow']; ?>">
      <span class="reveal-line h-0.5 w-8 rounded-full <?php echo $c['line']; ?>" aria-hidden="true"></span>
      <?php echo esc_html($args['eyebrow']); ?>
    </p>
  <?php endif; ?>
  <h2 <?php echo !empty($args['id']) ? 'id="' . esc_attr($args['id']) . '"' : ''; ?> class="mt-3 font-display text-3xl font-semibold leading-tight tracking-tight text-balance sm:text-4xl lg:text-[2.75rem] <?php echo $c['title']; ?>"><?php echo esc_html($args['title']); ?></h2>
  <?php if (!empty($args['body'])) : ?>
    <p class="mt-5 text-lg leading-relaxed <?php echo $c['body']; ?>"><?php echo esc_html($args['body']); ?></p>
  <?php endif; ?>
</div>
