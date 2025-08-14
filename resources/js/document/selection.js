import { setCookie, getCookie, removeCookie } from "../cookies.js";
import { isNull } from "../utils.js";

const selectionBtns = document.querySelectorAll('.selection-btn');

window.addEventListener('DOMContentLoaded', () => {
  if (selectionButtonsExist()) {
    initSelectionButtonsClickEvent();
    updateSelectionButtonsState();
    createSelectionComponent();
  }
});

function selectionButtonsExist() {
  return selectionBtns.length > 0;
}


function initSelectionButtonsClickEvent() {
  selectionBtns.forEach((button) => { button.addEventListener('click', onSelectionButtonClick); });
}

function updateSelectionButtonsState() {
  const selectedItems = getCookie('selected_items');

  if (!isNull(selectedItems)) {
    selectAllSelectionButtons();
  }
  else {
    deselectAllSelectionButtons();
  }
}

function createSelectionComponent() {
  refreshSelectionComponent();
}

async function refreshSelectionComponent() {
  removeSelectionComponentIfExists();
  appendToBody(await fetchSelectionComponent());
  initDeselectButtonClickEvent();
}

function selectAllSelectionButtons() {
  const selectedItems = getCookie('selected_items');

  selectionBtns.forEach((button) => {
    const documentId = button.getAttribute('data-document-id');
    if (selectedItems.indexOf(documentId) != -1) {
      selectButton(button);
    }
  });
}

function deselectAllSelectionButtons() {
  selectionBtns.forEach((button) => { deselectButton(button); });
}

function onSelectionButtonClick() {
  if (isSelected(this)) {
    removeSelectedDocumentFromCookies(this);
    deselectButton(this);
  }
  else {
    appendSelectedDocumentToCookies(this);
    selectButton(this);
  }

  refreshSelectionComponent();
}

function isSelected(button) {
  return button.getAttribute('data-selected') == 'true' ? true : false;
}

function removeSelectionComponentIfExists() {
  const selectionDialog = document.getElementById('selection-dialog');
  if (selectionDialog) selectionDialog.remove();
}

function appendToBody(component) {
  if (isNull(component)) return;
  document.body.insertAdjacentHTML('beforeend', component);
}

async function fetchSelectionComponent() {
  const componentData = retrieveSelectionComponentDataFromCookies();

  if (isNull(componentData)) return;

  const componentUrl = `/components/selection?` +
                       `count=${componentData.count}&` +
                       `selected-items=${componentData.selectedItems}`;

  return await fetch(componentUrl).then((response) => response.text());
}

function deselectButton(selectionButton) {
  selectionButton.setAttribute('data-selected', 'false');
  selectionButton.setAttribute('class', '');
}

function selectButton(selectionButton) {
  selectionButton.setAttribute('data-selected', 'true');
  selectionButton.setAttribute('class', 'fill-blue-500 stroke-2 stroke-white');
}

function initDeselectButtonClickEvent() {
  const deselectBtn = document.getElementById('unselect-btn');
  if (deselectBtn) {
    deselectBtn.addEventListener('click', onDeselectButtonClick);
  }
}

function onDeselectButtonClick() {
  removeCookie('selected_items');
  updateSelectionButtonsState();
  removeSelectionComponentIfExists();
}

function appendSelectedDocumentToCookies(selectionButton) {
  const documentId = selectionButton.getAttribute('data-document-id');
  const selectedItems = getCookie('selected_items');

  if (!isNull(selectedItems)) {
    const updatedCookie = selectedItems + `,${documentId}`;
    setCookie('selected_items', updatedCookie, 30);
  }
  else {
    setCookie('selected_items', documentId, 30);
  }
}

function removeSelectedDocumentFromCookies(selectionButton) {
  const documentId = selectionButton.getAttribute('data-document-id');

  // "selected_items=1,2,3,4"
  const selectedItems = getCookie('selected_items');

  if (!isNull(selectedItems)) {
    const items = selectedItems.split(',');
    const indexToDelete = items.indexOf(documentId);

    if (indexToDelete != -1) {
      items.splice(indexToDelete, 1);
      const updatedCookie = items.join(',');
      setCookie('selected_items', updatedCookie, 30);
    }
  }
  else if (selectedItems === '') {
    removeCookie('selected_items');
  }
}

function retrieveSelectionComponentDataFromCookies() {
  const selectedItems = getCookie('selected_items');
  if (!isNull(selectedItems)) {
    const items = selectedItems.split(',');
    const count = items.length;

    return {
      count: count,
      selectedItems: selectedItems,
    };
  }
}
