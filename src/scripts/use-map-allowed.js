import { useEffect, useState } from "react"
import { readConsent, CONSENT_UPDATED } from "./consent"

// Google Maps embeds set third-party cookies, so they only load automatically after "Accept all"
// (or a saved choice that allows marketing); otherwise the visitor loads them with one click.
export function useMapAllowed() {
  const [allowed, setAllowed] = useState(() => !!readConsent()?.marketing)
  useEffect(() => {
    const onConsent = e => e.detail?.marketing && setAllowed(true)
    window.addEventListener(CONSENT_UPDATED, onConsent)
    return () => window.removeEventListener(CONSENT_UPDATED, onConsent)
  }, [])
  return [allowed, () => setAllowed(true)]
}
