let editBtn = document.getElementById("editMediaBtn");
let modal = document.getElementById("uploadModal");
let modalExitBtn = document.getElementById("modalExitBtn");

console.log('test')

function displayUploadModal() {
  if (modal.classList.contains("hideModal")) {
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
