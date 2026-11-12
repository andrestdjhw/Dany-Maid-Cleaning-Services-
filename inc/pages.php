<?php
/**
 * Site pages: registry (slug → template + SEO), automatic creation, and the copy for each
 * service page. Copy follows the 828 brief; claims stay within what the brief marks as verified.
 *
 * Editors change a page's H1/intro here or in the Customizer later; the WordPress page editor
 * content is rendered as the editable "details" block of each template (e.g. a service's approved checklist).
 */

const DM_PAGES_VERSION = '3';

function dm_pages() {
  return array(
    'house-cleaning' => array(
      'title'       => 'House Cleaning Services',
      'template'    => 'page-templates/services-overview.php',
      'seo_title'   => 'House Cleaning Services in the Sacramento Area | Dany Maid',
      'description' => 'Explore recurring, deep, one-time, move-in/move-out, Airbnb and commercial cleaning from Dany Maid, a local team based in Citrus Heights. Request a personalized quote.',
    ),
    'recurring-house-cleaning' => array(
      'title'       => 'Recurring House Cleaning',
      'template'    => 'page-templates/service.php',
      'service'     => 'recurring',
      'parent'      => 'house-cleaning',
      'seo_title'   => 'Recurring House Cleaning | Dany Maid',
      'description' => 'Explore weekly, biweekly, and monthly house cleaning options from Dany Maid in the Sacramento area. Request a personalized quote.',
    ),
    'deep-cleaning' => array(
      'title'       => 'Deep Cleaning',
      'template'    => 'page-templates/service.php',
      'service'     => 'deep',
      'parent'      => 'house-cleaning',
      'seo_title'   => 'Deep Cleaning Services | Dany Maid',
      'description' => 'Planning a deeper home clean? Explore Dany Maid deep cleaning options and request a quote for your home.',
    ),
    'one-time-cleaning' => array(
      'title'       => 'One-Time Cleaning',
      'template'    => 'page-templates/service.php',
      'service'     => 'one-time',
      'parent'      => 'house-cleaning',
      'seo_title'   => 'One-Time House Cleaning | Dany Maid',
      'description' => 'Hosting, catching up, or getting ready for a special day? Request a one-time house cleaning quote from Dany Maid in the Sacramento area.',
    ),
    'move-in-move-out-cleaning' => array(
      'title'       => 'Move-In & Move-Out Cleaning',
      'template'    => 'page-templates/service.php',
      'service'     => 'move',
      'parent'      => 'house-cleaning',
      'seo_title'   => 'Move-In & Move-Out Cleaning | Dany Maid',
      'description' => 'Plan your next move with house cleaning support from Dany Maid. Share your home details and request a quote.',
    ),
    'airbnb-cleaning' => array(
      'title'       => 'Airbnb Cleaning',
      'template'    => 'page-templates/service.php',
      'service'     => 'airbnb',
      'parent'      => 'house-cleaning',
      'seo_title'   => 'Airbnb & Vacation Rental Cleaning | Dany Maid',
      'description' => 'Turnover cleaning between guests, built on your own checklist. Dany Maid serves hosts across the Sacramento area. Request a quote.',
    ),
    'commercial-cleaning' => array(
      'title'       => 'Commercial Cleaning',
      'template'    => 'page-templates/service.php',
      'service'     => 'commercial',
      'parent'      => 'house-cleaning',
      'seo_title'   => 'Commercial Cleaning for Offices & Stores | Dany Maid',
      'description' => 'Office, store and workspace cleaning with a scope and schedule tailored to your requirements. Request a commercial cleaning quote from Dany Maid.',
    ),
    'why-dany-maid' => array(
      'title'       => 'Why Dany Maid',
      'template'    => 'page-templates/why-dany-maid.php',
      'seo_title'   => 'Why Choose Dany Maid | A Local Team of Employees',
      'description' => 'W2 employees, background-checked team members, and an insured local company. See what makes Dany Maid different in the Sacramento area.',
    ),
    'about' => array(
      'title'       => 'About',
      'template'    => 'page-templates/about.php',
      'seo_title'   => 'About Dany Maid | Local House Cleaning Company',
      'description' => 'Our story began in 2013 and continued as Dany Maid in 2021. Meet the local cleaning team based in Citrus Heights, CA.',
    ),
    'reviews' => array(
      'title'       => 'Reviews',
      'template'    => 'page-templates/reviews.php',
      'seo_title'   => 'Customer Reviews | Dany Maid House Cleaning',
      'description' => 'Read what Sacramento-area homeowners say about Dany Maid on Google and Yelp.',
    ),
    'service-areas' => array(
      'title'       => 'Service Areas',
      'template'    => 'page-templates/service-areas.php',
      'seo_title'   => 'House Cleaning Service Areas | Dany Maid',
      'description' => 'Based in Citrus Heights, Dany Maid serves households across nearby Sacramento-area communities. Check your area and request a quote.',
    ),
    'contact' => array(
      'title'       => 'Contact',
      'template'    => 'page-templates/contact.php',
      'seo_title'   => 'Contact Dany Maid | Request a House Cleaning Quote',
      'description' => 'Tell us about your home and request a personalized house cleaning quote from Dany Maid, or call our Citrus Heights team.',
    ),
    'careers' => array(
      'title'       => 'Careers',
      'template'    => 'page-templates/careers.php',
      'seo_title'   => 'Careers at Dany Maid | House Cleaning Jobs in Citrus Heights',
      'description' => 'Join the Dany Maid cleaning team in the Sacramento area. W2 positions with a local company. Apply online in English or Spanish.',
    ),
  );
}

