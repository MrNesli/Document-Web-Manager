const deleteIcons = document.querySelectorAll('.delete-icon');

initEvents();

function initEvents() {
  deleteIcons.forEach((icon) => {
    icon.addEventListener('click', onDeleteIconClick);
  });
}

function onDeleteIconClick() {
  const itemId = this.getAttribute('data-item-id');
  let confirmationDialog;

  if (itemId) {
    confirmationDialog = document.querySelector(`.confirmation-dialog[data-item-id="${itemId}"]`);
  }
  else {
    confirmationDialog = document.querySelector('.confirmation-dialog');
  }

  confirmationDialog.classList.toggle('hidden');
}
