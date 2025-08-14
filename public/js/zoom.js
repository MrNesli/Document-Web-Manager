let images = document.querySelectorAll('.document-img');
let closeButtons = document.querySelectorAll('.image-zoom-close');

function onImageClick() {
    let container = this.closest('div');
    let zoom = container.querySelector('.image-zoom');
    zoom.classList.remove('hidden');
}

function onCloseButtonClick() {
    let zoom = this.closest('.image-zoom');
    if (!zoom.classList.contains('hidden')) {
        zoom.classList.add('hidden');
    }
}

closeButtons.forEach((button) => {
    button.addEventListener('click', onCloseButtonClick);
});

images.forEach((image) => {
    image.addEventListener('click', onImageClick);
})