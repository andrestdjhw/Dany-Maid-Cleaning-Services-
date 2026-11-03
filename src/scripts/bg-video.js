// Decorative background videos (<video data-bg-video data-src-lg data-src-sm poster>).
// Nothing downloads until the section is near the viewport; the smaller file is used on phones,
// playback pauses off-screen, and reduced-motion visitors keep the static poster.

export function initBackgroundVideos() {
  const videos = document.querySelectorAll("video[data-bg-video]")
  if (!videos.length || window.matchMedia("(prefers-reduced-motion: reduce)").matches || !("IntersectionObserver" in window)) return

  const observer = new IntersectionObserver(
    entries => {
      entries.forEach(({ target: video, isIntersecting }) => {
        if (!isIntersecting) return video.pause()
        if (!video.src) {
          video.src = window.innerWidth >= 1024 ? video.dataset.srcLg : video.dataset.srcSm
          video.muted = true
        }
        video.play().catch(() => {})
      })
    },
    { rootMargin: "200px 0px" }
  )

  videos.forEach(video => observer.observe(video))
}
