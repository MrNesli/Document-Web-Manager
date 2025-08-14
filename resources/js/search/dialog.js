const searchButton = document.getElementById('search-button');
const searchIcon = document.getElementById('search-icon');
const searchDialog = document.getElementById('search-dialog');
const closeDialogButton = document.getElementById('close-button');
const searchInput = document.querySelector('input[name="search_name"]');

closeDialogButton.addEventListener('click', () => {
  searchDialog.classList.toggle('hidden');
  searchIcon.style.stroke = "#989A9D";
});

searchButton.addEventListener('click', () => {
  searchDialog.classList.toggle('hidden');
  searchInput.focus();
  searchIcon.style.stroke = "url(#gradient)";
});
