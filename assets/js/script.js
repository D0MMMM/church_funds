//NavBar area
let btn = document.querySelector('#btn');
let sidebar = document.querySelector('.sidebar');

btn.onclick = function () {
  sidebar.classList.toggle('active');
};

function toggleEdit() {
  var form = document.getElementById('editForm');
  if (form.style.display === 'none') {
      form.style.display = 'block';
  } else {
      form.style.display = 'none';
  }
};
