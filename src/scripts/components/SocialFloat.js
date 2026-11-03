import React, { useEffect, useRef, useState } from "react"
import Icon from "./Icon"
import BrandIcon from "./BrandIcon"

const focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700"

// Hides the widget while these are on screen: the footer already lists the profiles,
// and the contact form must never be covered (brief: no floating element over forms).
const HIDE_WHEN_VISIBLE = ["#dm-footer", "#contact"]

function useHiddenNearSections() {
  const [hidden, setHidden] = useState(false)

  useEffect(() => {
    const targets = HIDE_WHEN_VISIBLE.map(s => document.querySelector(s)).filter(Boolean)
    if (!targets.length || !("IntersectionObserver" in window)) return
    const visible = new Set()
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => (entry.isIntersecting ? visible.add(entry.target) : visible.delete(entry.target)))
      setHidden(visible.size > 0)
    })
    targets.forEach(t => observer.observe(t))
    return () => observer.disconnect()
  }, [])

  return hidden
}

function SocialLink({ link, onClick, className, style, tooltip }) {
  return (
    <a
      href={link.url}
      target="_blank"
      rel="noopener"
      onClick={onClick}
      style={style}
      data-track="social_click"
      data-network={link.key}
      aria-label={`Dany Maid on ${link.label} (opens in a new tab)`}
      className={`group/link relative flex size-11 items-center justify-center rounded-full text-brand-700 transition duration-300 hover:scale-110 hover:bg-brand-700 hover:text-white ${focusRing} ${className}`}
    >
      <BrandIcon name={link.key} className="size-5" />
      {tooltip && (
        <span className="pointer-events-none absolute left-full ml-3 -translate-x-2 whitespace-nowrap rounded-lg bg-brand-950 px-3 py-1.5 text-xs font-bold text-white opacity-0 shadow-lg transition duration-300 group-hover/link:translate-x-0 group-hover/link:opacity-100 group-focus-visible/link:translate-x-0 group-focus-visible/link:opacity-100" aria-hidden="true">
          {link.label}
        </span>
      )}
    </a>
  )
}

export default function SocialFloat({ data }) {
  const links = data.social
  const hidden = useHiddenNearSections()
  const [entered, setEntered] = useState(false)
  const [open, setOpen] = useState(false)
  const mobileRef = useRef(null)

  // Slide in shortly after load so it doesn't compete with the hero.
  useEffect(() => {
    const timer = setTimeout(() => setEntered(true), 900)
    return () => clearTimeout(timer)
  }, [])

  useEffect(() => {
    if (!open) return
    const onKey = e => e.key === "Escape" && (setOpen(false), mobileRef.current.querySelector("button").focus())
    const onClick = e => !mobileRef.current.contains(e.target) && setOpen(false)
    document.addEventListener("keydown", onKey)
    document.addEventListener("mousedown", onClick)
    return () => {
      document.removeEventListener("keydown", onKey)
      document.removeEventListener("mousedown", onClick)
    }
  }, [open])

  useEffect(() => {
    if (hidden) setOpen(false)
  }, [hidden])

  if (!links.length) return null
  const show = entered && !hidden

  return (
    <aside aria-label="Dany Maid on social media">
      {/* Desktop: vertical rail on the left edge */}
      <div inert={show ? undefined : ""} className={`fixed left-4 top-1/2 z-30 hidden -translate-y-1/2 transition duration-700 ease-out lg:block ${show ? "translate-x-0 opacity-100" : "pointer-events-none -translate-x-24 opacity-0"}`}>
        <div className="flex flex-col items-center gap-1 rounded-full bg-white/95 p-1.5 shadow-xl shadow-brand-900/10 ring-1 ring-brand-900/10 backdrop-blur">
          {links.map(link => (
            <SocialLink key={link.key} link={link} tooltip />
          ))}
        </div>
        <div className="mx-auto mt-3 h-12 w-px bg-linear-to-b from-brand-300 to-transparent" aria-hidden="true" />
      </div>

      {/* Mobile: one small button that fans the profiles out upward */}
      <div ref={mobileRef} inert={show ? undefined : ""} className={`fixed bottom-4 left-4 z-30 transition duration-500 lg:hidden ${show ? "translate-y-0 opacity-100" : "pointer-events-none translate-y-24 opacity-0"}`}>
        <div id="dm-social-list" inert={open ? undefined : ""} className="absolute bottom-full left-0 mb-3 flex flex-col gap-2">
          {links.map((link, i) => (
            <SocialLink
              key={link.key}
              link={link}
              onClick={() => setOpen(false)}
              style={{ transitionDelay: open ? `${(links.length - 1 - i) * 50}ms` : "0ms" }}
              className={`bg-white shadow-lg ring-1 ring-brand-900/10 ${open ? "translate-y-0 opacity-100" : "pointer-events-none translate-y-4 opacity-0"}`}
            />
          ))}
        </div>
        <button
          type="button"
          aria-expanded={open}
          aria-controls="dm-social-list"
          aria-label={open ? "Close social media links" : "Follow Dany Maid on social media"}
          onClick={() => setOpen(!open)}
          className={`flex size-12 items-center justify-center rounded-full bg-brand-700 text-white shadow-lg shadow-brand-900/30 transition duration-300 hover:bg-brand-800 ${focusRing}`}
        >
          <Icon name={open ? "x-mark" : "share"} className={`size-6 transition duration-300 ${open ? "rotate-90" : ""}`} />
        </button>
      </div>
    </aside>
  )
}
