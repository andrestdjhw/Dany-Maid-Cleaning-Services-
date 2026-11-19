<?php
/**
 * Privacy Policy and Terms & Conditions content (page-templates/legal.php).
 *
 * Written from what the site actually does (Nov 2026): quote + careers forms saved in WordPress and
 * emailed through EmailJS, Google reCAPTCHA v3 on both forms, Google Maps embeds, Google Fonts, the
 * Trustindex reviews widget, the cookie banner (Consent Mode v2, analytics/marketing off by default)
 * and three browser-storage keys. Update this file whenever a tool is added or removed
 * (e.g. when GA4 / Google Ads tags go live in GTM) and change DM_LEGAL_UPDATED.
 * DRAFT: have it reviewed by the client's legal counsel before launch.
 */

const DM_LEGAL_UPDATED = 'November 17, 2026';

// External link helper for the policy text.
function dm_legal_link($url, $label) {
  return sprintf('<a href="%s" target="_blank" rel="noopener">%s<span class="sr-only"> (opens in a new tab)</span></a>', esc_url($url), esc_html($label));
}

function dm_legal_contact_html() {
  $b = dm_business();
  return sprintf(
    '<p><strong>%s</strong><br>%s<br>%s, %s %s<br>Phone: <a href="%s">%s</a>%s</p>',
    esc_html($b['legalName']),
    esc_html($b['street']),
    esc_html($b['city']), esc_html($b['region']), esc_html($b['zip']),
    esc_url($b['phoneHref']), esc_html($b['phone']),
    $b['email'] ? '<br>Email: <a href="mailto:' . esc_attr($b['email']) . '">' . esc_html($b['email']) . '</a>' : ''
  );
}

// Cookies and browser storage used by the site, shown as a table in the Privacy Policy.
function dm_legal_cookie_rows() {
  return array(
    array('dm_consent', 'Dany Maid', 'Browser storage (localStorage)', 'Remembers your cookie choices so the banner does not appear on every page.', '180 days', 'Necessary'),
    array('dm_utm', 'Dany Maid', 'Browser storage (sessionStorage)', 'Keeps the campaign that brought you to the site (for example a Google ad) so it can be attached to your quote request.', 'Until you close the tab', 'Necessary'),
    array('dm_careers_lang', 'Dany Maid', 'Browser storage (localStorage)', 'Remembers whether you chose English or Spanish on the job application form.', 'Until you clear it', 'Necessary'),
    array('_GRECAPTCHA', 'Google reCAPTCHA', 'Cookie', 'Set when you start filling out a form, to tell people from automated spam.', 'Up to 6 months', 'Necessary'),
    array('NID and other Google cookies', 'Google Maps', 'Cookie', 'May be set by the embedded maps on our pages.', 'Set by Google', 'Third party'),
    array('_ga, _ga_*', 'Google Analytics', 'Cookie', 'Measure how the site is used. Only if you allow Analytics in Cookie Settings.', 'Up to 2 years', 'Analytics'),
    array('_gcl_au and similar', 'Google Ads', 'Cookie', 'Measure the results of our ads. Only if you allow Marketing in Cookie Settings.', 'Up to 90 days', 'Marketing'),
  );
}

