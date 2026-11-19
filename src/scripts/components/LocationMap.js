import React from "react"

// Office location in the contact section: keyless Google Maps embed of the business address.
// Loads for every visitor (lazily, when scrolled near), unlike the consent-gated service-area map.
export default function LocationMap({ data }) {
  const { name, street, city, region, zip } = data.business
  const address = `${street}, ${city}, ${region} ${zip}`
  const query = encodeURIComponent(`${name}, ${address}`)

  // lg+: the mount is a flex column that stretches to the form's bottom edge (template-parts/home/contact.php),
  // so the map grows to fill it. "Get directions" lives under the address in the contact card.
  return (
    <div className="relative aspect-[16/10] overflow-hidden rounded-3xl bg-brand-800 ring-1 ring-white/15 lg:aspect-auto lg:min-h-72 lg:flex-1">
      <iframe
        src={`https://maps.google.com/maps?q=${query}&z=15&hl=en&output=embed`}
        title={`Map of ${name} at ${address}`}
        loading="lazy"
        referrerPolicy="no-referrer-when-downgrade"
        className="absolute inset-0 size-full border-0"
      />
    </div>
  )
}
