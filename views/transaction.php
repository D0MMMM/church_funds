<?php
session_start();
include "../config/connect.php";
include "../backend/funds.php";

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

    <div class="funds-container">
      <h2>FINANCIAL TRANSACTIONS</h2>
      <?php if(isset($_SESSION['message'])): ?>
        <div class="alert <?php echo strpos($_SESSION['message'], 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>">
          <?php echo $_SESSION['message']; ?>
        </div>
        <script>
          setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
          }, 1500); // Hide the message after 1.5 seconds
        </script>
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>

      <!-- Search Filter Form for wildcards -->
    <form action="" method="get" class="search-form">
        <input type="text" name="search_name" placeholder="Search by name" value="<?php if(isset($_GET['search_name'])) echo $_GET['search_name']; ?>">
        <select name="search_year" style="padding: .5em;">
            <option value="">Select Year</option>
            <?php
            for($year = 2020; $year <= date('Y'); $year++) {
                $selected = (isset($_GET['search_year']) && $_GET['search_year'] == $year) ? 'selected' : '';
                echo "<option value='$year' $selected>$year</option>";
            }
            ?>
        </select>
        <i class="fa-solid fa-search"></i>
    </form>
      
      <div class="table-container" style="min-height:400px;">
        <table>
          <thead>
            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Name</th>
            <!-- <th>Action</th> -->
          </thead>

          <tbody>
            <!-- Wild cards -->
            <?php
            // Modify the search query section
            $search_condition = "";
            if(isset($_GET['search_name']) && !empty($_GET['search_name'])){
                $search_name = mysqli_real_escape_string($connection, $_GET['search_name']);
                $search_condition = " WHERE name LIKE '%$search_name%'";
            }
          // Search by year
            if(isset($_GET['search_year']) && !empty($_GET['search_year'])){
                $search_year = mysqli_real_escape_string($connection, $_GET['search_year']);
                $search_condition .= " AND YEAR(date) = '$search_year'";
            }

          // Updated UNION query with search functionality
          $union_query = "
              SELECT * FROM (
                  SELECT 
                      'Fund' as type,
                      amount as value,
                      date,
                      depositor_name as name,
                      id,
                      'funds' as source
                  FROM funds
                  UNION ALL
                  SELECT 
                      'Expense' as type,
                      expenses_amount as value,
                      expenses_date as date,
                      spender_name as name,
                      id,
                      'expenses' as source
                  FROM expenses
              ) as combined_results
              " . ($search_condition ? $search_condition : "") . "
              ORDER BY date DESC
          ";

          $result = mysqli_query($connection, $union_query);
          
          if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_assoc($result)){
          ?>

          <tr>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo "₱" . number_format($row['value'], 2); ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['name'];?></td>
          </tr>

          <?php
            };    
            }else{
                echo "<tr><td colspan='5' class='empty'>No transactions found</td></tr>";
            };
          ?>
          </tbody>
        </table>
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