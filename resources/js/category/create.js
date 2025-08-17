const selectImageInput = document.getElementById('image');
const selectImageBtn = document.getElementById('image-btn');

initEvents();

function initEvents() {
  selectImageBtn.addEventListener('click', onSelectImageButtonClick);
  selectImageInput.addEventListener('change', onSelectImageInputChange);
}

function onSelectImageButtonClick() {
  selectImageInput.click();
}

function onSelectImageInputChange() {
  updateSelectImageButtonText();
}

function updateSelectImageButtonText() {
  selectImageBtn.textContent = `Image selectionnée`;
}
