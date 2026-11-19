<?php
/**
 * Template Name: Legal Page
 *
 * /privacy-policy/ and /terms-and-conditions/. Content lives in inc/legal.php (dm_legal_content()),
 * keyed by the page slug. Sticky table of contents on desktop.
 */

$slug    = get_post_field('post_name', get_queried_object_id());
$content = dm_legal_content($slug);

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow' => 'Legal',
    'title'   => get_the_title(),
    'intro'   => 'Last updated: ' . DM_LEGAL_UPDATED,
    'cta'     => '',
  )); ?>

  <section class="bg-white py-16 lg:py-24">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
      <?php if ($content) : ?>
        <nav aria-label="On this page" class="lg:col-span-4 xl:col-span-3">
          <div class="rounded-3xl bg-cream p-6 lg:sticky lg:top-[calc(var(--dm-header)+var(--dm-admin-bar)+1.5rem)]">
            <p class="text-xs font-extrabold uppercase tracking-[0.14em] text-brand-700">On this page</p>
            <ol class="mt-4 space-y-2 text-sm">
              <?php foreach ($content['sections'] as $i => $section) : ?>
                <li><a href="#<?php echo esc_attr($section[0]); ?>" class="flex gap-2 font-semibold text-ink/75 hover:text-brand-700 hover:underline"><span class="w-5 shrink-0 text-brand-400"><?php echo $i + 1; ?>.</span><?php echo esc_html($section[1]); ?></a></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </nav>

        <article class="prose prose-lg min-w-0 max-w-none lg:col-span-8 xl:col-span-9 prose-headings:font-display prose-headings:text-brand-950 prose-h2:scroll-mt-40 prose-h2:text-3xl prose-h3:text-xl prose-a:text-brand-700 prose-strong:text-brand-950 prose-li:marker:text-leaf-600 prose-code:rounded prose-code:bg-brand-50 prose-code:px-1.5 prose-code:py-0.5 prose-code:font-medium prose-code:text-brand-800 prose-code:before:content-none prose-code:after:content-none">
          <p class="lead"><?php echo wp_kses_post($content['intro']); ?></p>
          <?php foreach ($content['sections'] as $i => $section) : ?>
            <h2 id="<?php echo esc_attr($section[0]); ?>"><?php echo esc_html(($i + 1) . '. ' . $section[1]); ?></h2>
            <?php echo wp_kses_post($section[2]); ?>
          <?php endforeach; ?>
        </article>
      <?php else : ?>
        <div class="prose prose-lg lg:col-span-12"><?php the_content(); ?></div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer();
