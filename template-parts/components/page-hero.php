<?php
/**
 * Inner-page hero: breadcrumbs, eyebrow, H1, intro, CTAs and an optional photo.
 * Args: eyebrow, title (H1), intro, cta (label for the quote CTA), service (quote context),
 *       secondary (array label/url), image (attachment id), stock (theme stock image name),
 *       background (attachment id: full-bleed photo behind the copy, switches to light text),
 *       focus (literal object-position class for the background, e.g. 'object-bottom').
 *
 * Three modes: 'bg' (background photo at every width), 'split' (photo beside the copy on lg+,
 * full-bleed behind it below lg so it doesn't sit alone under the text) and 'plain' (no photo).
 */

$args = wp_parse_args($args, array(
  'eyebrow'   => '',
  'title'     => get_the_title(),
  'intro'     => '',
  'cta'       => 'Get a Quote',
  'service'   => '',
  'secondary' => null,
  'image'     => 0,
  'stock'     => '',
  'background' => 0,
  'focus'      => 'object-[center_40%]',
));
$mode   = wp_get_attachment_image_src($args['background']) ? 'bg' : (($args['image'] || $args['stock']) ? 'split' : 'plain');
$crumbs = dm_breadcrumbs();

// Literal class strings per mode (Tailwind only compiles classes it finds written out).
$tone = array(
  'section' => array('bg' => 'bg-brand-950', 'split' => 'bg-brand-950 lg:bg-cream', 'plain' => 'bg-cream'),
  'blob'    => array('bg' => 'hidden', 'split' => 'hidden lg:block', 'plain' => ''),
  'wrap'    => array('bg' => 'relative py-20 lg:py-32', 'split' => 'py-20 sm:py-24 lg:relative lg:grid-cols-12 lg:gap-16 lg:py-20', 'plain' => 'relative py-12 lg:py-20'),
  'copy'    => array('bg' => 'max-w-3xl', 'split' => 'relative z-10 lg:col-span-6', 'plain' => 'max-w-3xl'),
  'crumbs'  => array('bg' => 'text-white/80', 'split' => 'text-white/80 lg:text-ink/60', 'plain' => 'text-ink/60'),
  'link'    => array('bg' => 'text-white', 'split' => 'text-white lg:text-brand-700', 'plain' => 'text-brand-700'),
  'eyebrow' => array('bg' => 'text-leaf-300', 'split' => 'text-leaf-300 lg:text-brand-700', 'plain' => 'text-brand-700'),
  'title'   => array('bg' => 'text-white', 'split' => 'text-white lg:text-brand-950', 'plain' => 'text-brand-950'),
  'intro'   => array('bg' => 'text-white/90', 'split' => 'text-white/90 lg:text-ink/80', 'plain' => 'text-ink/80'),
);
$c = array_map(fn($row) => $row[$mode], $tone);
?>

<section class="relative overflow-hidden <?php echo $c['section']; ?>" aria-labelledby="page-title">
  <?php if ($mode === 'bg') : ?>
    <?php echo wp_get_attachment_image($args['background'], 'full', false, array(
      'class'         => 'absolute inset-0 size-full animate-slow-zoom object-cover ' . $args['focus'],
      'alt'           => '',
      'sizes'         => '100vw',
      'loading'       => 'eager',
      'fetchpriority' => 'high',
    )); ?>
    <!-- Dark veil, heavier behind the copy, keeps white text at AA contrast over any part of the photo -->
    <div class="absolute inset-0 bg-linear-to-t from-brand-950/85 via-brand-950/70 to-brand-950/65 lg:bg-linear-to-r lg:from-brand-950/85 lg:via-brand-950/55 lg:to-brand-950/15" aria-hidden="true"></div>
  <?php else : ?>
    <div class="pointer-events-none absolute -right-40 -top-40 size-128 animate-float-slow rounded-full bg-brand-100/60 blur-3xl <?php echo $c['blob']; ?>" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -left-24 bottom-0 size-72 animate-float rounded-full bg-leaf-100/70 blur-3xl <?php echo $c['blob']; ?>" aria-hidden="true"></div>
  <?php endif; ?>

  <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:px-8 <?php echo $c['wrap']; ?>">
    <div class="<?php echo $c['copy']; ?>">
      <nav aria-label="Breadcrumb" class="animate-fade-up">
        <ol class="flex flex-wrap items-center gap-2 text-sm <?php echo $c['crumbs']; ?>">
          <?php foreach ($crumbs as $i => $crumb) : ?>
            <li class="flex items-center gap-2">
              <?php if ($i < count($crumbs) - 1) : ?>
                <a href="<?php echo esc_url($crumb['url']); ?>" class="font-semibold hover:underline <?php echo $c['link']; ?>"><?php echo esc_html($crumb['label']); ?></a>
                <span aria-hidden="true">/</span>
              <?php else : ?>
                <span aria-current="page"><?php echo esc_html($crumb['label']); ?></span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ol>
      </nav>

      <?php if ($args['eyebrow']) : ?>
        <p style="animation-delay: 80ms" class="mt-6 inline-flex animate-fade-up items-center gap-3 text-sm font-extrabold uppercase tracking-[0.14em] <?php echo $c['eyebrow']; ?>">
          <span class="h-0.5 w-8 rounded-full bg-leaf-500" aria-hidden="true"></span><?php echo esc_html($args['eyebrow']); ?>
        </p>
      <?php endif; ?>

      <h1 id="page-title" style="animation-delay: 140ms" class="mt-4 animate-fade-up font-display text-4xl font-semibold leading-[1.08] tracking-tight text-balance sm:text-5xl lg:text-[3.5rem] <?php echo $c['title']; ?>">
        <?php echo esc_html($args['title']); ?>
      </h1>

      <?php if ($args['intro']) : ?>
        <p style="animation-delay: 220ms" class="mt-6 max-w-xl animate-fade-up text-lg leading-relaxed sm:text-xl <?php echo $c['intro']; ?>"><?php echo esc_html($args['intro']); ?></p>
      <?php endif; ?>

      <?php if ($args['cta'] || $args['secondary']) : ?>
        <div style="animation-delay: 300ms" class="mt-8 flex animate-fade-up flex-col gap-3 sm:flex-row">
          <?php if ($args['cta']) {
            dm_quote_cta($args['cta'], 'page_hero', $mode === 'bg' ? 'light' : 'primary', array('service' => $args['service']));
          } ?>
          <?php if ($args['secondary']) {
            dm_button($args['secondary']['label'], $args['secondary']['url'], $mode === 'bg' ? 'ghost' : 'secondary');
          } ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if ($mode === 'split') : ?>
      <div style="animation-delay: 150ms" class="absolute inset-0 animate-fade-in-zoom lg:relative lg:inset-auto lg:col-span-6">
        <div class="absolute -bottom-6 -left-6 hidden size-36 animate-float rounded-full bg-leaf-200/70 lg:block" aria-hidden="true"></div>
        <div class="relative h-full overflow-hidden lg:aspect-[4/3] lg:h-auto lg:rounded-[2rem] lg:shadow-2xl lg:shadow-brand-900/20">
          <?php dm_photo($args['image'], $args['stock'], '', 'size-full animate-slow-zoom object-cover', '(min-width: 1024px) 600px, 100vw', true); ?>
          <!-- Below lg: dark veil so the white copy reads over the photo. lg+: soft bottom shade only. -->
          <div class="absolute inset-0 bg-linear-to-b from-brand-950/80 via-brand-950/70 to-brand-950/85 lg:bg-linear-to-t lg:from-brand-950/25 lg:via-transparent lg:to-transparent" aria-hidden="true"></div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
