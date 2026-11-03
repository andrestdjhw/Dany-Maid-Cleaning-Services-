// GA4 / GTM event helpers. Never pass personal data (name, email, phone, address, free text).

export function track(event, params = {}) {
  window.dataLayer = window.dataLayer || []
  window.dataLayer.push({ event, page_path: window.location.pathname, ...params })
}

// Any element with data-track="event_name" fires that event on click; other data-* become params.
// tel: links fire click_to_call automatically.
export function initClickTracking() {
  document.addEventListener("click", e => {
    const el = e.target.closest("[data-track], a[href^='tel:']")
    if (!el) return

    if (el.dataset.track) {
      const { track: event, ...params } = el.dataset
      track(event, params)
    } else {
      track("click_to_call", { location: el.dataset.location || "page" })
    }
  })
}

// Keeps UTM params for the session so the quote form can send them to the CRM.
export function captureUtm() {
  const params = new URLSearchParams(window.location.search)
  const utm = {}
  for (const [key, value] of params) {
    if (key.startsWith("utm_")) utm[key] = value
  }
  if (!Object.keys(utm).length) return
  try {
    sessionStorage.setItem("dm_utm", JSON.stringify({ ...utm, referrer: document.referrer }))
  } catch (err) {}
}
