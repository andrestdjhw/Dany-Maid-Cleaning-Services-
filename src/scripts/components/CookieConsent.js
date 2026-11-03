import React, { useEffect, useRef, useState } from "react"
import Icon from "./Icon"
import { readConsent, saveConsent, OPEN_COOKIE_SETTINGS } from "../consent"

const focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700"
const primaryBtn = `rounded-full bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800 ${focusRing}`
const secondaryBtn = `rounded-full border-2 border-brand-700 px-5 py-2.5 text-sm font-bold text-brand-800 transition hover:bg-brand-50 ${focusRing}`

const CATEGORIES = [
  { key: "necessary", title: "Necessary", text: "Required for the site to work, such as security and remembering your cookie choices. These can’t be turned off.", locked: true },
  { key: "analytics", title: "Analytics", text: "Help us understand how visitors use the site (pages visited, buttons clicked) so we can improve it. No names, emails, or phone numbers are collected." },
  { key: "marketing", title: "Marketing", text: "Help us measure the performance of our advertising and show more relevant ads on other sites." }
]

function CookieIcon({ className }) {
  return (
    <svg className={className} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth={1.5} strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
      <path d="M21 12.3A9 9 0 1 1 11.7 3a3 3 0 0 0 3.8 3.8 3 3 0 0 0 3.7 3.7A3 3 0 0 0 21 12.3Z" />
      <circle cx="8.5" cy="10.5" r=".75" fill="currentColor" />
      <circle cx="12.5" cy="15" r=".75" fill="currentColor" />
      <circle cx="8" cy="15.5" r=".75" fill="currentColor" />
      <circle cx="16" cy="15" r=".75" fill="currentColor" />
    </svg>
  )
}

function Switch({ checked, onChange, label, locked }) {
  return (
    <button
      type="button"
      role="switch"
      aria-checked={checked}
      aria-label={label}
      disabled={locked}
      onClick={() => onChange(!checked)}
      className={`relative inline-flex h-7 w-12 shrink-0 items-center rounded-full transition-colors duration-300 disabled:cursor-not-allowed disabled:opacity-60 ${checked ? "bg-brand-700" : "bg-brand-900/20"} ${focusRing}`}
    >
      <span className={`inline-block size-5 rounded-full bg-white shadow transition-transform duration-300 ${checked ? "translate-x-6" : "translate-x-1"}`} />
    </button>
  )
}

function SettingsModal({ initial, privacyUrl, onSave, onClose }) {
  const [prefs, setPrefs] = useState({ analytics: !!initial?.analytics, marketing: !!initial?.marketing })
  const panelRef = useRef(null)

  // Focus trap, Escape to close, scroll lock; focus returns to whatever opened the modal.
  useEffect(() => {
    const opener = document.activeElement
    const panel = panelRef.current
    panel.querySelector("button")?.focus()
    const previousOverflow = document.body.style.overflow
    document.body.style.overflow = "hidden"

    const onKey = e => {
      if (e.key === "Escape") return onClose()
      if (e.key !== "Tab") return
      const focusable = [...panel.querySelectorAll("button:not([disabled]), a[href]")]
      const first = focusable[0]
      const last = focusable[focusable.length - 1]
      if (e.shiftKey && document.activeElement === first) (e.preventDefault(), last.focus())
      else if (!e.shiftKey && document.activeElement === last) (e.preventDefault(), first.focus())
    }
    document.addEventListener("keydown", onKey)
    return () => {
      document.removeEventListener("keydown", onKey)
      document.body.style.overflow = previousOverflow
      opener?.focus?.()
    }
  }, [])

  return (
    <div className="fixed inset-0 z-[70] flex items-end justify-center bg-brand-950/50 p-3 backdrop-blur-sm sm:items-center" onMouseDown={e => e.target === e.currentTarget && onClose()}>
      <div ref={panelRef} role="dialog" aria-modal="true" aria-labelledby="dm-cookie-settings-title" className="max-h-[90vh] w-full max-w-lg animate-fade-in-zoom overflow-y-auto rounded-3xl bg-white p-6 shadow-2xl sm:p-8">
        <div className="flex items-start justify-between gap-4">
          <div className="flex items-center gap-3">
            <span className="flex size-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-700">
              <CookieIcon className="size-6" />
            </span>
            <h2 id="dm-cookie-settings-title" className="font-display text-2xl font-semibold text-brand-950">
              Cookie settings
            </h2>
          </div>
          <button type="button" onClick={onClose} aria-label="Close cookie settings" className={`flex size-10 items-center justify-center rounded-full text-brand-950 transition hover:bg-brand-50 ${focusRing}`}>
            <Icon name="x-mark" className="size-5" />
          </button>
        </div>

        <p className="mt-4 text-sm leading-relaxed text-ink/70">
          Choose which cookies you allow. You can change your choice at any time from the “Cookie Settings” link in the footer.
          {privacyUrl && (
            <>
              {" "}
              <a href={privacyUrl} className="font-semibold text-brand-700 underline">
                Privacy Policy
              </a>
            </>
          )}
        </p>

        <ul className="mt-6 space-y-3">
          {CATEGORIES.map(category => (
            <li key={category.key} className="rounded-2xl bg-cream p-5">
              <div className="flex items-center justify-between gap-4">
                <h3 className="font-bold text-brand-950">{category.title}</h3>
                {category.locked ? (
                  <span className="rounded-full bg-leaf-100 px-3 py-1 text-xs font-bold text-leaf-700">Always active</span>
                ) : (
                  <Switch label={`${category.title} cookies`} checked={prefs[category.key]} onChange={value => setPrefs(prev => ({ ...prev, [category.key]: value }))} />
                )}
              </div>
              <p className="mt-2 text-sm leading-relaxed text-ink/70">{category.text}</p>
            </li>
          ))}
        </ul>

        <div className="mt-6 grid grid-cols-2 gap-2">
          <button type="button" onClick={() => onSave(prefs)} className={`${primaryBtn} col-span-2`}>
            Save preferences
          </button>
          <button type="button" onClick={() => onSave({ analytics: false, marketing: false })} className={secondaryBtn}>
            Reject all
          </button>
          <button type="button" onClick={() => onSave({ analytics: true, marketing: true })} className={secondaryBtn}>
            Accept all
          </button>
        </div>
      </div>
    </div>
  )
}

