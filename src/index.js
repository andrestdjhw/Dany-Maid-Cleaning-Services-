import React from "react"
import ReactDOM from "react-dom/client"
import Navbar from "./scripts/components/Navbar"
import Footer from "./scripts/components/Footer"
import ContactForm from "./scripts/components/ContactForm"
import SocialFloat from "./scripts/components/SocialFloat"
import CookieConsent from "./scripts/components/CookieConsent"
import ServiceAreaMap from "./scripts/components/ServiceAreaMap"
import { initClickTracking, captureUtm } from "./scripts/analytics"
import { initReveal } from "./scripts/reveal"
import { initBackgroundVideos } from "./scripts/bg-video"

// window.danyMaid is printed by dm_load_assets() in functions.php
const data = window.danyMaid

const mounts = {
  "#dm-navbar": Navbar,
  "#dm-footer": Footer,
  "#dm-contact-form": ContactForm,
  "#dm-social-float": SocialFloat,
  "#dm-cookie-consent": CookieConsent,
  "#dm-area-map": ServiceAreaMap
}

Object.entries(mounts).forEach(([selector, Component]) => {
  const el = document.querySelector(selector)
  if (el) {
    ReactDOM.createRoot(el).render(<Component data={data} {...el.dataset} />)
  }
})

// The navbar wrapper reserves space before React mounts; once rendered it should follow the header's height.
document.querySelector("#dm-navbar")?.classList.remove("min-h-20", "lg:min-h-32")

initReveal()
initBackgroundVideos()
initClickTracking()
captureUtm()
