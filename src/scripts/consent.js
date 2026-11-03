// Cookie consent storage + Google Consent Mode v2 updates.
// Defaults ("denied") are set in <head> by dm_consent_defaults() in functions.php, before any tag loads.

const STORAGE_KEY = "dm_consent"
const VERSION = 1
const MAX_AGE_DAYS = 180

// Any component can open the settings modal with: window.dispatchEvent(new Event(OPEN_COOKIE_SETTINGS))
export const OPEN_COOKIE_SETTINGS = "dm:open-cookie-settings"
// Fired on window after every saved choice (detail = the consent object), e.g. to load embeds.
export const CONSENT_UPDATED = "dm:consent-updated"

export function readConsent() {
  try {
    const stored = JSON.parse(localStorage.getItem(STORAGE_KEY))
    const fresh = stored && stored.v === VERSION && Date.now() - stored.ts < MAX_AGE_DAYS * 864e5
    return fresh ? stored : null
  } catch (err) {
    return null
  }
}

export function saveConsent({ analytics, marketing }) {
  const consent = { v: VERSION, ts: Date.now(), necessary: true, analytics: !!analytics, marketing: !!marketing }
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(consent))
  } catch (err) {}

  const state = value => (value ? "granted" : "denied")
  window.gtag?.("consent", "update", {
    analytics_storage: state(consent.analytics),
    ad_storage: state(consent.marketing),
    ad_user_data: state(consent.marketing),
    ad_personalization: state(consent.marketing)
  })
  window.dataLayer = window.dataLayer || []
  window.dataLayer.push({ event: "consent_update", consent_analytics: consent.analytics, consent_marketing: consent.marketing })
  window.dispatchEvent(new CustomEvent(CONSENT_UPDATED, { detail: consent }))
  return consent
}
