<?php
/**
 * Template Name: Why Dany Maid
 *
 * Standards shown as proof, not adjectives (brief §08). Every claim is one the brief marks as verified;
 * the commitment block uses the brief's temporary safe copy until a guarantee is approved (§11).
 */

$standards = array(
  array('icon' => 'user-group', 'title' => 'Our Team', 'text' => 'Our cleaners are W2 employees of Dany Maid—not independent contractors—and the team members who come into your home are background-checked.'),
  array('icon' => 'shield-check', 'title' => 'Professional Care', 'text' => 'Dany Maid is an insured cleaning company. We approach every visit with respect for your home and your belongings.'),
  array('icon' => 'pencil', 'title' => 'Your Preferences Matter', 'text' => 'Before your service, we ask about your priorities, special instructions, and expectations so the visit fits your home.'),
  array('icon' => 'arrow-path', 'title' => 'Consistency', 'text' => 'For recurring clients, we work to keep your schedule and service consistent. We talk with you about team availability rather than promise the same cleaner at every visit.'),
);

get_header(); ?>

<main id="main">
  <?php get_template_part('template-parts/components/page-hero', null, array(
    'eyebrow'   => 'Why Dany Maid',
    'title'     => 'The Difference Is in the Details—and the People.',
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
