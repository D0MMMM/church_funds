<?php
session_start();
include "../config/connect.php";

if(isset($_SESSION['id']) && isset($_SESSION['username'])){

// Get treasurer details
$sql = "SELECT name, image_path FROM treasurer WHERE id = 1";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $imagePath = $row["image_path"];
}

// Call the stored procedure to get total funds
$stmt = $connection->prepare("CALL GetTotalFunds(@total_funds)");
$stmt->execute();
$stmt->close();

// Get the result of the stored procedure
$result = $connection->query("SELECT @total_funds as total_funds");
$row = $result->fetch_assoc();
$total_funds = $row['total_funds'];
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
    <div class="report-container">
      <h2 class="balance-title"><span>Balance</span> Report</h2>
      <div class="total-funds-container">
        <h3>TOTAL FUNDS</h3>
        <p><?php echo "₱" . number_format($total_funds, 2); ?></p>
      </div>
        <div class="expenses-balance-container">
          <h2>Total Expenses</h2>
            <?php
            // Aggregate expenses from expenses table
              $query = "SELECT SUM(expenses_amount) as total_expenses from `expenses`";
              $stmt = $connection->prepare($query);
              $stmt->execute();
              $result = $stmt->get_result();
              $row = $result->fetch_assoc();
              $total_expenses = $row['total_expenses'];
            ?>
          <hr style="background-color:#fff;outline:none;">
          <h3><span>Total Expenses: </span><?php echo "₱" . number_format($total_expenses, 2); ?></h3>
        </div>
        <div class="funds-balance-container">
          <h2>Current Balance</h2>
            <?php
                $balance = $total_funds - $total_expenses;
            ?>
          <hr style="background-color:#fff;outline:none;">
          <h3><span>Balance: </span><?php echo "₱" . number_format($balance, 2); ?></h3>
        </div>
      <a href="admin.php" class="view-dashboard-btn"><button>View Dashboard</button></a>
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