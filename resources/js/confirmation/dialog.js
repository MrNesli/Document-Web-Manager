const confirmationDialogs = document.querySelectorAll('.confirmation-dialog');

initEvents();

function initEvents() {
  confirmationDialogs.forEach((dialog) => {
    const cancelBtn = dialog.querySelector('.cancel-btn');
    cancelBtn.addEventListener('click', onCancelButtonClick);
  });
}

function onCancelButtonClick() {
  const dialog = this.closest('.confirmation-dialog');
  dialog.classList.toggle('hidden');
}
