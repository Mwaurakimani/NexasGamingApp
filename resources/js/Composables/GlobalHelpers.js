export const goFullScreen = () => {
    const el = document.documentElement
    if (!document.fullscreenElement) {
        el.requestFullscreen?.().catch((err) =>
            console.warn('Fullscreen request failed:', err)
        )
    }
}
