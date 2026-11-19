import React from "react"
import Icon, { CtaArrow } from "./Icon"
import BrandIcon, { hasBrandIcon } from "./BrandIcon"
import { OPEN_COOKIE_SETTINGS } from "../consent"

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
  const { homeUrl, quoteUrl, footerLogo, business, social, services, serviceAreas, footerMenu, footerTagline, privacyUrl, termsUrl, hideFooterCta } = data
  const year = new Date().getFullYear()

  return (
    <footer className="bg-brand-950 text-brand-100">
      {/* Closing CTA band (hidden where the page already ends with the contact form) */}
      {!hideFooterCta && (
        <div className="border-b border-white/10">
          <div className="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-center lg:px-8">
            <div>
              <p className="font-display text-3xl font-semibold text-white">A cleaner home. A team you can feel good about.</p>
              <p className="mt-2 text-lg text-brand-100">Tell us about your home and we’ll help you find the next step.</p>
            </div>
            <div className="flex flex-col gap-3 sm:flex-row">
              <a href={quoteUrl} data-track="quote_cta_click" data-position="footer" className={`dm-cta inline-flex items-center justify-center gap-2 rounded-full bg-cta px-6 py-3.5 font-bold text-white hover:bg-cta-hover ${focusRing}`}>
                Get a Quote <CtaArrow />
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
          <a href={homeUrl} className={`inline-block rounded-xl transition hover:opacity-90 ${focusRing}`} aria-label="Dany Maid home">
            {footerLogo ? <img src={footerLogo} width="900" height="414" alt="Dany Maid" className="h-24 w-auto sm:h-28" loading="lazy" /> : <span className="font-display text-3xl font-bold text-white">Dany Maid</span>}
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

          {/* Profiles as round icon buttons (BBB has no brand icon, so it shows its initials) */}
          {social.length > 0 && (
            <ul className="mt-8 flex flex-wrap gap-3" aria-label="Dany Maid on other sites">
              {social.map(link => (
                <li key={link.key}>
                  <a href={link.url} target="_blank" rel="noopener" title={link.label} className={`flex size-11 items-center justify-center rounded-full text-white ring-1 ring-white/25 transition duration-300 hover:-translate-y-0.5 hover:bg-cta hover:ring-cta ${focusRing}`}>
                    {hasBrandIcon(link.key) ? <BrandIcon name={link.key} className="size-5" /> : <span className="text-xs font-extrabold tracking-wide">{link.label}</span>}
                    <span className="sr-only">{link.label} (opens in a new tab)</span>
                  </a>
                </li>
              ))}
            </ul>
          )}
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

      {/* Bottom bar: one line on desktop (copyright + legal links left, credit right), centered stack on phones */}
      <div className="border-t border-white/10">
        <div className="mx-auto flex max-w-7xl flex-col items-center gap-4 px-4 py-6 text-center text-sm sm:px-6 lg:flex-row lg:justify-between lg:px-8 lg:text-left">
          <div className="flex flex-col items-center gap-x-6 gap-y-3 sm:flex-row sm:flex-wrap sm:justify-center">
            <p>© {year} Dany Maid LLC. All rights reserved.</p>
            <ul className="flex flex-wrap items-center justify-center gap-x-6 gap-y-2" aria-label="Legal">
              {privacyUrl && (
                <li>
                  <a href={privacyUrl} className={linkClass}>
                    Privacy Policy
                  </a>
                </li>
              )}
              {termsUrl && (
                <li>
                  <a href={termsUrl} className={linkClass}>
                    Terms &amp; Conditions
                  </a>
                </li>
              )}
              <li>
                <button type="button" onClick={() => window.dispatchEvent(new Event(OPEN_COOKIE_SETTINGS))} className={linkClass}>
                  Cookie Settings
                </button>
              </li>
            </ul>
          </div>
          <p className="text-brand-100/80">
            Crafted by{" "}
            <a href="https://828marketingsolutions.com" target="_blank" rel="noopener" className={`font-semibold text-white ${linkClass}`}>
              828 Marketing Solutions
              <span className="sr-only"> (opens in a new tab)</span>
            </a>
          </p>
        </div>
      </div>
    </footer>
  )
}
