const infoBlock = document.querySelector('.info-block');
const infoBtn = document.querySelector('.info-btn');

const documentNameTextArea = document.getElementById('new-title');
const documentFilename = document.querySelector('.filename');

const newFileInput = document.getElementById('doc-file');
const newCategoryField = document.getElementById('new-category');

const modificationLabel = document.querySelector('.modif-label');
const modifyBtn = document.getElementById('modify-btn');
const editBtns = document.getElementById('edit-btns');
const uploadBtn = document.getElementById('upload-btn');
const actionBtns = document.getElementById('action-btns');
const cancelBtn = document.getElementById('cancel-btn');

let initDocName = documentNameTextArea.textContent;
let initFileName = documentFilename.textContent;

initEvents();

function initEvents() {
  uploadBtn.addEventListener('click', onUploadClick);
  modifyBtn.addEventListener('click', setEditMode);
  cancelBtn.addEventListener('click', exitEditMode);

  infoBtn.addEventListener('click', () => { infoBlock.classList.toggle('collapsed'); });

  newFileInput.addEventListener('change', onNewFileChange);
  applyOnTextInputEvent(documentNameTextArea);
}

function setEditMode() {
  documentNameTextArea.disabled = false;
  setDocumentTextAreaStylesOnEdit();
  updateElementsVisibilityOnEdit();
}

function exitEditMode() {
  documentNameTextArea.disabled = true;
  resetDocumentTextAreaStyles();
  resetDocumentFields();
  resetElementsVisibility();
}

/*
 * Updates document's file name when a new file was uploaded
 *
 * */
function onNewFileChange() {
  documentFilename.textContent = this.files[0].name;
}

function onUploadClick() {
  newFileInput.click();
}

/*
 * Handles input event of TextArea type elements.
 *
 * Automatically adjusts element's scroll height to avoid having
 * a scrollbar
 *
 * @param {HTMLTextAreaElement} text_el
 *
 * */
function applyOnTextInputEvent(textAreaEl) {
  textAreaEl.style.height = textAreaEl.scrollHeight + "px";

  textAreaEl.addEventListener('input', () => {
    textAreaEl.style.height = "auto";
    textAreaEl.style.height = textAreaEl.scrollHeight + "px";
  });
}

function setDocumentTextAreaStylesOnEdit() {
  // Update textarea styles
  removeClassIfPresent(documentNameTextArea, 'border-none');
  addClassIfNotPresent(documentNameTextArea, 'border');
  addClassIfNotPresent(documentNameTextArea, 'border-black');
}

function updateElementsVisibilityOnEdit() {
  // Update visibility of elements used for modification
  removeClassIfPresent(modificationLabel, 'hidden');
  removeClassIfPresent(editBtns, 'hidden');
  removeClassIfPresent(uploadBtn, 'hidden');
  removeClassIfPresent(newCategoryField, 'hidden');
  addClassIfNotPresent(actionBtns, 'hidden');
}

function resetDocumentTextAreaStyles() {
  // Update textarea styles
  addClassIfNotPresent(documentNameTextArea, 'border-none');
  removeClassIfPresent(documentNameTextArea, 'border');
  removeClassIfPresent(documentNameTextArea, 'border-black');
}

function resetElementsVisibility() {
  // Update visibility of elements used for modification
  addClassIfNotPresent(editBtns, 'hidden');
  addClassIfNotPresent(uploadBtn, 'hidden');
  addClassIfNotPresent(modificationLabel, 'hidden');
  addClassIfNotPresent(newCategoryField, 'hidden');
  removeClassIfPresent(actionBtns, 'hidden');
}

function resetDocumentFields() {
  // Reinitialize document name, document file name, and remove newly uploaded file
  documentNameTextArea.value = initDocName;
  documentFilename.textContent = initFileName;
  newFileInput.value = '';
}

function removeClassIfPresent(elem, token) {
  if (elem.classList.contains(token))
    elem.classList.remove(token);
}

function addClassIfNotPresent(elem, token) {
  if (!elem.classList.contains(token))
    elem.classList.add(token);
}