// Creates any missing page (published, with its template) once per DM_PAGES_VERSION.
function dm_ensure_pages() {
  if (get_option('dm_pages_version') === DM_PAGES_VERSION) {
    return;
  }
  foreach (dm_pages() as $slug => $page) {
    $existing = get_page_by_path($slug);
    if ($existing) {
      if (!get_post_meta($existing->ID, '_wp_page_template', true)) {
        update_post_meta($existing->ID, '_wp_page_template', $page['template']);
      }
      continue;
    }
    wp_insert_post(array(
      'post_type'    => 'page',
      'post_status'  => 'publish',
      'post_name'    => $slug,
      'post_title'   => $page['title'],
      'post_content' => '',
      'meta_input'   => array('_wp_page_template' => $page['template']),
    ));
  }
  update_option('dm_pages_version', DM_PAGES_VERSION);
}

add_action('init', 'dm_ensure_pages');

// Registry entry for the page being viewed, or null.
function dm_current_page() {
  if (!is_page()) {
    return null;
  }
  $slug  = get_post_field('post_name', get_queried_object_id());
  $pages = dm_pages();
  return isset($pages[$slug]) ? $pages[$slug] + array('slug' => $slug) : null;
}

function dm_page_url($slug) {
  return home_url('/' . $slug . '/');
}

// Home → (parent) → current page, used by the page hero and BreadcrumbList schema.
function dm_breadcrumbs() {
  $crumbs = array(array('label' => 'Home', 'url' => home_url('/')));
  $page   = dm_current_page();
  if ($page && !empty($page['parent'])) {
    $parent   = dm_pages()[$page['parent']];
    $crumbs[] = array('label' => $parent['title'], 'url' => dm_page_url($page['parent']));
  }
  $crumbs[] = array('label' => get_the_title(get_queried_object_id()), 'url' => get_permalink(get_queried_object_id()));
  return $crumbs;
}

// What affects a quote; generic factors only, no prices (brief §10).
function dm_pricing_factors() {
  return array(
    array('icon' => 'home', 'title' => 'Your home', 'text' => 'Size, number of bedrooms and bathrooms, and layout.'),
    array('icon' => 'sparkles', 'title' => 'Its condition', 'text' => 'How long since the last professional cleaning and any areas that need extra attention.'),
    array('icon' => 'calendar', 'title' => 'The service', 'text' => 'The type of cleaning and, for recurring visits, how often you’d like us to come.'),
    array('icon' => 'pencil', 'title' => 'Your priorities', 'text' => 'Special requests or extra tasks you’d like included.'),
  );
}

/**
 * Copy for each service page (brief §07). The room-by-room checklists live in inc/scope.php
 * (client services sheet); highlights and FAQs below must stay consistent with them.
 */
