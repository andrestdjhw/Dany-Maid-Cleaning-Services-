<?php
/**
 * Inner-page hero: breadcrumbs, eyebrow, H1, intro, CTAs and an optional photo.
 * Args: eyebrow, title (H1), intro, cta (label for the quote CTA), service (quote context),
 *       secondary (array label/url), image (attachment id), stock (theme stock image name).
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
));
$has_photo = $args['image'] || $args['stock'];
$crumbs    = dm_breadcrumbs();
?>

<section class="relative overflow-hidden bg-cream" aria-labelledby="page-title">
  <div class="pointer-events-none absolute -right-40 -top-40 size-128 animate-float-slow rounded-full bg-brand-100/60 blur-3xl" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -left-24 bottom-0 size-72 animate-float rounded-full bg-leaf-100/70 blur-3xl" aria-hidden="true"></div>

  <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 py-12 sm:px-6 lg:px-8 lg:py-20 <?php echo $has_photo ? 'lg:grid-cols-12 lg:gap-16' : ''; ?>">
    <div class="<?php echo $has_photo ? 'lg:col-span-6' : 'max-w-3xl'; ?>">
      <nav aria-label="Breadcrumb" class="animate-fade-up">
        <ol class="flex flex-wrap items-center gap-2 text-sm text-ink/60">
          <?php foreach ($crumbs as $i => $crumb) : ?>
            <li class="flex items-center gap-2">
              <?php if ($i < count($crumbs) - 1) : ?>
                <a href="<?php echo esc_url($crumb['url']); ?>" class="font-semibold text-brand-700 hover:underline"><?php echo esc_html($crumb['label']); ?></a>
                <span aria-hidden="true">/</span>
              <?php else : ?>
                <span aria-current="page"><?php echo esc_html($crumb['label']); ?></span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ol>
      </nav>

      <?php if ($args['eyebrow']) : ?>
        <p style="animation-delay: 80ms" class="mt-6 inline-flex animate-fade-up items-center gap-3 text-sm font-extrabold uppercase tracking-[0.14em] text-brand-700">
          <span class="h-0.5 w-8 rounded-full bg-leaf-500" aria-hidden="true"></span><?php echo esc_html($args['eyebrow']); ?>
        </p>
      <?php endif; ?>

      <h1 id="page-title" style="animation-delay: 140ms" class="mt-4 animate-fade-up font-display text-4xl font-semibold leading-[1.08] tracking-tight text-balance text-brand-950 sm:text-5xl lg:text-[3.5rem]">
        <?php echo esc_html($args['title']); ?>
      </h1>

      <?php if ($args['intro']) : ?>
        <p style="animation-delay: 220ms" class="mt-6 max-w-xl animate-fade-up text-lg leading-relaxed text-ink/80 sm:text-xl"><?php echo esc_html($args['intro']); ?></p>
      <?php endif; ?>

      <?php if ($args['cta'] || $args['secondary']) : ?>
        <div style="animation-delay: 300ms" class="mt-8 flex animate-fade-up flex-col gap-3 sm:flex-row">
          <?php if ($args['cta']) {
            dm_quote_cta($args['cta'], 'page_hero', 'primary', array('service' => $args['service']));
          } ?>
          <?php if ($args['secondary']) {
            dm_button($args['secondary']['label'], $args['secondary']['url'], 'secondary');
          } ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if ($has_photo) : ?>
      <div style="animation-delay: 150ms" class="relative animate-fade-in-zoom lg:col-span-6">
        <div class="absolute -bottom-6 -left-6 hidden size-36 animate-float rounded-full bg-leaf-200/70 lg:block" aria-hidden="true"></div>
        <div class="relative aspect-[4/3] overflow-hidden rounded-[2rem] shadow-2xl shadow-brand-900/20">
          <?php dm_photo($args['image'], $args['stock'], '', 'size-full animate-slow-zoom object-cover', '(min-width: 1024px) 600px, 100vw', true); ?>
          <div class="absolute inset-0 bg-linear-to-t from-brand-950/25 via-transparent to-transparent" aria-hidden="true"></div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
