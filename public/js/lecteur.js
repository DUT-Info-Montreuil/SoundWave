function playbutton() {
    const audio = document.getElementById('player');
    const button = document.getElementById('playbutton')
    if (audio.paused) {
        audio.play()
        button.innerText = '⏸';
    }
    else {
        audio.pause()
        button.innerText = '▶'
    }
}