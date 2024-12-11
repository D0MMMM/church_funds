<?php 
include "../config/connect.php";
include "../backend/admin.php";
?>

<div class="sidebar">
    <div class="top">
      
      <div class="logo">
        <i class="fa-solid fa-church"></i>
          <span>Church | Funds</span>
      </div>
      <i class="fa-solid fa-bars" id="btn"></i>
    </div>
    <div class="user">
        <img src="<?= $row['image_path']; ?>" alt="me" class="logo-img">
        <div>
            <p class="bold">
              <?= $row['name']; ?>
                <a href="#" style="font-size:.75rem; color:#fff;" onclick="toggleEdit()">
                    <i class="fa-solid fa-pen"></i>
                </a>
            </p>
            <p>Treasurer</p>
        </div>
    </div>
    <div id="editForm" style="display: none;">
        <form method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">

            <label for="image">Profile Image:</label>
            <input type="file" id="image" name="image">

            <button type="submit">Save</button>
        </form>
    </div>
    <ul>
        <li>
          <a href="../views/admin.php">
            <i class="fa-solid fa-gauge"></i>
            <span class="nav-item">Dashboard</span>
          </a>
          <span class="tooltip">Dashboard</span>
        </li>
        <li>
          <a href="../views/funds.php">
          <i class="fa-solid fa-money-bill-transfer"></i>
            <span class="nav-item">Funds</span>
          </a>
          <span class="tooltip">Funds</span>
        </li>
        <li>
          <a href="../views/expense.php">
          <i class="fa-solid fa-cart-plus"></i>
            <span class="nav-item">Expenses</span>
          </a>
          <span class="tooltip">Expenses</span>
        </li>
        <li>
          <a href="../views/transaction.php">
          <i class="fa-solid fa-clipboard"></i>
            <span class="nav-item">Transaction</span>
          </a>
          <span class="tooltip">Transaction</span>
        </li>
        <li>
          <a href="../views/manage.php">
          <i class="fa-solid fa-list-check"></i>
            <span class="nav-item">Report</span>
          </a>
          <span class="tooltip">Report</span>
        </li>
        <li>
          <a href="../logout.php" onclick="return confirm('Are you sure to logout?');">
          <i class="fa-solid fa-right-from-bracket"></i>
            <span class="nav-item">Logout</span>
          </a>
          <span class="tooltip">Logout</span>
        </li>
    </ul>
</div>