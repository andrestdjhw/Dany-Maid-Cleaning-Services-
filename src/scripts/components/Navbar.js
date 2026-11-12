import React, { useEffect, useRef, useState } from "react"
import Icon from "./Icon"

const focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700"

function isCurrent(url) {
  try {
    return new URL(url, window.location.origin).pathname === window.location.pathname
  } catch (err) {
    return false
  }
}

function Logo({ logo, homeUrl, scrolled }) {
  return (
    <a href={homeUrl} className={`shrink-0 rounded-lg ${focusRing}`} aria-label="Dany Maid home">
      {logo ? (
        <img src={logo.url} srcSet={logo.srcset} sizes="170px" width={logo.width} height={logo.height} alt={logo.alt} className={`w-auto transition-all duration-300 ${scrolled ? "h-13 min-[380px]:h-15" : "h-14 min-[380px]:h-16.5 lg:h-19.5"}`} />
      ) : (
        <span className="font-display text-2xl font-bold text-brand-800">Dany Maid</span>
      )}
    </a>
  )
}

function DesktopDropdown({ item }) {
  const [open, setOpen] = useState(false)
  const ref = useRef(null)

  useEffect(() => {
    if (!open) return
    const onClick = e => !ref.current.contains(e.target) && setOpen(false)
    const onKey = e => e.key === "Escape" && (setOpen(false), ref.current.querySelector("button").focus())
    document.addEventListener("mousedown", onClick)
    document.addEventListener("keydown", onKey)
    return () => {
      document.removeEventListener("mousedown", onClick)
      document.removeEventListener("keydown", onKey)
    }
  }, [open])

  return (
    <li ref={ref} className="relative" onMouseEnter={() => setOpen(true)} onMouseLeave={() => setOpen(false)} onBlur={e => !ref.current.contains(e.relatedTarget) && setOpen(false)}>
      <button type="button" aria-expanded={open} onClick={() => setOpen(!open)} className={`flex items-center gap-1 rounded-lg px-3 py-2 font-bold text-brand-950 transition hover:text-brand-700 ${focusRing}`}>
        {item.label}
        <Icon name="chevron-down" className={`size-4 transition ${open ? "rotate-180" : ""}`} />
      </button>
      <div className={`absolute left-0 top-full pt-3 transition ${open ? "visible translate-y-0 opacity-100" : "invisible -translate-y-1 opacity-0"}`}>
        <ul className="w-72 rounded-2xl bg-white p-2 shadow-xl ring-1 ring-brand-900/10">
          {item.children.map(child => (
            <li key={child.url + child.label}>
              <a href={child.url} aria-current={isCurrent(child.url) ? "page" : undefined} className={`block rounded-xl px-4 py-2.5 font-semibold text-brand-950 transition hover:bg-brand-50 hover:text-brand-700 aria-[current=page]:text-brand-700 ${focusRing}`}>
                {child.label}
              </a>
            </li>
          ))}
        </ul>
      </div>
    </li>
  )
}