export default function CookieConsent({ data }) {
  const { cookies, privacyUrl } = data
  const [consent, setConsent] = useState(readConsent)
  const [modalOpen, setModalOpen] = useState(false)
  const [bannerVisible, setBannerVisible] = useState(false)

  // Show the banner shortly after load (only if no choice is stored), so it doesn't fight the hero.
  useEffect(() => {
    if (consent) return
    const timer = setTimeout(() => setBannerVisible(true), 1200)
    return () => clearTimeout(timer)
  }, [])

  useEffect(() => {
    const open = () => setModalOpen(true)
    window.addEventListener(OPEN_COOKIE_SETTINGS, open)
    return () => window.removeEventListener(OPEN_COOKIE_SETTINGS, open)
  }, [])

  function decide(prefs) {
    setConsent(saveConsent(prefs))
    setBannerVisible(false)
    setModalOpen(false)
  }

  return (
    <>
      {bannerVisible && !consent && !modalOpen && (
        <div role="dialog" aria-modal="false" aria-labelledby="dm-cookie-title" aria-describedby="dm-cookie-text" className="fixed inset-x-3 bottom-3 z-[60] animate-fade-up rounded-3xl bg-white p-6 shadow-2xl shadow-brand-950/25 ring-1 ring-brand-900/10 sm:inset-x-auto sm:bottom-6 sm:left-6 sm:max-w-md">
          <div className="flex items-start gap-4">
            <span className="flex size-11 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-700">
              <CookieIcon className="size-6" />
            </span>
            <div>
              <h2 id="dm-cookie-title" className="font-display text-xl font-semibold text-brand-950">
                {cookies.title}
              </h2>
              <p id="dm-cookie-text" className="mt-2 text-sm leading-relaxed text-ink/70">
                {cookies.message}
                {privacyUrl && (
                  <>
                    {" "}
                    <a href={privacyUrl} className="font-semibold text-brand-700 underline">
                      Privacy Policy
                    </a>
                  </>
                )}
              </p>
            </div>
          </div>

          <div className="mt-5 grid grid-cols-2 gap-2">
            <button type="button" onClick={() => decide({ analytics: false, marketing: false })} className={secondaryBtn}>
              Reject non-essential
            </button>
            <button type="button" onClick={() => decide({ analytics: true, marketing: true })} className={primaryBtn}>
              Accept all
            </button>
          </div>
          <button type="button" onClick={() => setModalOpen(true)} className={`mt-3 w-full rounded-lg py-1 text-center text-sm font-semibold text-brand-700 underline-offset-4 hover:underline ${focusRing}`}>
            Customize settings
          </button>
        </div>
      )}

      {modalOpen && <SettingsModal initial={consent} privacyUrl={privacyUrl} onSave={decide} onClose={() => setModalOpen(false)} />}
    </>
  )
}
