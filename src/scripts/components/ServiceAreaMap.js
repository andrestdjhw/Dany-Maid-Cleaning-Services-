import React, { useEffect, useRef, useState } from "react"
import Icon from "./Icon"
import { readConsent, CONSENT_UPDATED } from "../consent"

const focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700"

// Keyless Google Maps embed; counties show their boundary, cities get a pin.
const embedUrl = place => `https://maps.google.com/maps?q=${encodeURIComponent(`${place.query}, CA`)}&z=${place.zoom}&hl=en&output=embed`
const openUrl = place => `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(`${place.query}, CA`)}&hl=en`

// Google sets third-party cookies, so the map only loads automatically after "Accept all"
// (or a saved choice that allows marketing); otherwise the visitor loads it with one click.
function useMapAllowed() {
  const [allowed, setAllowed] = useState(() => !!readConsent()?.marketing)
  useEffect(() => {
    const onConsent = e => e.detail?.marketing && setAllowed(true)
    window.addEventListener(CONSENT_UPDATED, onConsent)
    return () => window.removeEventListener(CONSENT_UPDATED, onConsent)
  }, [])
  return [allowed, () => setAllowed(true)]
}

export default function ServiceAreaMap({ data }) {
  const { areaGroups, business } = data
  const homeBase = business.city
  const [selected, setSelected] = useState({ query: homeBase, label: `${homeBase}, CA`, zoom: 11 })
  const [allowed, allow] = useMapAllowed()
  const mapRef = useRef(null)

  // On phones the map sits above the list, so bring it back into view after a selection.
  function select(query, label, zoom) {
    setSelected({ query, label, zoom })
    if (window.innerWidth < 1024) mapRef.current?.scrollIntoView({ behavior: "smooth", block: "start" })
  }
  const isSelected = query => selected.query === query

  return (
    <div className="grid gap-8 lg:grid-cols-12 lg:gap-12">
      <div className="space-y-6 lg:col-span-5">
        {areaGroups.map(group => (
          <div key={group.county}>
            {group.county !== "Other areas" ? (
              <button
                type="button"
                onClick={() => select(group.county, group.county, 9)}
                aria-pressed={isSelected(group.county)}
                className={`group flex w-full items-center justify-between rounded-2xl px-4 py-3 text-left transition duration-300 ${focusRing} ${isSelected(group.county) ? "bg-brand-900 text-white" : "bg-brand-50 text-brand-950 hover:bg-brand-100"}`}
              >
                <span>
                  <span className="block font-display text-lg font-semibold">{group.county}</span>
                  <span className={`text-xs font-bold uppercase tracking-wide ${isSelected(group.county) ? "text-leaf-300" : "text-brand-700"}`}>
                    {group.cities.length} {group.cities.length === 1 ? "community" : "communities"} · View county
                  </span>
                </span>
                <Icon name="map-pin" className={`size-5 transition group-hover:scale-110 ${isSelected(group.county) ? "text-leaf-300" : "text-brand-600"}`} />
              </button>
            ) : (
              <p className="px-1 font-display text-lg font-semibold text-brand-950">{group.county}</p>
            )}

            <ul className="mt-3 grid grid-cols-2 gap-2">
              {group.cities.map(city => {
                const active = isSelected(city)
                const base = city.toLowerCase() === homeBase.toLowerCase()
                return (
                  <li key={city}>
                    <button
                      type="button"
                      onClick={() => select(city, `${city}, CA`, 12)}
                      aria-pressed={active}
                      className={`flex w-full items-center gap-2 rounded-xl px-3 py-2.5 text-left text-sm font-semibold transition duration-300 hover:-translate-y-0.5 ${focusRing} ${active ? "bg-brand-700 text-white shadow-md" : "bg-cream text-brand-950 hover:shadow-md"}`}
                    >
                      <Icon name="map-pin" className={`size-4 shrink-0 ${active ? "text-leaf-300" : "text-brand-600"}`} />
                      <span>
                        {city}
                        {base && <span className={`block text-[0.65rem] font-bold uppercase tracking-wide ${active ? "text-brand-100" : "text-brand-700"}`}>Home base</span>}
                      </span>
                    </button>
                  </li>
                )
              })}
            </ul>
          </div>
        ))}
      </div>

      <div ref={mapRef} className="order-first scroll-mt-24 lg:order-none lg:col-span-7">
        <div className="lg:sticky lg:top-32">
          <div className="relative aspect-[4/3] overflow-hidden rounded-[2rem] bg-brand-50 shadow-2xl shadow-brand-900/15 ring-1 ring-brand-900/10">
            {allowed ? (
              <iframe
                key={selected.query}
                src={embedUrl(selected)}
                title={`Map of ${selected.label}`}
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                className="absolute inset-0 size-full animate-fade-in-zoom border-0"
              />
            ) : (
              <div className="absolute inset-0 flex flex-col items-center justify-center bg-linear-to-br from-brand-100 via-brand-50 to-leaf-100 p-8 text-center">
                <span className="flex size-16 animate-float items-center justify-center rounded-3xl bg-white text-brand-700 shadow-lg">
                  <Icon name="map-pin" className="size-8" />
                </span>
                <p className="mt-5 font-display text-2xl font-semibold text-brand-950">{selected.label}</p>
                <p className="mt-2 max-w-sm text-sm text-ink/70">The map is provided by Google, which may set its own cookies.</p>
                <button type="button" onClick={allow} className={`mt-5 rounded-full bg-brand-700 px-6 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-brand-800 ${focusRing}`}>
                  Show map
                </button>
              </div>
            )}
          </div>

          <div className="mt-4 flex flex-wrap items-center justify-between gap-3">
            <p className="flex items-center gap-2 font-semibold text-brand-950" aria-live="polite">
              <Icon name="map-pin" className="size-5 text-leaf-600" />
              Showing: {selected.label}
            </p>
            <a href={openUrl(selected)} target="_blank" rel="noopener" className={`inline-flex items-center gap-2 rounded-lg text-sm font-bold text-brand-700 hover:underline ${focusRing}`}>
              Open in Google Maps <Icon name="arrow-right" className="size-4" />
              <span className="sr-only"> (opens in a new tab)</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  )
}
