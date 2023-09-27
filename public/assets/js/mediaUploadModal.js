// upload modal
let editBtn = document.getElementById("editMediaBtn");
let modal = document.getElementById("uploadModal");
let UploadModalExitBtn = document.getElementById("UploadModalExitBtn");

function displayUploadModal(e) {
  if (modal.classList.contains("hideModal")) {
    e.preventDefault()
    modal.classList.remove("hideModal");
    modal.classList.add("displayModal");
  }
}

function hideUploadModal() {
  modal.classList.remove("displayModal");
  modal.classList.add("hideModal");
}

editBtn.addEventListener("click", displayUploadModal);
UploadModalExitBtn.addEventListener("click", hideUploadModal);

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

// add media photo modal
let addMediaPhotoModalBtn = document.getElementById("addMediaPhotoModalBtn");
let addMediaPhotoModal = document.getElementById("addMediaPhotoModal");
let addMediaPhotoModalExitBtn = document.getElementById("addMediaPhotoModalExitBtn");

function displayAddMediaPhotoModal(e) {
  if (addMediaPhotoModal.classList.contains("hideModal")) {
    e.preventDefault()
    hideAddMediaFirstModal();
    addMediaPhotoModal.classList.remove("hideModal");
    addMediaPhotoModal.classList.add("displayModal");
  }
}

function hideAddMediaPhotoModal() {
  addMediaPhotoModal.classList.remove("displayModal");
  addMediaPhotoModal.classList.add("hideModal");
}

addMediaPhotoModalBtn.addEventListener("click", displayAddMediaPhotoModal);
addMediaPhotoModalExitBtn.addEventListener("click", hideAddMediaPhotoModal);

// add media video modal
let addMediaVideoModalBtn = document.getElementById("addMediaVideoModalBtn");
let addMediaVideoModal = document.getElementById("addMediaVideoModal");
let addMediaVideoModalExitBtn = document.getElementById("addMediaVideoModalExitBtn");

function displayAddMediaVideoModal(e) {
  if (addMediaVideoModal.classList.contains("hideModal")) {
    e.preventDefault()
    hideAddMediaFirstModal();
    addMediaVideoModal.classList.remove("hideModal");
    addMediaVideoModal.classList.add("displayModal");
  }
}

function hideAddMediaVideoModal() {
  addMediaVideoModal.classList.remove("displayModal");
  addMediaVideoModal.classList.add("hideModal");
}

addMediaVideoModalBtn.addEventListener("click", displayAddMediaVideoModal);
addMediaVideoModalExitBtn.addEventListener("click", hideAddMediaVideoModal);