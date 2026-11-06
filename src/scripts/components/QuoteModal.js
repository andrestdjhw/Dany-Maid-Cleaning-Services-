import React, { useEffect, useRef, useState } from "react"
import Icon from "./Icon"
import ContactForm from "./ContactForm"

// Any link with data-quote-modal opens the quote form here instead of navigating (its href to
// /contact/ still works without JS or with a modifier-click). A brand curtain grows out of the
// clicked element as a circle, ripples spread from it, then the form panel rises; closing reverses
// it back into the element. Reduced motion: the global CSS rule collapses the transitions.
const DURATION = 700
const focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700"
const FOCUSABLE = 'a[href], button:not([disabled]), input:not([type="hidden"]):not([tabindex="-1"]), select, textarea'

function centerOf(el) {
  const r = el.getBoundingClientRect()
  return { x: r.left + r.width / 2, y: r.top + r.height / 2 }
}

export default function QuoteModal({ data }) {
  const [phase, setPhase] = useState("closed") // closed | opening | open | closing
  const [origin, setOrigin] = useState({ x: 0, y: 0 })
  const openerRef = useRef(null)
  const panelRef = useRef(null)

  useEffect(() => {
    const onClick = e => {
      const trigger = e.target.closest("[data-quote-modal]")
      if (!trigger || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return
      e.preventDefault()
      openerRef.current = trigger
      setOrigin(centerOf(trigger))
      setPhase("opening")
    }
    document.addEventListener("click", onClick)
    return () => document.removeEventListener("click", onClick)
  }, [])

  // Mount at radius 0, then switch to "open" two frames later so the clip-path transition runs.
  useEffect(() => {
    if (phase !== "opening") return
    let inner
    const outer = requestAnimationFrame(() => (inner = requestAnimationFrame(() => setPhase("open"))))
    return () => (cancelAnimationFrame(outer), cancelAnimationFrame(inner))
  }, [phase])

  function close() {
    if (openerRef.current) setOrigin(centerOf(openerRef.current))
    setPhase("closing")
    setTimeout(() => {
      setPhase("closed")
      openerRef.current?.focus()
    }, DURATION)
  }

  // Focus trap, Escape to close and scroll lock while the dialog is up.
  const isUp = phase !== "closed"
  useEffect(() => {
    if (!isUp) return
    const previousOverflow = document.body.style.overflow
    document.body.style.overflow = "hidden"
    const focusTimer = setTimeout(() => panelRef.current?.querySelector("input")?.focus({ preventScroll: true }), DURATION * 0.6)

    const onKey = e => {
      if (e.key === "Escape") return close()
      if (e.key !== "Tab" || !panelRef.current) return
      const focusable = [...panelRef.current.querySelectorAll(FOCUSABLE)]
      const first = focusable[0]
      const last = focusable[focusable.length - 1]
      if (e.shiftKey && document.activeElement === first) (e.preventDefault(), last.focus())
      else if (!e.shiftKey && document.activeElement === last) (e.preventDefault(), first.focus())
    }
    document.addEventListener("keydown", onKey)
    return () => {
      clearTimeout(focusTimer)
      document.removeEventListener("keydown", onKey)
      document.body.style.overflow = previousOverflow
    }
  }, [isUp])

  if (!isUp) return null

  const shown = phase === "open"
  const radius = Math.hypot(Math.max(origin.x, window.innerWidth - origin.x), Math.max(origin.y, window.innerHeight - origin.y))
  const onBackdrop = e => e.target === e.currentTarget && close()

  return (
    <div className="fixed inset-0 z-[80]">
      {/* Curtain: a circle that grows from the trigger to cover the viewport */}
      <div
        aria-hidden="true"
        className="absolute inset-0 overflow-hidden bg-linear-to-br from-brand-700 via-brand-800 to-brand-950 transition-[clip-path] ease-[cubic-bezier(0.76,0,0.24,1)]"
        style={{ clipPath: `circle(${shown ? radius : 0}px at ${origin.x}px ${origin.y}px)`, transitionDuration: `${DURATION}ms`, transitionDelay: phase === "closing" ? "120ms" : "0ms" }}
      >
        <div className="absolute -right-32 -top-32 size-128 animate-float-slow rounded-full bg-leaf-500/20 blur-3xl" />
        <div className="absolute -bottom-40 -left-24 size-128 animate-float rounded-full bg-brand-400/25 blur-3xl" />
        {shown &&
          [0, 1, 2].map(i => (
            <span key={i} className="dm-ripple absolute size-40 rounded-full border-2 border-white/40" style={{ left: origin.x - 80, top: origin.y - 80, animationDelay: `${i * 220}ms` }} />
          ))}
      </div>

      {/* Panel */}
      <div className="absolute inset-0 overflow-y-auto overscroll-contain" onMouseDown={onBackdrop}>
        <div className="flex min-h-full items-center justify-center p-3 sm:p-8" onMouseDown={onBackdrop}>
          <div
            ref={panelRef}
            role="dialog"
            aria-modal="true"
            aria-labelledby="dm-qm-title"
            className={`relative w-full max-w-2xl rounded-[2rem] bg-white p-6 pt-8 shadow-2xl shadow-brand-950/50 transition duration-500 ease-(--ease-out-soft) sm:p-10 ${shown ? "translate-y-0 scale-100 opacity-100 delay-300" : "translate-y-12 scale-95 opacity-0"}`}
          >
            <button type="button" onClick={close} aria-label="Close quote form" className={`absolute right-4 top-4 flex size-11 items-center justify-center rounded-full bg-cream text-brand-950 transition duration-300 hover:rotate-90 hover:bg-brand-50 ${focusRing}`}>
              <Icon name="x-mark" className="size-5" />
            </button>

            <p className="mb-5 inline-flex items-center gap-2 rounded-full bg-brand-50 py-1.5 pl-1.5 pr-4 text-sm font-bold text-brand-800">
              <span className="flex size-7 items-center justify-center rounded-full bg-brand-700 text-white">
                <Icon name="home" className="size-4" />
              </span>
              Based in {data.business.city}
            </p>

            <div className={shown ? "dm-quote-stagger" : ""}>
              <ContactForm data={data} formId="hero_quote_modal" idPrefix="dm-qm" />
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
