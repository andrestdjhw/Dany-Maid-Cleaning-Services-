import { track } from "./analytics"

// Company intro video on the home page (template-parts/home/intro-video.php).
// Replaces the native controls with the big play button until the first play, then hands
// control back to the browser. Pauses when scrolled out of view; GA4 events carry no PII.
export function initIntroVideo() {
  document.querySelectorAll("[data-intro-video]").forEach(wrap => {
    const video = wrap.querySelector("video")
    const button = wrap.querySelector("[data-intro-play]")
    const label = wrap.querySelector("[data-intro-label]")
    if (!video || !button) return

    video.controls = false
    button.hidden = false
    let started = false
    const half = { sent: false }

    button.addEventListener("click", () => {
      button.hidden = true
      video.controls = true
      video.muted = false
      video.play().catch(() => {})
      video.focus({ preventScroll: true })
      track("video_play", { video: "company_intro", restart: started ? "yes" : "no" })
      started = true
    })

    video.addEventListener("timeupdate", () => {
      if (!half.sent && video.duration && video.currentTime / video.duration >= 0.5) {
        half.sent = true
        track("video_progress", { video: "company_intro", percent: 50 })
      }
    })

    video.addEventListener("ended", () => {
      track("video_complete", { video: "company_intro" })
      video.controls = false
      video.currentTime = 0
      if (label) label.textContent = "Watch again"
      button.hidden = false
    })

    if ("IntersectionObserver" in window) {
      new IntersectionObserver(([entry]) => !entry.isIntersecting && !video.paused && video.pause(), { threshold: 0.2 }).observe(wrap)
    }
  })
}