function MobileMenu({ menu, business, quoteUrl, onClose, top }) {
  const [expanded, setExpanded] = useState(null)

  return (
    <div id="dm-mobile-menu" style={{ top }} className="animate-slide-down fixed inset-x-0 bottom-0 z-40 overflow-y-auto border-t border-brand-900/10 bg-white lg:hidden">
      <nav aria-label="Mobile" className="px-4 pb-10 pt-4">
        <ul className="divide-y divide-brand-900/10">
          {menu.map((item, i) =>
            item.children.length ? (
              <li key={item.label}>
                <button type="button" aria-expanded={expanded === i} onClick={() => setExpanded(expanded === i ? null : i)} className={`flex w-full items-center justify-between py-4 text-lg font-bold text-brand-950 ${focusRing}`}>
                  {item.label}
                  <Icon name="chevron-down" className={`size-5 transition ${expanded === i ? "rotate-180" : ""}`} />
                </button>
                {expanded === i && (
                  <ul className="mb-3 space-y-1 rounded-2xl bg-brand-50 p-2">
                    {item.children.map(child => (
                      <li key={child.url + child.label}>
                        <a href={child.url} onClick={onClose} className={`block rounded-xl px-4 py-3 font-semibold text-brand-950 ${focusRing}`}>
                          {child.label}
                        </a>
                      </li>
                    ))}
                  </ul>
                )}
              </li>
            ) : (
              <li key={item.label}>
                <a href={item.url} onClick={onClose} aria-current={isCurrent(item.url) ? "page" : undefined} className={`block py-4 text-lg font-bold text-brand-950 aria-[current=page]:text-brand-700 ${focusRing}`}>
                  {item.label}
                </a>
              </li>
            )
          )}
        </ul>

        <a href={quoteUrl} data-track="quote_cta_click" data-position="mobile_menu" className={`mt-6 flex items-center justify-center gap-2 rounded-full bg-cta px-6 py-4 text-lg font-bold text-white ${focusRing}`}>
          Get a Quote <Icon name="arrow-right" className="size-5" />
        </a>
        <div className="mt-6 space-y-3 rounded-2xl bg-cream p-5 text-brand-950">
          <a href={business.phoneHref} data-location="mobile_menu" className={`flex items-center gap-3 font-bold ${focusRing}`}>
            <Icon name="phone" className="size-5 text-brand-700" /> {business.phone}
          </a>
          {business.email && (
            <a href={`mailto:${business.email}`} className={`flex items-center gap-3 font-semibold ${focusRing}`}>
              <Icon name="envelope" className="size-5 text-brand-700" /> {business.email}
            </a>
          )}
        </div>
      </nav>
    </div>
  )
}

