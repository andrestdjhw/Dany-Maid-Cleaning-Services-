<?php
/**
 * "What each tier covers": recurring vs deep vs move-in/out (dm_scope_comparison() in inc/scope.php).
 * Args: current (tier key to highlight, optional), bg ('white' | 'cream' | 'tint' light turquoise, used
 *       between two cream sections).
 * "Not included" is a muted bar plus screen-reader text (no dash characters in visible copy).
 */

$data    = dm_scope_comparison();
$current = isset($args['current']) ? $args['current'] : '';
$bg      = isset($args['bg']) ? $args['bg'] : 'white';
$order   = array_keys($data['tiers']);
?>

<section class="<?php echo $bg === 'cream' ? 'bg-cream' : ($bg === 'tint' ? 'bg-brand-50' : 'bg-white'); ?> py-20 lg:py-28" aria-labelledby="compare-title">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <?php get_template_part('template-parts/components/section-heading', null, array(
      'eyebrow' => 'Scope comparison',
      'title'   => 'What Each Service Covers.',
      'body'    => 'Each tier builds on the one before it. Airbnb and commercial scopes are tailored to each client.',
      'align'   => 'center',
      'id'      => 'compare-title',
    )); ?>

    <div data-reveal class="mx-auto mt-12 max-w-4xl overflow-hidden rounded-3xl bg-white shadow-xl shadow-brand-900/5 ring-1 ring-brand-900/10">
      <table class="w-full text-left text-sm sm:text-base">
        <caption class="sr-only">Tasks included in recurring, deep and move-in / move-out cleaning</caption>
        <thead class="bg-brand-900 text-white">
          <tr>
            <th scope="col" class="px-4 py-4 font-bold sm:px-6">Task</th>
            <?php foreach ($data['tiers'] as $key => $label) : ?>
              <th scope="col" class="w-20 px-2 py-4 text-center text-xs font-bold leading-tight sm:w-36 sm:text-base <?php echo $key === $current ? 'bg-cta' : ''; ?>">
                <a href="<?php echo esc_url(dm_page_url(dm_services()[$key]['slug'])); ?>" class="hover:underline"><?php echo esc_html($label); ?></a>
              </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data['rows'] as $i => $row) : ?>
            <tr class="<?php echo $i % 2 ? 'bg-brand-50/60' : 'bg-white'; ?>">
              <th scope="row" class="px-4 py-3.5 font-semibold text-ink/85 sm:px-6"><?php echo esc_html($row[0]); ?></th>
              <?php foreach ($order as $key) :
                $included = array_search($key, $order, true) >= array_search($row[1], $order, true);
                ?>
                <td class="px-2 py-3.5 text-center <?php echo $key === $current ? 'bg-brand-100/60' : ''; ?>">
                  <?php if ($included) : ?>
                    <span class="mx-auto flex size-7 items-center justify-center rounded-full bg-leaf-500 text-white"><?php echo dm_icon('check', 'size-4'); ?></span>
                    <span class="sr-only">Included</span>
                  <?php else : ?>
                    <span class="mx-auto block h-0.5 w-4 rounded-full bg-ink/20" aria-hidden="true"></span>
                    <span class="sr-only">Not included</span>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
