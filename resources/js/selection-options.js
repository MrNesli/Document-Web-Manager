import { setCookie } from "./cookies.js";

const newCategorySection = document.getElementById('category-select');
const newCategoryCheckbox = document.getElementById('new-category');
const deleteAllCheckbox = document.getElementById('delete-all');
const selectionForm = document.getElementById('selection-form');

initEvents();

function initEvents() {
  selectionForm.addEventListener('submit', () => {
    setCookie('selected_items', '', 0);
  });

  deleteAllCheckbox.addEventListener('change', () => {
    newCategoryCheckbox.disabled = deleteAllCheckbox.checked ? true : false;
  });

  newCategoryCheckbox.addEventListener('change', () => {
    deleteAllCheckbox.disabled = newCategoryCheckbox.checked ? true : false;

    (newCategoryCheckbox.checked) ? newCategorySection.classList.remove('hidden') : newCategorySection.classList.add('hidden');
  });
}
