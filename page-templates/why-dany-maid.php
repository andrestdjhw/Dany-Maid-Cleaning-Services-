<?php
/**
 * Template Name: Why Dany Maid
 *
 * Standards shown as proof, not adjectives (brief §08). Every claim is one the brief marks as verified;
 * the commitment block uses the brief's temporary safe copy until a guarantee is approved (§11).
 */

$standards = array(
  array('icon' => 'user-group', 'title' => 'Our Team', 'text' => 'Our cleaners are W2 employees of Dany Maid, not independent contractors, and the team members who come into your home are background-checked.'),
  array('icon' => 'shield-check', 'title' => 'Professional Care', 'text' => 'Dany Maid is an insured cleaning company. We approach every visit with respect for your home and your belongings.'),
  array('icon' => 'pencil', 'title' => 'Your Preferences Matter', 'text' => 'Before your service, we ask about your priorities, special instructions, and expectations so the visit fits your home.'),
  array('icon' => 'arrow-path', 'title' => 'Consistency', 'text' => 'For recurring clients, we work to keep your schedule and service consistent. We talk with you about team availability rather than promise the same cleaner at every visit.'),
);

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow'   => 'Why Dany Maid',
    'title'     => 'The Difference Is in the Details and the People.',
    'intro'     => 'We believe great cleaning is about more than a checklist. It’s about respecting your home, communicating clearly, and showing up with care.',
    'secondary' => array('label' => 'Read Customer Reviews', 'url' => dm_page_url('reviews')),
    'image'     => dm_mod('home_team_image'),
    'stock'     => 'team-supplies',
  )); ?>

  <section class="bg-white py-20 lg:py-28" aria-labelledby="standards-title">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <?php get_template_part('template-parts/components/section-heading', null, array(
        'eyebrow' => 'Our standards',
        'title'   => 'What You Can Count On.',
        'align'   => 'center',
        'id'      => 'standards-title',
      )); ?>

      <ul class="mt-14 grid gap-6 md:grid-cols-2">
        <?php foreach ($standards as $i => $item) : ?>
          <li data-reveal style="--reveal-delay: <?php echo $i * 100; ?>ms" class="group flex gap-6 rounded-3xl bg-cream p-8 ring-1 ring-transparent transition duration-500 hover:-translate-y-1 hover:bg-white hover:shadow-xl hover:shadow-brand-900/5 hover:ring-brand-900/10">
            <span class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-brand-700 text-white shadow-lg shadow-brand-900/20 transition duration-500 group-hover:-rotate-6 group-hover:scale-110"><?php echo dm_icon($item['icon'], 'size-7'); ?></span>
            <div>
              <h3 class="font-display text-2xl font-semibold text-brand-950"><?php echo esc_html($item['title']); ?></h3>
              <p class="mt-2 leading-relaxed text-ink/75"><?php echo esc_html($item['text']); ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

      <?php if ($content = dm_page_content()) : ?>
        <div data-reveal class="prose prose-lg mx-auto mt-16 max-w-3xl prose-headings:font-display prose-headings:text-brand-950 prose-a:text-brand-700">
          <?php echo $content; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Verified team: Dany Maid's own badge (assets/images/cert-badge-*.webp, from uploads/2026/11/CertBadge.png).
       Copy sticks to verified facts: background-checked, W2 employees, insured, since 2013. -->
  <section class="relative overflow-hidden bg-brand-900 py-20 lg:py-28" aria-labelledby="verified-title">
    <div class="pointer-events-none absolute -left-32 top-0 size-96 animate-float-slow rounded-full bg-brand-700/50 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-24 bottom-0 size-80 animate-float rounded-full bg-leaf-500/15 blur-3xl" aria-hidden="true"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8">
      <div data-reveal="zoom" class="relative mx-auto w-64 sm:w-80 lg:col-span-5 lg:w-full lg:max-w-md">
        <div class="absolute inset-[12%] rounded-full bg-leaf-300/30 blur-3xl" aria-hidden="true"></div>
        <img
          src="<?php echo esc_url(get_theme_file_uri('assets/images/cert-badge-800.webp')); ?>"
          srcset="<?php echo esc_url(get_theme_file_uri('assets/images/cert-badge-400.webp')); ?> 400w, <?php echo esc_url(get_theme_file_uri('assets/images/cert-badge-800.webp')); ?> 800w"
          sizes="(min-width: 1024px) 448px, (min-width: 640px) 320px, 256px"
          width="800" height="800" loading="lazy" decoding="async"
          alt="Dany Maid Verified Employees badge: background checked, safe and trusted"
          class="relative w-full animate-float drop-shadow-[0_25px_35px_rgba(0,0,0,0.35)]"
        >
      </div>

      <div class="lg:col-span-7">
        <?php get_template_part('template-parts/components/section-heading', null, array(
          'eyebrow' => 'Verified team',
          'title'   => 'Background-Checked Professionals You Can Trust.',
          'body'    => 'Letting someone into your home takes trust. That’s why the Dany Maid team members who clean your home have confirmed background checks and work for us as W2 employees, not independent contractors.',
          'dark'    => true,
          'id'      => 'verified-title',
        )); ?>

        <ul class="mt-8 grid gap-3 sm:grid-cols-2">
          <?php foreach (array(
            array('icon' => 'identification', 'text' => 'Confirmed background checks'),
            array('icon' => 'user-group', 'text' => 'W2 employees of Dany Maid'),
            array('icon' => 'shield-check', 'text' => 'An insured cleaning company'),
            array('icon' => 'calendar', 'text' => 'Trusted locally since 2013'),
          ) as $i => $point) : ?>
            <li data-reveal style="--reveal-delay: <?php echo 100 + $i * 90; ?>ms" class="flex items-center gap-3 rounded-2xl bg-white/[0.07] p-4 font-semibold text-white ring-1 ring-white/15">
              <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-leaf-500 text-brand-950"><?php echo dm_icon($point['icon'], 'size-5'); ?></span>
              <?php echo esc_html($point['text']); ?>
            </li>
          <?php endforeach; ?>
        </ul>

        <p data-reveal style="--reveal-delay: 450ms" class="mt-8 max-w-xl leading-relaxed text-brand-100">Reliable people, clear communication, and care for your home, so you can feel confident about who is walking through your door.</p>

        <div data-reveal style="--reveal-delay: 500ms" class="mt-8 flex flex-col gap-3 sm:flex-row">
          <?php dm_quote_cta('Get a Quote', 'why_verified', 'light'); ?>
          <?php dm_button('Read Customer Reviews', dm_page_url('reviews'), 'ghost'); ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Commitment (temporary safe copy from the brief until the guarantee policy is approved) -->
  <section class="bg-cream py-20 lg:py-24" aria-labelledby="commitment-title">
    <div data-reveal class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
      <span class="mx-auto flex size-16 animate-float items-center justify-center rounded-3xl bg-leaf-500 text-brand-950"><?php echo dm_icon('heart', 'size-8'); ?></span>
      <h2 id="commitment-title" class="mt-6 font-display text-3xl font-semibold text-balance text-brand-950 sm:text-4xl">If Something Needs Attention, We Want to Know.</h2>
      <p class="mt-5 text-lg leading-relaxed text-ink/75">If something about your cleaning needs attention, please contact our team so we can review your concern and discuss next steps.</p>
      <div class="mt-8">
        <?php dm_button('Contact Our Team', dm_page_url('contact'), 'secondary'); ?>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/home/reviews'); ?>
  <?php get_template_part('template-parts/home/team'); ?>
  <?php get_template_part('template-parts/components/cta-band'); ?>
</main>

<?php get_footer();
