// Get the modals
var addCategoryModal = document.getElementById("addCategoryModal");
var viewCategoriesModal = document.getElementById("viewCategoriesModal");

// Get the buttons that open the modals
var addCategoryBtn = document.getElementById("addCategoryBtn");
var viewCategoriesBtn = document.getElementById("viewCategoriesBtn");

// Get the <span> elements that close the modals
var closeBtns = document.getElementsByClassName("close");

// When the user clicks the button, open the modal 
addCategoryBtn.onclick = function() {
  addCategoryModal.style.display = "block";
}

viewCategoriesBtn.onclick = function() {
  viewCategoriesModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
for (var i = 0; i < closeBtns.length; i++) {
  closeBtns[i].onclick = function() {
    addCategoryModal.style.display = "none";
    viewCategoriesModal.style.display = "none";
  }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == addCategoryModal) {
    addCategoryModal.style.display = "none";
  }
  if (event.target == viewCategoriesModal) {
    viewCategoriesModal.style.display = "none";
  }
}