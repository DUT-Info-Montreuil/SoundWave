const span_progession = document.getElementById('progression')
const span_max_duration = document.getElementById('max-duration')

const audio = document.getElementById('player')
const bouton_play = document.getElementById('playbutton')

audio.ontimeupdate = (() => {
    span_progession.textContent = min_sec(audio.currentTime)
})

function min_sec(temps) {
    const minutes = Math.floor(temps / 60)
    const secondes = Math.floor(temps) % 60

    return minutes + ":" + (secondes < 10 ? "0" : "") + secondes
}

function playbutton() {
    if (audio.paused) {
        audio.play()
        bouton_play.textContent = '⏸';
        span_max_duration.textContent = min_sec(audio.duration)
    }
    else {
        audio.pause()
        bouton_play.textContent = '▶'
    }
}