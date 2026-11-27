const bouton_play = document.getElementById('playbutton')

const span_progession = document.getElementById('progression')
const span_max_duration = document.getElementById('max-duration')
const progress_fill = document.getElementById('progress-fill')

const player = document.getElementById('player')

const span_volume = document.getElementById('volume')
const volume_fill = document.getElementById('volume-fill')

player.ontimeupdate = (() => {
    span_progession.textContent = minutes_secondes(player.currentTime)
    progress_fill.style.width = (player.currentTime / player.duration) * 100 + "%"
})

player.onvolumechange = (() => {
    span_volume.textContent = Math.floor(player.volume * 100) + "%"
    volume_fill.style.width = player.volume * 100 + "%"
})

player.volume = 0.2

function minutes_secondes(temps) {
    const minutes = Math.floor(temps / 60)
    const secondes = Math.floor(temps) % 60

    return minutes + ":" + (secondes < 10 ? "0" : "") + secondes
}

function playbutton() {
    if (player.paused) {
        player.play()
        bouton_play.textContent = '⏸';
        span_max_duration.textContent = minutes_secondes(player.duration)
    }
    else {
        player.pause()
        bouton_play.textContent = '▶'
    }
}