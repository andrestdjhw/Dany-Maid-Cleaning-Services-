// Background video playlist (<div data-bg-playlist='[{"lg": url, "sm": url}, ...]'> with two <video> children).
// Plays the clips in order and loops: the next clip loads in the hidden <video> while the current one plays,
// then the two crossfade (opacity transition in the markup) 1 s before the current clip ends.
// Nothing downloads until the hero is near the viewport; playback pauses off-screen; phones get the "sm" files;
// reduced-motion visitors keep the poster of the first <video>.
const FADE = 1 // seconds, matches duration-1000 on the <video> elements

export function initBackgroundPlaylists() {
  const roots = document.querySelectorAll("[data-bg-playlist]")
  if (!roots.length || window.matchMedia("(prefers-reduced-motion: reduce)").matches || !("IntersectionObserver" in window)) return
  roots.forEach(setup)
}

function setup(root) {
  let clips
  try {
    clips = JSON.parse(root.dataset.bgPlaylist)
  } catch (e) {
    return
  }
  const videos = Array.from(root.querySelectorAll("video"))
  if (!clips.length || videos.length < 2) return

  const size = window.innerWidth >= 1024 ? "lg" : "sm"
  let current = 0 // index in videos of the visible player
  let clip = 0 // index in clips of the visible clip
  let started = false
  let visible = false
  let switching = false

  const load = (video, index) => {
    video.src = clips[index % clips.length][size]
    video.preload = "auto"
    video.load()
  }

  function next() {
    if (switching) return
    switching = true
    const from = videos[current]
    const to = videos[1 - current]
    clip = (clip + 1) % clips.length
    to.currentTime = 0
    if (visible) to.play().catch(() => {})
    to.classList.remove("opacity-0")
    from.classList.add("opacity-0")
    setTimeout(() => {
      from.pause()
      current = 1 - current
      switching = false
      load(from, clip + 1) // queue the clip after this one in the now hidden player
    }, FADE * 1000 + 150)
  }

  videos.forEach(video => {
    video.muted = true
    video.addEventListener("timeupdate", () => {
      if (video === videos[current] && video.duration && video.duration - video.currentTime <= FADE) next()
    })
    video.addEventListener("ended", () => {
      if (video === videos[current]) next()
    })
  })

  new IntersectionObserver(
    ([entry]) => {
      visible = entry.isIntersecting
      if (!visible) return videos.forEach(v => v.pause())
      if (!started) {
        started = true
        load(videos[0], 0)
        if (clips.length > 1) load(videos[1], 1)
      }
      videos[current].play().catch(() => {})
    },
    { rootMargin: "200px 0px" }
  ).observe(root)
}
