const newButton = document.getElementById('new-button');
const newButtonForm = newButton.closest('form');

window.addEventListener('DOMContentLoaded', () => {
  newButton.addEventListener('click', () => {
    newButtonForm.submit();
  });
});
