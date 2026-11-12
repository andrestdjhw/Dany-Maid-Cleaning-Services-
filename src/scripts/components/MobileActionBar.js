import React from "react"
import Icon from "./Icon"

const focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700"

// Phones only (< sm): the header's call and quote CTAs live here instead, as a bar fixed to the
// bottom of the screen. Sits under the mobile menu (z-40) and the dialogs; body padding in
// src/index.css keeps it from covering the end of the page.
export default function MobileActionBar({ data }) {
  const { business, quoteUrl } = data

  return (
    <div className="fixed inset-x-0 bottom-0 z-30 border-t border-brand-900/10 bg-white/95 px-3 pt-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))] shadow-[0_-8px_24px_-12px] shadow-brand-950/20 backdrop-blur sm:hidden">
      <div className="grid grid-cols-2 gap-2">
        <a href={business.phoneHref} data-location="mobile_bar" className={`flex items-center justify-center gap-2 rounded-full px-4 py-3 text-base font-bold text-brand-800 ring-2 ring-brand-700 transition active:scale-[0.98] ${focusRing}`}>
          <Icon name="phone" className="dm-phone-ring size-5" />
          Call now
          <span className="sr-only"> {business.phone}</span>
        </a>
        <a href={quoteUrl} data-track="quote_cta_click" data-position="mobile_bar" className={`flex items-center justify-center gap-2 rounded-full bg-cta px-4 py-3 text-base font-bold text-white shadow-sm transition active:scale-[0.98] ${focusRing}`}>
          Get a Quote
          <Icon name="arrow-right" className="size-4" />
        </a>
      </div>
    </div>
  )
}
