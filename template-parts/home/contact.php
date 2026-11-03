<?php
/**
 * Home · 10 Contact form. The form itself is React (src/scripts/components/ContactForm.js);
 * this template renders the copy, contact details and the mount point.
 */

$business = dm_business();
$promises = array(
  'A real person from our local team reviews every request.',
  'Sending this form does not book an appointment—we confirm details with you first.',
  'Your information is only used to respond to your request.',
);
?>

<section id="contact" class="relative scroll-mt-28 overflow-hidden bg-brand-900 py-20 lg:py-28" aria-labelledby="contact-title">
  <div class="pointer-events-none absolute -right-32 top-0 size-96 animate-float-slow rounded-full bg-brand-700/50 blur-3xl" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -left-20 bottom-0 size-80 animate-float rounded-full bg-leaf-500/15 blur-3xl" aria-hidden="true"></div>

  <div class="relative mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
    <div class="lg:col-span-5">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Request a quote',
        'title'   => dm_mod('home_contact_title'),
        'body'    => dm_mod('home_contact_body'),
        'dark'    => true,
        'id'      => 'contact-title',
      )); ?>

      <ul class="mt-8 space-y-4">
        <?php foreach ($promises as $i => $promise) : ?>
          <li data-reveal style="--reveal-delay: <?php echo 100 + $i * 90; ?>ms" class="flex gap-3 text-brand-100">
            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-leaf-500 text-brand-950"><?php echo dm_icon('check', 'size-4'); ?></span>
            <?php echo esc_html($promise); ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <div data-reveal style="--reveal-delay: 400ms" class="mt-10 space-y-4 rounded-3xl bg-white/[0.07] p-6 ring-1 ring-white/15">
        <p class="text-sm font-extrabold uppercase tracking-[0.14em] text-leaf-300">Prefer to talk?</p>
        <a href="<?php echo esc_url($business['phoneHref']); ?>" data-location="contact_section" class="flex items-center gap-3 font-display text-2xl font-semibold text-white hover:underline">
          <?php echo dm_icon('phone', 'size-6 text-leaf-300'); ?><?php echo esc_html($business['phone']); ?>
        </a>
        <?php if ($business['email']) : ?>
          <a href="mailto:<?php echo esc_attr($business['email']); ?>" class="flex items-center gap-3 text-brand-100 hover:text-white hover:underline">
            <?php echo dm_icon('envelope', 'size-5 text-leaf-300'); ?><?php echo esc_html($business['email']); ?>
          </a>
        <?php endif; ?>
        <p class="flex items-start gap-3 text-brand-100">
          <?php echo dm_icon('map-pin', 'size-5 shrink-0 text-leaf-300'); ?>
          <span><?php echo esc_html($business['street']); ?>, <?php echo esc_html($business['city']); ?>, <?php echo esc_html($business['region'] . ' ' . $business['zip']); ?></span>
        </p>
      </div>
    </div>

    <div data-reveal="zoom" class="lg:col-span-7">
      <!-- React: src/scripts/components/ContactForm.js -->
      <div id="dm-contact-form" class="min-h-160 rounded-[2rem] bg-white p-6 shadow-2xl shadow-brand-950/40 sm:p-10">
        <noscript>
          <p class="text-ink/80">Please call us at <a class="font-bold text-brand-700" href="<?php echo esc_url($business['phoneHref']); ?>"><?php echo esc_html($business['phone']); ?></a> or email <a class="font-bold text-brand-700" href="mailto:<?php echo esc_attr($business['email']); ?>"><?php echo esc_html($business['email']); ?></a>.</p>
        </noscript>
      </div>
    </div>
  </div>
</section>
