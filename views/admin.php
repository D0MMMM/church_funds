<?php
session_start();
include "../config/connect.php";
include "../backend/admin.php";
if(isset($_SESSION['id']) && isset($_SESSION['username'])){

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Church|Funds</title>

  <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <?php include "../includes/sidebar.php";?>
  <div class="main-content">
    <?php include "../includes/dropdown.php";?>
    <div class="dashboard-container">
      <h2>Dashboard</h2>
      <div class="funds-wrapper">
        <span>Church Funds</span>
        <hr style="border:1px solid #000; margin-top:10px;">
        <a href="funds.php"><button>View</button></a>
      </div>
      <div class="expenses-wrapper">
        <span>Church Expenses</span>
        <hr style="border:1px solid #eee; margin-top:10px;">
        <a href="expense.php"><button>View</button></a>
      </div>
    </div>
  </div>

  <script src="../assets/js/script.js"></script>
</body>
</html>

<?php
}else{
  header("Location: index.php");
  exit();
}
?>