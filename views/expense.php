<?php
session_start();
include "../config/connect.php";
include "../backend/expense.php";
include "../backend/category.php";

// Fetch total funds from the view
$query = "SELECT total_funds FROM total_funds_view";
$stmt = $connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_funds = $row['total_funds'];

if(isset($_SESSION['id']) && isset($_SESSION['username'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Church | Funds</title>

  <link rel="stylesheet" href="../assets/fontawesome-free-6.5.2-web/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <?php include "../includes/sidebar.php";?>
  <div class="main-content">
    <?php include "../includes/dropdown.php";?>

    <div class="expenses-container">
      <h2>EXPENSES</h2>
      <?php if(isset($_SESSION['message'])): ?>
        <div class="alert <?php echo strpos($_SESSION['message'], 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>">
          <?php echo $_SESSION['message']; ?>
        </div>
        <script>
          setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
          }, 1500);
        </script>
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
      <form action="" method="post" class="expenses-form">
        <input type="text" name="expenses_name" placeholder="Enter expenses name" required>
        <input type="number" name="expenses_amount" placeholder="Enter amount" required>
        <input type="date" name="expenses_date" required>
        <input type="text" name="spender_name" placeholder="Enter spender name" required>
        <select name="category_id" required class="category-select">
          <option value="" disabled selected>Select category</option>
          <?php
          $categories_query = mysqli_query($connection, "SELECT * FROM categories");
          while($category = mysqli_fetch_assoc($categories_query)){
              echo '<option value="'.$category['id'].'">'.$category['category_name'].'</option>';
          }
          ?>
        </select>
        <button type="button" id="addCategoryBtn" class="add-category-btn"><i class="fa-solid fa-plus"></i> Add Category</button>
        <button type="button" id="viewCategoriesBtn" class="view-categories-btn"><i class="fa-solid fa-eye"></i> View Categories</button>
        <button type="submit" name="add_expenses" class="add-expense-btn" <?php if($total_funds <= 0) echo 'disabled'; ?>><i class="fa-solid fa-plus"></i> Add expense</button>
      </form>

      <!-- Modal for adding category -->
      <div id="addCategoryModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2 style="text-transform: uppercase;">Add Category</h2>
          <form action="" method="post">
            <input type="text" name="category_name" placeholder="Enter category name" required style="padding: .5rem; font-size: 1rem;">
            <button type="submit" name="add_category" class="add-category"><i class="fa-solid fa-plus"></i> Add Category</button>
          </form>
        </div>
      </div>
      
      <!-- Modal for viewing categories -->
      <div id="viewCategoriesModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2 style="text-transform: uppercase;">Categories</h2>
          <ul style="list-style: none; display: flex; flex-direction: column;">
            <?php
            $categories_query = mysqli_query($connection, "SELECT * FROM categories");
            while($category = mysqli_fetch_assoc($categories_query)){
                echo '<li>'.$category['category_name'].' <a href="expense.php?delete_category='.$category['id'].'" style="color: red;" class="delete-category-btn" onclick="return confirm(\'Are you sure you want to delete this category?\');"><i class="fas fa-trash"></i></a></li>';
            }
            ?>
          </ul>
        </div>
      </div>

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

      <div class="table-container">
        <table>
          <thead>
            <th>Expenses name</th>
            <th>Expenses amount</th>
            <th>Date</th>
            <th>Spender Name</th>
            <th>Category</th>
            <th>Balance</th>
            <th>Action</th>
          </thead>

          <tbody>
          <?php
          // * Wildcards
          // * Joints
          // * Aggregate Functions (OPTIONAL)
          // * Union (OPTIONAL)
          // * Views (OPTIONAL)
          // * Sub-Queries (OPTIONAL)
          // * Query Optimization
          
            $search_query = "WHERE 1";
            if(isset($_GET['search_name']) && !empty($_GET['search_name'])){
                $search_name = mysqli_real_escape_string($connection, $_GET['search_name']);
                $search_query .= " AND spender_name LIKE '%$search_name%'";
            }
            // Search by year
            if(isset($_GET['search_year']) && !empty($_GET['search_year'])){
              $search_year = mysqli_real_escape_string($connection, $_GET['search_year']);
              $search_query .= " AND YEAR(expenses_date) = '$search_year'";
            }
            $select_expenses = mysqli_query($connection, "
              SELECT expenses.*, 
              categories.category_name, (SELECT total_funds FROM total_funds_view) - (SELECT SUM(expenses_amount) FROM expenses) as balance 
            FROM `expenses` 
            LEFT JOIN `categories` ON expenses.category_id = categories.id 
            $search_query
            ORDER BY expenses.id DESC
            ");
           if(mysqli_num_rows($select_expenses) > 0){
              while($row = mysqli_fetch_assoc($select_expenses)){
          ?>

          <tr>
            <td><?php echo $row['expenses_name']; ?></td>
            <td><?php echo "₱" . number_format($row['expenses_amount'], 2); ?></td>
            <td><?php echo $row['expenses_date']; ?></td>
            <td><?php echo $row['spender_name'];?></td>
            <td><?php echo $row['category_name'];?></td>
            <td><?php echo "₱" . number_format($row['balance'], 2); ?></td>
            <td>
                <a href="expense.php?delete_expenses=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete the data?');"><i class="fas fa-trash"></i></a>
                <a href="expense.php?edit=<?php echo $row['id']; ?>" class="edit-btn"> <i class="fas fa-edit"></i></a>
            </td>
          </tr>

          <?php
            };    
            }else{
                echo "<div class='empty'>No expenses added</div>";
            };
          ?>
          </tbody>
        </table>
      </div>
   </div>
   <?php include '../includes/edit_expense.php';?>
  </div>

  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/modal.js"></script>
  <script>
    document.querySelector('#close-edit').onclick = () =>{
    document.querySelector('.edit-expenses-container').style.display = 'none';
    window.location.href = 'expense.php';
    };
  </script>
</body>
</html>

<?php
}else{
  header("Location: ../index.php");
  exit();
}
?>