<?php
/**
 * Template Name: Contact
 *
 * /contact/: destination of every "Get a Quote" CTA. Reuses the contact section (React form)
 * and adds the business details. ?service=… preselects the service in the form.
 */

$business = dm_business();

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow' => 'Contact',
    'title'   => 'Contact Dany Maid.',
    'intro'   => 'Request a personalized quote or ask us a question. A real person from our local team reviews every request.',
    'cta'     => '',
    'background' => attachment_url_to_postid(wp_upload_dir()['baseurl'] . '/2026/11/ContactUsHero-scaled.jpg'),
    'focus'   => 'object-[center_85%]',
  )); ?>

  <?php get_template_part('template-parts/home/contact', null, array('form_id' => 'contact_page')); ?>

  <section class="bg-white py-16 lg:py-20" aria-label="Contact details">
    <ul class="mx-auto grid max-w-7xl gap-4 px-4 sm:grid-cols-2 sm:px-6 lg:px-8 <?php echo $business['hours'] ? 'lg:grid-cols-4' : 'lg:grid-cols-3'; ?>">
      <li data-reveal class="rounded-3xl bg-cream p-7">
        <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-700 text-white"><?php echo dm_icon('phone', 'size-6'); ?></span>
        <h2 class="mt-5 font-display text-xl font-semibold text-brand-950">Call us</h2>
        <a href="<?php echo esc_url($business['phoneHref']); ?>" data-location="contact_details" class="mt-1 block font-semibold text-brand-700 hover:underline"><?php echo esc_html($business['phone']); ?></a>
      </li>
      <?php if ($business['email']) : ?>
        <li data-reveal style="--reveal-delay: 90ms" class="rounded-3xl bg-cream p-7">
          <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-700 text-white"><?php echo dm_icon('envelope', 'size-6'); ?></span>
          <h2 class="mt-5 font-display text-xl font-semibold text-brand-950">Email us</h2>
          <a href="mailto:<?php echo esc_attr($business['email']); ?>" class="mt-1 block break-all font-semibold text-brand-700 hover:underline"><?php echo esc_html($business['email']); ?></a>
        </li>
      <?php endif; ?>
      <li data-reveal style="--reveal-delay: 180ms" class="rounded-3xl bg-cream p-7">
        <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-700 text-white"><?php echo dm_icon('map-pin', 'size-6'); ?></span>
        <h2 class="mt-5 font-display text-xl font-semibold text-brand-950">Our office</h2>
        <p class="mt-1 text-ink/75"><?php echo esc_html($business['street']); ?>, <?php echo esc_html($business['city'] . ', ' . $business['region'] . ' ' . $business['zip']); ?></p>
        <?php if ($business['mapsUrl']) : ?>
          <a href="<?php echo esc_url($business['mapsUrl']); ?>" target="_blank" rel="noopener" class="mt-2 inline-block font-semibold text-brand-700 hover:underline">Open in Google Maps<span class="sr-only"> (opens in a new tab)</span></a>
        <?php endif; ?>
      </li>
      <?php if ($business['hours']) : ?>
        <li data-reveal style="--reveal-delay: 270ms" class="rounded-3xl bg-cream p-7">
          <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-700 text-white"><?php echo dm_icon('calendar', 'size-6'); ?></span>
          <h2 class="mt-5 font-display text-xl font-semibold text-brand-950">Hours</h2>
          <p class="mt-1 text-ink/75"><?php echo esc_html($business['hours']); ?></p>
        </li>
      <?php endif; ?>
    </ul>
  </section>
</main>

<?php get_footer();
