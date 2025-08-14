const arrowBtn = document.querySelector('.arrow-btn');

initArrowButtonClickEvent();

function initArrowButtonClickEvent() {
  arrowBtn.addEventListener('click', onArrowButtonClick);
}

function onArrowButtonClick() {
  const form = this.closest('form');
  form.submit();
}
