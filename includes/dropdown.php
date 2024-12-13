<div class="container">
  <h1><span>Admin</span> Panel</h1>
  <span>
  <ul>
      <li class="dropdown-container">
          <a class="dropdown-toggle">Admin</a>
          <ul class="dropdown">
              <li><a href="../views/account_management.php"><i class="fa-solid fa-user"></i> Account</a></li>
              <li><a href="../logout.php" onclick="return confirm('Are you sure to logout?');"><i class="fa-solid fa-right-from-bracket"></i> Log out</a></li>
          </ul>
      </li>
  </ul>
</span>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var dropdownToggle = document.querySelector('.dropdown-toggle');
    var dropdown = document.querySelector('.dropdown');

    dropdownToggle.addEventListener('click', function() {
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function(event) {
      if (!event.target.matches('.dropdown-toggle')) {
        if (dropdown.style.display === 'block') {
          dropdown.style.display = 'none';
        }
      }
    });
  });
</script>