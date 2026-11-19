// Home hero quote badge: the card pops out of a magician's hat 3 s after load (CSS: .dm-hat in src/index.css).
// The show only plays while the badge is on screen and the tab is visible; otherwise it waits.
// Reduced motion: the card is shown right away, no animation.
const DELAY = 3000
const SHOW_LENGTH = 2400

export function initHeroHat() {
  const el = document.querySelector("[data-hero-hat]")
  if (!el) return

  const finish = () => {
    el.classList.remove("is-hat-show")
    el.classList.add("is-hat-done")
  }
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return finish()

  let due = false
  let inView = false
  let played = false
  const observer = new IntersectionObserver(([entry]) => {
    inView = entry.isIntersecting
    tryPlay()
  })

  function tryPlay() {
    if (played || !due || !inView || document.hidden) return
    played = true
    observer.disconnect()
    document.removeEventListener("visibilitychange", tryPlay)
    el.classList.add("is-hat-show")
    setTimeout(finish, SHOW_LENGTH)
  }

  observer.observe(el)
  document.addEventListener("visibilitychange", tryPlay)
  setTimeout(() => {
    due = true
    tryPlay()
  }, DELAY)
}