export default function Navbar({ data }) {
  const { logo, homeUrl, quoteUrl, business, primaryMenu } = data
  const [scrolled, setScrolled] = useState(false)
  const [menuOpen, setMenuOpen] = useState(false)
  const [menuTop, setMenuTop] = useState(72)
  const headerRef = useRef(null)

  // The panel opens right under the header, wherever it is (WP admin bar, scroll position).
  function toggleMenu() {
    if (!menuOpen) setMenuTop(headerRef.current.getBoundingClientRect().bottom)
    setMenuOpen(!menuOpen)
  }

  useEffect(() => {
    // Hysteresis: the header shrinks on scroll, so a single threshold would make it flicker.
    const onScroll = () => setScrolled(prev => (prev ? window.scrollY > 8 : window.scrollY > 48))
    onScroll()
    window.addEventListener("scroll", onScroll, { passive: true })
    return () => window.removeEventListener("scroll", onScroll)
  }, [])

  useEffect(() => {
    document.body.style.overflow = menuOpen ? "hidden" : ""
    if (!menuOpen) return
    const onKey = e => e.key === "Escape" && setMenuOpen(false)
    const onResize = () => window.innerWidth >= 1024 && setMenuOpen(false)
    document.addEventListener("keydown", onKey)
    window.addEventListener("resize", onResize)
    return () => {
      document.removeEventListener("keydown", onKey)
      window.removeEventListener("resize", onResize)
    }
  }, [menuOpen])

  return (
    <header ref={headerRef} className={`bg-white transition-shadow duration-300 ${scrolled || menuOpen ? "shadow-md" : ""}`}>
      {/* Utility bar (desktop): collapses once the visitor scrolls */}
      <div className={`hidden overflow-hidden bg-cta text-sm font-bold text-white transition-all duration-300 lg:block ${scrolled ? "max-h-0" : "max-h-10"}`}>
        <div className="mx-auto flex h-10 max-w-7xl items-center justify-between px-8">
          <p className="flex items-center gap-2">
            <Icon name="map-pin" className="size-4" />
            Based in {business.city} · Serving homes across the Sacramento area
          </p>
          <div className="flex items-center gap-6">
            {business.email && (
              <a href={`mailto:${business.email}`} className="flex items-center gap-2 hover:underline">
                <Icon name="envelope" className="size-4" /> {business.email}
              </a>
            )}
            <a href={business.phoneHref} data-location="utility_bar" className="flex items-center gap-2 font-extrabold hover:underline">
              <Icon name="phone" className="size-4" /> {business.phone}
            </a>
          </div>
        </div>
      </div>

      <div className={`mx-auto flex max-w-7xl items-center justify-between gap-2 px-4 sm:gap-4 transition-all duration-300 sm:px-6 lg:px-8 ${scrolled ? "h-18" : "h-20 lg:h-22"}`}>
        <Logo logo={logo} homeUrl={homeUrl} scrolled={scrolled} />

        <nav aria-label="Main" className="hidden lg:block">
          <ul className="flex items-center gap-1 xl:gap-2">
            {primaryMenu.map(item =>
              item.children.length ? (
                <DesktopDropdown key={item.label} item={item} />
              ) : (
                <li key={item.label}>
                  <a href={item.url} aria-current={isCurrent(item.url) ? "page" : undefined} className={`rounded-lg px-3 py-2 font-bold text-brand-950 transition hover:text-brand-700 aria-[current=page]:text-brand-700 ${focusRing}`}>
                    {item.label}
                  </a>
                </li>
              )
            )}
          </ul>
        </nav>

        <div className="flex items-center gap-1 sm:gap-3">
          {/* Tablet only (phones use MobileActionBar). The pill grows leftward over the header on hover/focus so "Call now" never shifts the layout. */}
          <a href={business.phoneHref} data-location="header" aria-label={`Call Dany Maid at ${business.phone}`} className={`group relative hidden size-11 shrink-0 rounded-full sm:block lg:hidden ${focusRing}`}>
            <span className="absolute inset-y-0 right-0 flex items-center rounded-full bg-white text-brand-700 ring-1 ring-brand-900/15 transition-colors duration-300 group-hover:bg-brand-700 group-hover:text-white group-hover:shadow-lg group-hover:ring-brand-700 group-focus-visible:bg-brand-700 group-focus-visible:text-white">
              <span className="max-w-0 overflow-hidden whitespace-nowrap text-sm font-bold opacity-0 transition-all duration-500 ease-(--ease-out-soft) group-hover:max-w-24 group-hover:pl-4 group-hover:opacity-100 group-focus-visible:max-w-24 group-focus-visible:pl-4 group-focus-visible:opacity-100" aria-hidden="true">
                Call now
              </span>
              <span className="flex size-10 shrink-0 items-center justify-center min-[380px]:size-11">
                <Icon name="phone" className="dm-phone-ring size-5 transition-transform duration-700 ease-(--ease-out-soft) group-hover:rotate-[360deg] group-hover:[animation:none]" />
              </span>
            </span>
          </a>
          <a
            href={quoteUrl}
            data-track="quote_cta_click"
            data-position="header"
            className={`hidden items-center gap-2 whitespace-nowrap rounded-full px-5 py-2.5 text-base font-bold transition-colors duration-300 sm:inline-flex ${focusRing} bg-cta text-white hover:bg-cta-hover`}
          >
            Get a Quote
            <Icon name="arrow-right" className="size-4" />
          </a>
          <button
            type="button"
            aria-expanded={menuOpen}
            aria-controls="dm-mobile-menu"
            aria-label={menuOpen ? "Close menu" : "Open menu"}
            onClick={toggleMenu}
            className={`flex size-10 items-center justify-center rounded-full text-brand-950 transition hover:bg-brand-50 min-[380px]:size-11 lg:hidden ${focusRing}`}
          >
            <Icon name={menuOpen ? "x-mark" : "bars"} className="size-6" />
          </button>
        </div>
      </div>

      {menuOpen && <MobileMenu menu={primaryMenu} business={business} quoteUrl={quoteUrl} top={menuTop} onClose={() => setMenuOpen(false)} />}
    </header>
  )
}
