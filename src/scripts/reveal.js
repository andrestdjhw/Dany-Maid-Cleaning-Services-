// Scroll-triggered reveal for [data-reveal] elements and count-up for [data-count] numbers.
// The hiding CSS only applies under html.dm-js (see dm_js_class() in functions.php).

const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches

function countUp(el) {
  const target = parseFloat(el.dataset.count)
  if (Number.isNaN(target)) return
  const decimals = (el.dataset.count.split(".")[1] || "").length
  const duration = 1400
  const start = performance.now()

  const step = now => {
    const progress = Math.min((now - start) / duration, 1)
    const eased = 1 - Math.pow(1 - progress, 3)
    el.textContent = (target * eased).toFixed(decimals)
    if (progress < 1) requestAnimationFrame(step)
  }
  requestAnimationFrame(step)
}

export function initReveal() {
  window.dmRevealReady = true
  const items = document.querySelectorAll("[data-reveal], [data-count]")

  if (reducedMotion || !("IntersectionObserver" in window)) {
    items.forEach(el => el.classList.add("is-visible"))
    return
  }

  const observer = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return
        const el = entry.target
        el.classList.add("is-visible")
        if (el.dataset.count) countUp(el)
        observer.unobserve(el)
      })
    },
    { threshold: 0.15, rootMargin: "0px 0px -8% 0px" }
  )

  items.forEach(el => observer.observe(el))
}
