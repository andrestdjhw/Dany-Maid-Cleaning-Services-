import React from "react"
import Icon from "./Icon"

const focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"

// Office location in the contact section: keyless Google Maps embed of the business address.
// Loads for every visitor (lazily, when scrolled near), unlike the consent-gated service-area map.
export default function LocationMap({ data }) {
  const { name, street, city, region, zip, mapsUrl } = data.business
  const address = `${street}, ${city}, ${region} ${zip}`
  const query = encodeURIComponent(`${name}, ${address}`)
  const directionsUrl = mapsUrl || `https://www.google.com/maps/search/?api=1&query=${query}`

  return (
    <div>
      <div className="relative aspect-[16/10] overflow-hidden rounded-3xl bg-brand-800 ring-1 ring-white/15">
        <iframe
          src={`https://maps.google.com/maps?q=${query}&z=15&hl=en&output=embed`}
          title={`Map of ${name} at ${address}`}
          loading="lazy"
          referrerPolicy="no-referrer-when-downgrade"
          className="absolute inset-0 size-full border-0"
        />
      </div>

      <a href={directionsUrl} target="_blank" rel="noopener" className={`mt-3 inline-flex items-center gap-2 rounded-lg text-sm font-bold text-leaf-300 hover:underline ${focusRing}`}>
        Get directions <Icon name="arrow-right" className="size-4" />
        <span className="sr-only"> (opens in a new tab)</span>
      </a>
    </div>
  )
}
