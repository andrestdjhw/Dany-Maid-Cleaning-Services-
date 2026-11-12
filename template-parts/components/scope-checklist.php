<?php
/**
 * Room-by-room checklist for a service (data: dm_service_scope() in inc/scope.php).
 * Args: key (service key). Renders the move-out "adds" cards, the room cards, or the
 * tailored-scope steps for Airbnb / commercial, whichever the service has.
 */

$scope = dm_service_scope($args['key']);
if (!$scope) {
  return;
}
$has_added = false;

// One checklist line; a leading '+' marks a task added for this tier.
$dm_scope_item = function ($item) use (&$has_added) {
  $added = $item[0] === '+';
  $text  = $added ? substr($item, 1) : $item;
  $has_added = $has_added || $added;
  ?>
  <li class="flex break-inside-avoid gap-2.5 py-1 <?php echo $added ? 'font-bold text-brand-950' : 'text-ink/80'; ?>">
    <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full <?php echo $added ? 'bg-leaf-500 text-white' : 'bg-leaf-100 text-leaf-700'; ?>"><?php echo dm_icon('check', 'size-3.5'); ?></span>
    <span><?php echo esc_html($text); ?><?php if ($added) : ?><span class="sr-only"> (added for move-in / move-out)</span><?php endif; ?></span>
  </li>
  <?php
};
?>

<?php if (!empty($scope['adds'])) : ?>
  <div>
    <h3 data-reveal class="font-display text-2xl font-semibold text-brand-950">What it adds on top of deep cleaning</h3>
    <ul class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($scope['adds'] as $i => $add) : ?>
        <li data-reveal style="--reveal-delay: <?php echo $i * 70; ?>ms" class="group flex gap-4 rounded-3xl border-t-4 border-brand-400 bg-white p-6 shadow-sm ring-1 ring-brand-900/5 transition duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/10">
          <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 transition duration-500 group-hover:bg-cta group-hover:text-white"><?php echo dm_icon($add[0], 'size-6'); ?></span>
          <span>
            <span class="block font-display text-lg font-semibold text-brand-950"><?php echo esc_html($add[1]); ?></span>
            <span class="mt-0.5 block text-ink/75"><?php echo esc_html($add[2]); ?></span>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if (!empty($scope['rooms'])) :
  $simple = empty($scope['rooms'][0]['parts']) && empty($scope['adds']);
  ?>
  <div class="<?php echo !empty($scope['adds']) ? 'mt-16' : ''; ?>">
    <?php if (!empty($scope['adds'])) : ?>
      <div data-reveal class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <h3 class="font-display text-2xl font-semibold text-brand-950">The full checklist, room by room</h3>
        <p class="flex items-center gap-2 text-sm font-semibold text-ink/70">
          <span class="flex size-5 items-center justify-center rounded-full bg-leaf-500 text-white" aria-hidden="true"><?php echo dm_icon('check', 'size-3.5'); ?></span>
          Bold = added for move-in / move-out
        </p>
      </div>
    <?php endif; ?>

    <ul class="grid gap-5 <?php echo $simple ? 'sm:grid-cols-2 lg:grid-cols-4' : 'mt-6 lg:grid-cols-2'; ?>">
      <?php foreach ($scope['rooms'] as $i => $room) :
        $count = dm_scope_room_count($room);
        $dark  = $simple && $i === count($scope['rooms']) - 1; // "Final tasks" closes the visit
        ?>
        <li data-reveal style="--reveal-delay: <?php echo ($i % 4) * 80; ?>ms" class="rounded-3xl border-t-4 p-6 shadow-sm ring-1 sm:p-7 <?php echo $dark ? 'border-leaf-500 bg-brand-900 ring-brand-900' : 'border-brand-400 bg-white ring-brand-900/5'; ?>">
          <div class="flex items-center gap-3">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-xl <?php echo $dark ? 'bg-white/10 text-leaf-300' : 'bg-brand-50 text-brand-700'; ?>"><?php echo dm_icon($room['icon'], 'size-6'); ?></span>
            <h3 class="font-display text-xl font-semibold leading-tight <?php echo $dark ? 'text-white' : 'text-brand-950'; ?>"><?php echo esc_html($room['title']); ?></h3>
            <?php if (!$simple) : ?>
              <span class="ml-auto shrink-0 rounded-full bg-brand-50 px-3 py-1 text-xs font-extrabold text-brand-800"><?php echo (int) $count; ?> tasks</span>
            <?php endif; ?>
          </div>

          <?php if (!empty($room['parts'])) : ?>
            <div class="mt-5 grid gap-5 sm:grid-cols-2">
              <?php foreach ($room['parts'] as $part => $items) : ?>
                <div>
                  <h4 class="text-xs font-extrabold uppercase tracking-[0.12em] text-brand-700"><?php echo esc_html($part); ?></h4>
                  <ul class="mt-2"><?php foreach ($items as $item) { $dm_scope_item($item); } ?></ul>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else : ?>
            <ul class="mt-4 <?php echo $simple ? '' : 'sm:columns-2 sm:gap-6'; ?> <?php echo $dark ? '[&_li]:text-brand-100' : ''; ?>">
              <?php foreach ($room['items'] as $item) { $dm_scope_item($item); } ?>
            </ul>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if (!empty($scope['steps'])) : ?>
  <ol class="grid gap-5 md:grid-cols-3">
    <?php foreach ($scope['steps'] as $i => $step) : ?>
      <li data-reveal style="--reveal-delay: <?php echo $i * 110; ?>ms" class="flex gap-4 rounded-3xl border-t-4 border-brand-400 bg-white p-7 shadow-sm ring-1 ring-brand-900/5">
        <span class="flex size-11 shrink-0 items-center justify-center rounded-full bg-leaf-500 font-display text-lg font-semibold text-brand-950"><?php echo $i + 1; ?></span>
        <span class="pt-2 font-display text-lg font-semibold leading-snug text-brand-950"><?php echo esc_html($step); ?></span>
      </li>
    <?php endforeach; ?>
  </ol>
<?php endif; ?>
