// add media first modal
let addMediaFirstModalBtn = document.getElementById("addMediaBtn");
let addMediaFirstModal = document.getElementById("addMediaFirstModal");
let addMediaFirstModalExitBtn = document.getElementById("addMediaFirstModalExitBtn");

function displayAddMediaFirstModal(e) {
  if (addMediaFirstModal.classList.contains("hideModal")) {
    e.preventDefault()
    console.log('test')
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
