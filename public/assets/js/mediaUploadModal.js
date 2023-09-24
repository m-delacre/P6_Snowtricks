let editBtn = document.getElementById("editMediaBtn");
let modal = document.getElementById("uploadModal");
let modalExitBtn = document.getElementById("modalExitBtn");

console.log('test')

function displayUploadModal(e) {
  if (modal.classList.contains("hideModal")) {
    e.preventDefault()
    modal.classList.remove("hideModal")
    modal.classList.add("displayModal");
  }
}

function hideUploadModal() {
  modal.classList.remove("displayModal")
  modal.classList.add("hideModal");
}

editBtn.addEventListener("click", displayUploadModal);
modalExitBtn.addEventListener("click", hideUploadModal);
