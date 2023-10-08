let showMediaBtn = document.getElementById('showPicture');
let sectionMedias = document.getElementById('figuresMedias');

function displayMedia() {
    sectionMedias.classList.add('showMedias')
    showMediaBtn.classList = 'hideBtn'
}

showMediaBtn.addEventListener('click', displayMedia)