function dm_legal_content($slug) {
  $b       = dm_business();
  $privacy = dm_page_url('privacy-policy');
  $terms   = dm_page_url('terms-and-conditions');
  $email   = $b['email'] ? '<a href="mailto:' . esc_attr($b['email']) . '">' . esc_html($b['email']) . '</a>' : 'our email';
  $phone   = '<a href="' . esc_url($b['phoneHref']) . '">' . esc_html($b['phone']) . '</a>';

  if ($slug === 'privacy-policy') {
    $rows = '';
    foreach (dm_legal_cookie_rows() as $r) {
      $rows .= '<tr><td><code>' . esc_html($r[0]) . '</code></td><td>' . esc_html($r[1]) . '</td><td>' . esc_html($r[3]) . '</td><td>' . esc_html($r[4]) . '</td><td>' . esc_html($r[5]) . '</td></tr>';
    }

    return array(
      'intro'    => sprintf('This Privacy Policy explains what information %s ("Dany Maid", "we", "us") collects through this website, how we use it, which service providers help us, and the choices you have.', esc_html($b['legalName'])),
      'sections' => array(
        array('who-we-are', 'Who we are', '<p>Dany Maid is a house cleaning company based in Citrus Heights, California. You can reach us at:</p>' . dm_legal_contact_html()),

        array('information-we-collect', 'Information we collect', '
          <h3>Information you give us</h3>
          <ul>
            <li><strong>Quote and contact requests:</strong> your name, email, phone number, ZIP code, the service you are interested in, how you prefer to be contacted, whether you agree to receive text messages, and anything you write about your home.</li>
            <li><strong>Job applications:</strong> your name, phone number, email (optional), city, the position and schedule you are interested in, the days you can work, your cleaning experience, whether you have reliable transportation, whether you are authorized to work in the United States, the languages you speak, whether you are comfortable working in homes with pets, how you heard about us, and anything you add about yourself. We do not ask about criminal history on this form.</li>
            <li><strong>When you call, text or email us:</strong> the information you choose to share.</li>
          </ul>
          <h3>Information collected automatically</h3>
          <ul>
            <li><strong>Technical information</strong> such as your IP address, browser and device type, which our hosting provider records in standard server logs and which Google reCAPTCHA uses to detect spam (see below).</li>
            <li><strong>Campaign information:</strong> if you arrive from an ad or a link with tracking parameters (for example <code>utm_source</code>), we keep it during your visit and attach it to your quote request, together with the page you sent it from.</li>
            <li><strong>Usage information</strong> through Google Analytics, only if you allow Analytics cookies. We do not send names, emails, phone numbers or what you type in forms to analytics.</li>
          </ul>'),

        array('how-we-use', 'How we use your information', '
          <ul>
            <li>To respond to your request, prepare your quote and schedule and provide your cleaning service.</li>
            <li>To contact you by phone, email or text message, as you choose.</li>
            <li>To review job applications and contact applicants.</li>
            <li>To protect our forms from spam and abuse.</li>
            <li>To understand how the website is used and improve it, if you allow Analytics cookies.</li>
            <li>To measure our advertising, if you allow Marketing cookies.</li>
            <li>To comply with the law and protect our rights.</li>
          </ul>
          <p>We do not sell your personal information.</p>'),

        array('text-messages', 'Text messages (SMS)', '
          <p>We only send text messages if you agree to receive them in our form or ask us to text you. Messages are about your request or service. Message frequency varies. Message and data rates may apply. Reply <strong>STOP</strong> to opt out at any time, or <strong>HELP</strong> for help. Agreeing to receive texts is not a condition of any purchase.</p>
          <p>We do not sell or share your mobile number or your text-message consent with third parties for their own marketing purposes.</p>'),

        array('emailjs', 'How your form is delivered (EmailJS)', '
          <p>When you send our quote form or job application, your answers are saved in our website and then delivered to our team by email through ' . dm_legal_link('https://www.emailjs.com/', 'EmailJS') . ', an email delivery service. To do that, the information you entered in the form is sent from your browser to EmailJS, which passes it on to our inbox. EmailJS acts as our service provider and states that its servers are located in the United States.</p>
          <p>If EmailJS is not available, our website sends the same email itself, so your request is not lost.</p>
          <ul>
            <li>' . dm_legal_link('https://www.emailjs.com/legal/privacy-policy/', 'EmailJS Privacy Policy') . '</li>
            <li>' . dm_legal_link('https://www.emailjs.com/legal/terms-of-service/', 'EmailJS Terms of Service') . '</li>
            <li>' . dm_legal_link('https://www.emailjs.com/docs/', 'EmailJS documentation') . '</li>
          </ul>'),

        array('recaptcha', 'Spam protection (Google reCAPTCHA v3)', '
          <p>Our quote and job application forms are protected by ' . dm_legal_link('https://www.google.com/recaptcha/about/', 'Google reCAPTCHA v3') . ', a service from Google LLC that helps tell real people from automated spam. It works in the background without a puzzle to solve. It loads only when you start filling out a form.</p>
          <p>To do this, reCAPTCHA collects information such as your IP address, browser and device details, and how you interact with the page, and sends it to Google for analysis. Google may set the <code>_GRECAPTCHA</code> cookie. Our website receives a score from Google and uses it only to decide whether to accept the form. Use of reCAPTCHA is subject to Google’s Privacy Policy and Terms of Service.</p>
          <ul>
            <li>' . dm_legal_link('https://policies.google.com/privacy', 'Google Privacy Policy') . '</li>
            <li>' . dm_legal_link('https://policies.google.com/terms', 'Google Terms of Service') . '</li>
            <li>' . dm_legal_link('https://developers.google.com/recaptcha/docs/v3', 'reCAPTCHA v3 documentation') . '</li>
          </ul>'),

        array('other-services', 'Other services on our website', '
          <ul>
            <li><strong>Google Maps:</strong> our contact and service area sections show embedded Google maps. When they load, Google receives your IP address and may set cookies. ' . dm_legal_link('https://www.google.com/intl/en_us/help/terms_maps/', 'Google Maps Terms') . '.</li>
            <li><strong>Google Fonts:</strong> the fonts on our website are loaded from Google’s servers, which receive your IP address.</li>
            <li><strong>Reviews widget (Trustindex):</strong> our customer reviews are shown with a widget from Trustindex, which loads content from its own servers. ' . dm_legal_link('https://www.trustindex.io/privacy-policy/', 'Trustindex Privacy Policy') . '.</li>
            <li><strong>Google Analytics and Google Ads:</strong> only if you allow Analytics or Marketing cookies (see below).</li>
            <li><strong>Links to other sites</strong> such as Google, Yelp, Facebook, Instagram and BBB are governed by those sites’ own policies.</li>
          </ul>'),

        array('cookies', 'Cookies and browser storage', '
          <p>Cookies and browser storage are small pieces of data saved on your device. We use them as follows:</p>
          <ul>
            <li><strong>Necessary:</strong> needed for the website and its forms to work, such as remembering your cookie choices and protecting our forms from spam. They are always on.</li>
            <li><strong>Analytics:</strong> help us understand how visitors use the website. Off unless you turn them on.</li>
            <li><strong>Marketing:</strong> help us measure our advertising. Off unless you turn them on.</li>
          </ul>
          <p>Analytics and marketing tags stay off until you choose otherwise (we use Google Consent Mode with everything set to "denied" by default). You can change your choice at any time with the <strong>Cookie Settings</strong> link at the bottom of every page. Your choice is remembered for 180 days.</p>
          <div class="not-prose overflow-x-auto"><table class="dm-legal-table"><thead><tr><th>Name</th><th>Provider</th><th>Purpose</th><th>Duration</th><th>Type</th></tr></thead><tbody>' . $rows . '</tbody></table></div>
          <p>You can also block or delete cookies in your browser settings; some parts of the website, such as the forms, may then not work. More about how Google uses cookies: ' . dm_legal_link('https://policies.google.com/technologies/cookies', 'Google cookie information') . '. You can opt out of Google Analytics on all websites with the ' . dm_legal_link('https://tools.google.com/dlpage/gaoptout', 'Google Analytics opt-out add-on') . '.</p>
          <p><strong>Do Not Track:</strong> our website does not respond to browser "Do Not Track" signals. Instead, analytics and marketing cookies are off unless you allow them in Cookie Settings.</p>'),

        array('sharing', 'Who we share information with', '
          <ul>
            <li><strong>Service providers</strong> that help us run the website and our business, such as our website host, EmailJS (form delivery), Google (reCAPTCHA, Maps, Fonts and, with your consent, Analytics and Ads) and Trustindex (reviews). They may use your information only to provide their services to us or as described in their own policies.</li>
            <li><strong>When required by law</strong> or to protect our rights, our customers or our team.</li>
            <li><strong>If our business changes ownership</strong>, as part of that transaction.</li>
          </ul>'),

        array('retention', 'How long we keep information', '<p>We keep quote requests, customer records and job applications for as long as we need them for the purposes in this policy, including our legal, tax and employment record obligations, and then delete them. Cookie lifetimes are listed in the table above.</p>'),

        array('security', 'Security', '<p>We use reasonable measures to protect your information, including encrypted connections (HTTPS), access-restricted accounts and spam protection on our forms. No website or email service can be guaranteed to be completely secure.</p>'),

        array('your-choices', 'Your choices and rights', '
          <ul>
            <li>You can ask us to review, correct or delete the personal information you sent us by contacting us at ' . $email . ' or ' . $phone . '.</li>
            <li>You can stop text messages at any time by replying STOP.</li>
            <li>You can change your cookie choices at any time with Cookie Settings.</li>
          </ul>
          <p>Depending on where you live, you may have additional privacy rights under applicable law. California residents may ask us about the disclosure of personal information to third parties for their direct marketing purposes; we do not share personal information for that purpose.</p>'),

        array('children', 'Children', '<p>Our website is not directed to children under 13, and we do not knowingly collect their personal information. If you believe a child has sent us information, please contact us and we will delete it.</p>'),

        array('changes', 'Changes to this policy', '<p>We may update this Privacy Policy from time to time. The date at the top of this page shows when it was last updated.</p>'),

        array('contact', 'Contact us', '<p>Questions about this Privacy Policy or your information? Contact us:</p>' . dm_legal_contact_html() . '<p>See also our <a href="' . esc_url($terms) . '">Terms &amp; Conditions</a>.</p>'),
      ),
    );
  }

  if ($slug === 'terms-and-conditions') {
    return array(
      'intro'    => sprintf('These Terms &amp; Conditions apply to your use of this website, operated by %s ("Dany Maid", "we", "us"). By using the website, you agree to them.', esc_html($b['legalName'])),
      'sections' => array(
        array('website', 'Using our website', '<p>You may use this website to learn about our services, request a quote, contact us and apply for a job. Please do not misuse the website, for example by sending spam or automated submissions, trying to access areas you are not authorized to, or interfering with how it works.</p>'),

        array('quotes', 'Quote requests and bookings', '
          <ul>
            <li>Sending a quote request does not book an appointment. Our team reviews your request and follows up to confirm the details.</li>
            <li>Prices are not published on the website. Your price depends on your home, its condition and the service you choose, and is confirmed with you before your service.</li>
            <li>The checklists on our service pages describe what each service usually includes. The exact scope for your home, including any add-ons or exclusions, is confirmed with you before your service.</li>
            <li>Scheduling, cancellation and payment terms for your service are confirmed with you directly.</li>
          </ul>'),

        array('information', 'Information you send us', '<p>Please make sure the information you send through our forms is accurate and that you are allowed to share it. We handle it as described in our <a href="' . esc_url($privacy) . '">Privacy Policy</a>.</p>'),

        array('text-messages', 'Text messages', '<p>If you agree to receive text messages, we may text you about your request or service. Message frequency varies. Message and data rates may apply. Reply STOP to opt out or HELP for help. Agreeing to receive texts is not a condition of any purchase.</p>'),

        array('careers', 'Job applications', '<p>Submitting a job application through our website does not create an offer or a promise of employment. We review applications and contact the applicants whose profile fits our open positions.</p>'),

        array('third-party', 'Third-party services', '
          <p>Our website uses services from other companies, which have their own terms:</p>
          <ul>
            <li><strong>EmailJS</strong> delivers our form submissions by email. ' . dm_legal_link('https://www.emailjs.com/legal/terms-of-service/', 'EmailJS Terms of Service') . ' and ' . dm_legal_link('https://www.emailjs.com/legal/privacy-policy/', 'Privacy Policy') . '.</li>
            <li><strong>Google reCAPTCHA v3</strong> protects our forms from spam. This site is protected by reCAPTCHA and the Google ' . dm_legal_link('https://policies.google.com/privacy', 'Privacy Policy') . ' and ' . dm_legal_link('https://policies.google.com/terms', 'Terms of Service') . ' apply. ' . dm_legal_link('https://developers.google.com/recaptcha/docs/v3', 'reCAPTCHA v3 documentation') . '.</li>
            <li><strong>Google Maps</strong> shows our location and service areas. ' . dm_legal_link('https://www.google.com/intl/en_us/help/terms_maps/', 'Google Maps Terms') . '.</li>
            <li><strong>Trustindex</strong> displays our customer reviews. ' . dm_legal_link('https://www.trustindex.io/privacy-policy/', 'Trustindex Privacy Policy') . '.</li>
          </ul>
          <p>We are not responsible for the content or practices of third-party websites we link to.</p>'),

        array('cookies', 'Cookies', '<p>Our use of cookies and browser storage is explained in the Cookies section of our <a href="' . esc_url($privacy) . '#cookies">Privacy Policy</a>. You can change your choices at any time with the Cookie Settings link at the bottom of every page.</p>'),

        array('content', 'Website content', '<p>The text, photos, videos, logos and design of this website belong to Dany Maid or are used with permission. You may not copy or reuse them for commercial purposes without our written permission. We work to keep the information on the website accurate and up to date, but it is provided for general information and may change without notice.</p>'),

        array('liability', 'Disclaimer and limitation of liability', '<p>The website is provided "as is" and "as available". To the fullest extent allowed by law, Dany Maid is not liable for indirect or consequential damages arising from your use of the website, or for interruptions, errors or the availability of third-party services. Nothing in these terms limits rights you have that cannot be limited by law.</p>'),

        array('law', 'Governing law', '<p>These Terms are governed by the laws of the State of California, without regard to its conflict of law rules.</p>'),

        array('changes', 'Changes to these terms', '<p>We may update these Terms &amp; Conditions from time to time. The date at the top of this page shows when they were last updated.</p>'),

        array('contact', 'Contact us', '<p>Questions about these terms? Contact us:</p>' . dm_legal_contact_html()),
      ),
    );
  }

  return null;
}
