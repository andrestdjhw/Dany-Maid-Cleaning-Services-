<?php
/**
 * FAQ accordion (semantic <details>, one open at a time) + matching FAQPage JSON-LD,
 * so the schema always mirrors exactly what is visible (search engine requirement).
 * Args: items (array of question/answer), name (accordion group), schema (bool, default true).
 * Only one FAQ list per page should output schema.
 */

$items = isset($args['items']) ? $args['items'] : array();
if (!$items) {
  return;
}
$name   = isset($args['name']) ? $args['name'] : 'dm-faq';
$schema = !isset($args['schema']) || $args['schema'];
?>

<div class="space-y-3">
  <?php foreach ($items as $i => $faq) : ?>
    <details name="<?php echo esc_attr($name); ?>" data-reveal style="--reveal-delay: <?php echo $i * 70; ?>ms" class="dm-faq group rounded-3xl bg-cream ring-1 ring-transparent transition-colors duration-300 open:bg-white open:shadow-xl open:shadow-brand-900/5 open:ring-brand-900/10" <?php echo $i === 0 ? 'open' : ''; ?>>
      <summary class="flex cursor-pointer list-none items-center justify-between gap-6 rounded-3xl p-6 font-display text-lg font-semibold text-brand-950 transition hover:text-brand-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 sm:text-xl [&::-webkit-details-marker]:hidden">
        <?php echo esc_html($faq['question']); ?>
        <span class="relative flex size-9 shrink-0 items-center justify-center rounded-full bg-white text-brand-700 shadow-sm transition duration-300 group-open:rotate-45 group-open:bg-brand-700 group-open:text-white" aria-hidden="true">
          <span class="absolute h-0.5 w-3.5 rounded-full bg-current"></span>
          <span class="absolute h-3.5 w-0.5 rounded-full bg-current"></span>
        </span>
      </summary>
      <div class="px-6 pb-6 pr-16 leading-relaxed text-ink/75">
        <p><?php echo esc_html($faq['answer']); ?></p>
      </div>
    </details>
  <?php endforeach; ?>
</div>

<?php if ($schema) : ?>
  <script type="application/ld+json"><?php echo wp_json_encode(array(
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(function ($faq) {
      return array(
        '@type'          => 'Question',
        'name'           => $faq['question'],
        'acceptedAnswer' => array('@type' => 'Answer', 'text' => $faq['answer']),
      );
    }, $items),
  ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
<?php endif; ?>
