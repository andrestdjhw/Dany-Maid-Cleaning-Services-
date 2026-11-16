import emailjs from "@emailjs/browser"

/*
 * Form email delivery (EmailJS) and spam protection (Google reCAPTCHA v3).
 * Settings come from window.danyMaid.mail (Customizer → Dany Maid → Email & reCAPTCHA, see inc/mail.php).
 *
 * Flow for both forms: get a reCAPTCHA token → POST to WordPress (validates, checks the token with the
 * secret key, saves the Lead / Application) → send the notification through EmailJS. If EmailJS fails,
 * WordPress is asked to send the same notification with wp_mail instead, so nothing is lost.
 *
 * reCAPTCHA loads only when someone starts filling a form, not on every page view.
 */

let recaptchaPromise = null

// Submission time for the email ("time" template variable), in the business's time zone.
export function submittedAt() {
  try {
    return new Date().toLocaleString("en-US", { timeZone: "America/Los_Angeles", dateStyle: "medium", timeStyle: "short" }) + " (Pacific)"
  } catch (err) {
    return new Date().toString()
  }
}

export function loadRecaptcha(siteKey) {
  if (!siteKey) return Promise.resolve(null)
  if (recaptchaPromise) return recaptchaPromise
  recaptchaPromise = new Promise(resolve => {
    if (window.grecaptcha?.execute) return resolve(window.grecaptcha)
    const script = document.createElement("script")
    script.src = `https://www.google.com/recaptcha/api.js?render=${encodeURIComponent(siteKey)}`
    script.async = true
    script.onload = () => window.grecaptcha.ready(() => resolve(window.grecaptcha))
    script.onerror = () => resolve(null)
    document.head.appendChild(script)
  })
  return recaptchaPromise
}

// Returns a token, or "" if reCAPTCHA can't load (the server then decides; see dm_verify_recaptcha()).
export async function getRecaptchaToken(siteKey, action) {
  try {
    const grecaptcha = await Promise.race([loadRecaptcha(siteKey), new Promise(r => setTimeout(() => r(null), 8000))])
    return grecaptcha ? await grecaptcha.execute(siteKey, { action }) : ""
  } catch (err) {
    return ""
  }
}

// Sends one EmailJS template. Resolves true/false, never throws.
export async function sendEmail(mail, templateId, params) {
  if (!mail?.serviceId || !mail?.publicKey || !templateId) return false
  try {
    const result = await emailjs.send(mail.serviceId, templateId, params, { publicKey: mail.publicKey, blockHeadless: true })
    return result.status === 200
  } catch (err) {
    return false
  }
}

// Asks WordPress to email the saved request itself when EmailJS couldn't (once per request).
export function requestMailFallback(mail, reference) {
  if (!mail?.fallbackEndpoint || !reference) return
  fetch(mail.fallbackEndpoint, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ reference }),
    keepalive: true
  }).catch(() => {})
}

// Delivers a saved request: EmailJS first, wp_mail fallback. Returns "emailjs" | "fallback".
export async function deliver(mail, templateId, params, reference) {
  const sent = await sendEmail(mail, templateId, params)
  if (!sent) requestMailFallback(mail, reference)
  return sent ? "emailjs" : "fallback"
}
