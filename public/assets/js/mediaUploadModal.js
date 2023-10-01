// add media first modal
let addMediaFirstModalBtn = document.getElementById("addMediaBtn");
let addMediaFirstModal = document.getElementById("addMediaFirstModal");
let addMediaFirstModalExitBtn = document.getElementById("addMediaFirstModalExitBtn");

function displayAddMediaFirstModal(e) {
  if (addMediaFirstModal.classList.contains("hideModal")) {
    e.preventDefault()
    addMediaFirstModal.classList.remove("hideModal");
    addMediaFirstModal.classList.add("displayModal");
  }
}

function hideAddMediaFirstModal() {
  addMediaFirstModal.classList.remove("displayModal");
  addMediaFirstModal.classList.add("hideModal");
}

addMediaFirstModalBtn.addEventListener("click", displayAddMediaFirstModal);
addMediaFirstModalExitBtn.addEventListener("click", hideAddMediaFirstModal);

//delete figure modal

let deleteFigureModalBtn = document.getElementById("deleteFigureModalBtn");
let deleteFigureModal = document.getElementById("deleteFigureModal");
let deleteFigureModalExitBtn = document.getElementById("deleteFigureModalExitBtn");
let deleteFigureModalNoBtn = document.getElementById("deleteFigureModalNoBtn");

function displayDeleteFigureModal(e) {
  if (deleteFigureModal.classList.contains("hideModal")) {
    e.preventDefault()
    deleteFigureModal.classList.remove("hideModal");
    deleteFigureModal.classList.add("displayModal");
  }
}

function hideDeleteFigureModal() {
  deleteFigureModal.classList.remove("displayModal");
  deleteFigureModal.classList.add("hideModal");
}

deleteFigureModalBtn.addEventListener("click", displayDeleteFigureModal);
deleteFigureModalExitBtn.addEventListener("click", hideDeleteFigureModal);
deleteFigureModalNoBtn.addEventListener("click", hideDeleteFigureModal);