function dm_service_page($key) {
  $pages = array(
    'recurring' => array(
      'eyebrow'    => 'Recurring house cleaning',
      'h1'         => 'A Cleaning Routine That Works for Your Life.',
      'intro'      => 'Keep your home feeling cared for with weekly, biweekly, or monthly visits tailored to your household.',
      'cta'        => 'Request a Recurring Cleaning Quote',
      'why_title'  => 'A cleaner home, without starting over every time.',
      'why_body'   => 'With regular visits, your home doesn’t have to wait for a big clean. Professional cleaning on a schedule keeps everyday spaces like kitchens, bathrooms, and living areas consistently cared for, so you can spend your time on what matters to you.',
      'highlights' => array('Weekly, biweekly, or monthly visits', 'Dusting, surfaces, floors, kitchen and bathrooms', 'A final review of details at every visit'),
      'faq'        => array(
        array('question' => 'Which recurring frequencies do you offer?', 'answer' => 'You can choose weekly, biweekly, or monthly visits. We’ll help you pick the frequency that fits your household when we prepare your quote.'),
        array('question' => 'Will the same cleaner come to every visit?', 'answer' => 'We talk with you about scheduling and continuity when we set up your service. We can’t promise the same team member at every visit.'),
        array('question' => 'How do I get started?', 'answer' => 'Request a quote with a few details about your home. Our team reviews your request and follows up to confirm the scope, schedule, and next steps.'),
      ),
    ),
    'deep' => array(
      'eyebrow'    => 'Deep cleaning',
      'h1'         => 'A More Detailed Clean When Your Home Needs a Reset.',
      'intro'      => 'For the moments when a regular cleaning is not enough, talk with our team about a more thorough visit and a clear plan for your home.',
      'cta'        => 'Get a Deep Cleaning Quote',
      'why_title'  => 'When a deep cleaning makes sense.',
      'why_body'   => 'A deep cleaning is a more detailed visit for homes that need extra attention, for example before starting a recurring schedule, after a busy season, or when you simply want a fresh start. We agree on a clear plan with you before the visit.',
      'highlights' => array('Everything in a recurring visit, plus baseboards and doors', 'Light fixtures, ceiling fans and cobwebs', 'Stove and microwave cleaned in depth'),
      'faq'        => array(
        array('question' => 'When is a deep cleaning a good idea?', 'answer' => 'When your home needs more attention than a regular visit, such as before starting recurring service, after a busy stretch, or when you want a reset. Our team can help you decide.'),
        array('question' => 'Is a deep cleaning the same as restoration?', 'answer' => 'No. A deep cleaning is a more detailed house cleaning. It does not include restoration work such as water, fire, or mold damage remediation.'),
        array('question' => 'What exactly is included?', 'answer' => 'Everything in a recurring visit, plus baseboards and doors, light fixtures and switches, ceiling fans, cobwebs, and the stove and microwave cleaned in depth. See the full room-by-room checklist on this page. The oven, refrigerator, cabinet interiors and interior windows are part of move-in / move-out cleaning.'),
      ),
    ),
    'one-time' => array(
      'eyebrow'    => 'One-time cleaning',
      'h1'         => 'Professional Cleaning for When You Need It.',
      'intro'      => 'Hosting, catching up, or checking a task off your list? Let’s find a cleaning plan for the occasion.',
      'cta'        => 'Request a One-Time Quote',
      'why_title'  => 'Cleaning for the occasion.',
      'why_body'   => 'Hosting family, catching up after a busy stretch, or getting ready for a special day? A one-time cleaning gives your home professional attention without committing to a schedule.',
      'highlights' => array('No recurring commitment', 'Planned around your date', 'Focused on your priorities'),
      'faq'        => array(
        array('question' => 'How is a one-time cleaning different from a deep cleaning?', 'answer' => 'A one-time cleaning focuses on getting your home ready for an occasion or a quick catch-up. If your home needs a more detailed reset, a deep cleaning may be a better fit, and our team can help you decide.'),
        array('question' => 'Can I talk about recurring visits later?', 'answer' => 'Of course. Let us know whenever you’d like to discuss a recurring schedule and we’ll help you find the right frequency.'),
        array('question' => 'How do I request a date?', 'answer' => 'Share your preferred date when you request a quote. It’s a preference, not a confirmed booking. Our team follows up to confirm availability.'),
      ),
    ),
    'move' => array(
      'eyebrow'    => 'Move-in & move-out cleaning',
      'h1'         => 'A Fresh Start for Your Next Chapter.',
      'intro'      => 'Whether you’re moving into a home or preparing to leave one, we can help you plan cleaning around your next step.',
      'cta'        => 'Plan Your Move Cleaning',
      'why_title'  => 'Cleaning planned around your move.',
      'why_body'   => 'Moving comes with enough to coordinate. Our move-in / move-out cleaning is built for empty homes, before handover or move-in. Tell us your handover date and the size of the home, and we’ll help you plan the cleaning around your next step.',
      'highlights' => array('Everything in a deep cleaning', 'Oven, refrigerator and inside of cabinets', 'Interior windows cleaned in every room'),
      'faq'        => array(
        array('question' => 'What does it add to a deep cleaning?', 'answer' => 'Interior windows in every room, a full oven and refrigerator cleaning, kitchen cabinets cleaned inside and out, trim added to baseboards and doors, and trash removed from every room.'),
        array('question' => 'What should I share when I request a quote?', 'answer' => 'Let us know your move or handover date, the size of the home, and any priority areas. This service is built for empty homes.'),
        array('question' => 'Do you guarantee I’ll get my deposit back?', 'answer' => 'No. Deposit decisions are made by your landlord or property manager. We focus on delivering the cleaning plan we agree on with you.'),
        array('question' => 'Can you clean before I move in?', 'answer' => 'Yes. Tell us your move-in date and our team will follow up to plan the cleaning around it.'),
      ),
    ),
    'airbnb' => array(
      'eyebrow'    => 'Airbnb cleaning',
      'h1'         => 'Turnover Cleaning Built on Your Checklist.',
      'intro'      => 'Get your rental ready between guests. Share your checklist and we clean to it on every turnover.',
      'cta'        => 'Request an Airbnb Cleaning Quote',
      'why_title'  => 'Your standards, every turnover.',
      'why_body'   => 'Every rental is set up differently, and you already know what your guests expect. Instead of a generic routine, we work from your own checklist on each turnover between guests and finish with a final review of details before the next check-in.',
      'highlights' => array('Built on the host’s own checklist', 'Cleaned on every turnover between guests', 'Final review before the next check-in'),
      'faq'        => array(
        array('question' => 'What do you clean on a turnover?', 'answer' => 'We clean to your checklist. You share the list you use for your rental, and our team follows it on every turnover between guests.'),
        array('question' => 'How do I get started?', 'answer' => 'Request a quote and tell us about your rental, your checklist and your usual checkout and check-in times. Our team follows up to confirm the details.'),
        array('question' => 'Do you serve my rental’s area?', 'answer' => 'We are based in Citrus Heights and serve nearby Sacramento-area communities. Share the ZIP code when you request a quote and we’ll confirm coverage.'),
      ),
    ),
    'commercial' => array(
      'eyebrow'    => 'Commercial cleaning',
      'h1'         => 'Cleaning Planned Around Your Business.',
      'intro'      => 'Offices, stores and workspaces, with a cleaning scope and schedule tailored to your requirements.',
      'cta'        => 'Request a Commercial Quote',
      'why_title'  => 'A plan made for your space.',
      'why_body'   => 'No two workspaces are the same. We review your space and its requirements, define a tailored scope and schedule with you, and deliver the cleaning to the plan we agree on.',
      'highlights' => array('Offices, stores and workspaces', 'A tailored scope and schedule', 'Cleaning delivered to the agreed plan'),
      'faq'        => array(
        array('question' => 'What types of spaces do you clean?', 'answer' => 'Offices, stores and other workspaces. Tell us about your space when you request a quote and we’ll review its requirements with you.'),
        array('question' => 'What is included in a commercial cleaning?', 'answer' => 'It depends on your space. We review your requirements first, then define a tailored scope and schedule, and deliver the cleaning to that plan.'),
        array('question' => 'How do I get started?', 'answer' => 'Request a quote with a few details about your business and space. Our team follows up to review your requirements and next steps.'),
      ),
    ),
  );
  return isset($pages[$key]) ? $pages[$key] : null;
}
