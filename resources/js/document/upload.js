import { isNull } from "../utils.js";

const selectDocumentsInput = document.getElementById('documents');
const selectDocumentsBtn = document.getElementById('documents-btn');

const fileContainer = document.getElementById('file-container');

function initEvents() {
  selectDocumentsBtn.addEventListener('click', onSelectDocumentsButtonClick);
  selectDocumentsInput.addEventListener('change', onSelectDocumentsInputChange);
}

function onSelectDocumentsButtonClick() {
  selectDocumentsInput.click();
}

function onSelectDocumentsInputChange() {
  updateSelectFilesButtonText();
  createCollapsibleFileLabels();
}

function updateSelectFilesButtonText() {
  const files = selectDocumentsInput.files;
  selectDocumentsBtn.textContent = `${files.length} fichier${files.length > 0 ? 's' : ''} selectionné`;
}

function createCollapsibleFileLabels() {
  emptyFileContainer();
  fetchAndInsertCollapsibleFileLabels();
}

function emptyFileContainer() {
  fileContainer.innerHTML = '';
}

async function fetchAndInsertCollapsibleFileLabels() {
  const files = selectDocumentsInput.files;
  const categoryId = getCurrentCategoryId();

  if (!categoryId) return;

  if (files.length > 1) {
    for (let i = 0; i < files.length; i++) {
      const documentTitle = files[i].name.split('.')[0];
      const componentData = {
        index: i,
        documentTitle: documentTitle,
        categoryId: categoryId,
      };

      await fetchAndInsertCollapsibleFileLabel(componentData);
    }

    initCollapsibleFileLabelsClickEvent();
    removeSingleFileContainerIfExists();
  }
}

function getCurrentCategoryId() {
  // Query blade-rendered select element with a selected option which contains the current category id
  let categoryId = document.body.querySelector('select option:checked');

  if (!categoryId) {
    console.log('Failed to retrieve current category ID');
    return null;
  }
  else {
    return Number(categoryId.value);
  }
}

async function fetchAndInsertCollapsibleFileLabel(data) {
  if (isNull(data.index) || isNull(data.documentTitle) || isNull(data.categoryId)) {
    console.log('Component data is incomplete.');
    return;
  }

  const componentUrl = `/components/uploaded-document-collapsible?` +
                       `index=${data.index}&` +
                       `document-title=${data.documentTitle}&` +
                       `category-id=${data.categoryId}`;

  const collapsibleFileLabelComponent = await fetch(componentUrl).then((response) => response.text());
  appendToFileContainer(collapsibleFileLabelComponent);
}

function appendToFileContainer(component) {
  fileContainer.insertAdjacentHTML('beforeend', component);
}

function initCollapsibleFileLabelsClickEvent() {
  const collapsibleFileLabels = document.querySelectorAll('.file-btn');
  collapsibleFileLabels.forEach((label) => { label.addEventListener('click', onCollapsibleFileLabelClick); });
}

function removeSingleFileContainerIfExists() {
  const singleFileContainer = document.getElementById('single-file-container');
  if (singleFileContainer) singleFileContainer.remove();
}

/*
 * Collapses uploaded document's information (e.g. Document name, category)
 *
 * */
function onCollapsibleFileLabelClick() {
  toggleCollapse(this)
  rotateIcon(this);
}

function toggleCollapse(collapsible) {
  if (!collapsible) return;

  const fileId = collapsible.getAttribute('data-file-id');
  const collapsibleBlock = document.querySelector(`.collapsible-block-${fileId}`);

  collapsibleBlock.classList.toggle('hidden');
}

function rotateIcon(collapsible) {
  if (!collapsible) return;

  const icon = collapsible.querySelector('.dropdown-icon');
  if (!icon) return;

  icon.classList.toggle('rotate-180');
}

initEvents();
