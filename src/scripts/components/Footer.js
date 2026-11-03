import React from "react"
import Icon from "./Icon"

const focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
const linkClass = `rounded text-brand-100 transition hover:text-white hover:underline ${focusRing}`

function Column({ title, children }) {
  return (
    <div>
      <h2 className="text-sm font-extrabold uppercase tracking-[0.14em] text-leaf-300">{title}</h2>
      <div className="mt-5">{children}</div>
    </div>
  )
}

export default function Footer({ data }) {
  const { homeUrl, quoteUrl, logo, business, social, services, serviceAreas, footerMenu, footerTagline, privacyUrl, isFrontPage } = data
  const year = new Date().getFullYear()

  return (
    <footer className="bg-brand-950 text-brand-100">
      {/* Closing CTA band (the home page ends with the contact form instead) */}
      {!isFrontPage && (
        <div className="border-b border-white/10">
          <div className="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-center lg:px-8">
            <div>
              <p className="font-display text-3xl font-semibold text-white">A cleaner home. A team you can feel good about.</p>
              <p className="mt-2 text-lg text-brand-100">Tell us about your home and we’ll help you find the next step.</p>
            </div>
            <div className="flex flex-col gap-3 sm:flex-row">
              <a href={quoteUrl} data-track="quote_cta_click" data-position="footer" className={`inline-flex items-center justify-center gap-2 rounded-full bg-leaf-500 px-6 py-3.5 font-bold text-brand-950 transition hover:bg-leaf-300 ${focusRing}`}>
                Get a Quote <Icon name="arrow-right" className="size-5" />
              </a>
              <a href={business.phoneHref} data-location="footer_cta" className={`inline-flex items-center justify-center gap-2 rounded-full border-2 border-white/40 px-6 py-3 font-bold text-white transition hover:bg-white/10 ${focusRing}`}>
                <Icon name="phone" className="size-5" /> {business.phone}
              </a>
            </div>
          </div>
        </div>
      )}

      <div className="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 md:grid-cols-2 lg:grid-cols-12 lg:px-8">
        <div className="lg:col-span-4">
          <a href={homeUrl} className={`inline-block rounded-2xl bg-white p-3 ${focusRing}`} aria-label="Dany Maid home">
            {logo ? <img src={logo.url} srcSet={logo.srcset} sizes="150px" width={logo.width} height={logo.height} alt={logo.alt} className="h-14 w-auto" loading="lazy" /> : <span className="font-display text-2xl font-bold text-brand-800">Dany Maid</span>}
          </a>
          {footerTagline && <p className="mt-6 max-w-sm leading-relaxed">{footerTagline}</p>}

          <address className="mt-6 space-y-3 not-italic">
            <a href={business.mapsUrl} target="_blank" rel="noopener" className={`flex gap-3 ${linkClass}`}>
              <Icon name="map-pin" className="mt-0.5 size-5 shrink-0 text-leaf-300" />
              <span>
                {business.street}
                <br />
                {business.city}, {business.region} {business.zip}
                <span className="sr-only"> (opens Google Maps in a new tab)</span>
              </span>
            </a>
            <a href={business.phoneHref} data-location="footer" className={`flex items-center gap-3 font-bold text-white ${linkClass}`}>
              <Icon name="phone" className="size-5 shrink-0 text-leaf-300" /> {business.phone}
            </a>
            {business.email && (
              <a href={`mailto:${business.email}`} className={`flex items-center gap-3 ${linkClass}`}>
                <Icon name="envelope" className="size-5 shrink-0 text-leaf-300" /> {business.email}
              </a>
            )}
            {business.hours && (
              <p className="flex items-center gap-3">
                <Icon name="clock" className="size-5 shrink-0 text-leaf-300" /> {business.hours}
              </p>
            )}
          </address>
        </div>

        <div className="lg:col-span-2">
          <Column title="Services">
            <ul className="space-y-3">
              {services.map(service => (
                <li key={service.key}>
                  <a href={service.url} data-track="select_service" data-service={service.key} data-source="footer" className={linkClass}>
                    {service.title}
                  </a>
                </li>
              ))}
            </ul>
          </Column>
        </div>

        <div className="lg:col-span-2">
          <Column title="Company">
            <ul className="space-y-3">
              {footerMenu.map(item => (
                <li key={item.url + item.label}>
                  <a href={item.url} className={linkClass}>
                    {item.label}
                  </a>
                </li>
              ))}
            </ul>
          </Column>
        </div>

        <div className="md:col-span-2 lg:col-span-4">
          <Column title="Service Areas">
            <ul className="grid grid-cols-2 gap-x-6 gap-y-2.5">
              {serviceAreas.map(city => (
                <li key={city}>{city}, CA</li>
              ))}
            </ul>
            <a href={`${homeUrl}service-areas/`} className={`mt-5 inline-flex items-center gap-2 font-bold text-white ${linkClass}`}>
              View all service areas <Icon name="arrow-right" className="size-4" />
            </a>
          </Column>
        </div>
      </div>

      <div className="border-t border-white/10">
        <div className="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-8 text-sm sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
          <div className="flex flex-wrap items-center gap-x-6 gap-y-2">
            <p>© {year} Dany Maid LLC. All rights reserved.</p>
            {privacyUrl && (
              <a href={privacyUrl} className={linkClass}>
                Privacy Policy
              </a>
            )}
            <p className="text-brand-100/80">
              Crafted by{" "}
              <a href="https://828marketingsolutions.com" target="_blank" rel="noopener" className={`font-semibold text-white ${linkClass}`}>
                828 Marketing Solutions
                <span className="sr-only"> (opens in a new tab)</span>
              </a>
            </p>
          </div>
          {social.length > 0 && (
            <ul className="flex flex-wrap gap-2" aria-label="Dany Maid on other sites">
              {social.map(link => (
                <li key={link.key}>
                  <a href={link.url} target="_blank" rel="noopener" className={`inline-block rounded-full px-4 py-2 font-semibold ring-1 ring-white/20 transition hover:bg-white/10 hover:text-white ${focusRing}`}>
                    {link.label}
                    <span className="sr-only"> (opens in a new tab)</span>
                  </a>
                </li>
              ))}
            </ul>
          )}
        </div>
      </div>
    </footer>
  )
}
