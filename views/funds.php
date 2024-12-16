<?php
session_start();
include "../config/connect.php";
include "../backend/funds.php";



if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church|Funds</title>

    <link rel="stylesheet" href="../assets/fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
  </head>

  <body>
    <?php include "../includes/sidebar.php"; ?>
    <div class="main-content">
      <?php include "../includes/dropdown.php"; ?>

      <div class="funds-container">
        <h2>FUNDS</h2>
        <?php if (isset($_SESSION['message'])): ?>
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
        <form action="" method="post" class="funds-form">
          <input type="number" name="amount" placeholder="Enter amount" required>
          <input type="date" name="date" required>
          <input type="text" name="depositor_name" placeholder="Enter collector name" required>
          <button type="submit" name="add_funds"><i class="fa-solid fa-plus"></i> Add funds</button>
        </form>

        <!-- Search Filter Form for wildcards -->
        <form action="" method="get" class="search-form">
          <input type="text" name="search_name" placeholder="Search by name" value="<?php if (isset($_GET['search_name'])) echo $_GET['search_name']; ?>">
          <select name="search_year" style="padding: .5em;">
            <option value="">Select Year</option>
            <?php
            for ($year = 2020; $year <= date('Y'); $year++) {
              $selected = (isset($_GET['search_year']) && $_GET['search_year'] == $year) ? 'selected' : '';
              echo "<option value='$year' $selected>$year</option>";
            }
            ?>
          </select>
          <button type="submit"><i class="fa-solid fa-search"></i></button>
        </form>

        <div class="table-container">
          <table>
            <thead>
              <th style="text-align:center;">Amount</th>
              <th style="text-align:center;">Date stored</th>
              <th style="text-align:center;">Collector Name</th>
              <th style="text-align:center;">Action</th>
            </thead>

            <tbody>
              <!-- Wildcards -->
              <?php
              // Search query with both year and name filters
              $search_query = "WHERE 1";

              // Search by name
              if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
                $search_name = mysqli_real_escape_string($connection, $_GET['search_name']);
                $search_query .= " AND depositor_name LIKE '%$search_name%'";
              }

              // Search by year
              if (isset($_GET['search_year']) && !empty($_GET['search_year'])) {
                $search_year = mysqli_real_escape_string($connection, $_GET['search_year']);
                $search_query .= " AND YEAR(date) = '$search_year'";
              }

              $select_funds = mysqli_query($connection, "
              SELECT * FROM `funds`
              $search_query
              ORDER BY id DESC
          ");
              if (mysqli_num_rows($select_funds) > 0) {
                while ($row = mysqli_fetch_assoc($select_funds)) {
              ?>

                  <tr>
                    <td style="text-align:center;"><?php echo "₱" . number_format($row['amount'], 2); ?></td>
                    <td style="text-align:center;"><?php echo $row['date']; ?></td>
                    <td style="text-align:center;"><?php echo $row['depositor_name']; ?></td>
                    <td style="text-align:center;">
                      <a href="funds.php?delete_funds=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete the data?');"><i class="fas fa-trash"></i></a>
                      <a href="funds.php?edit=<?php echo $row['id']; ?>" class="edit-btn"> <i class="fas fa-edit"></i></a>
                    </td>
                  </tr>

              <?php
                };
              } else {
                echo "<div class='empty'>No funds found</div>";
              };
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php include '../includes/edit_funds.php'; ?>
    </div>

    <script src="../assets/js/script.js"></script>
    <script>
      document.querySelector('#close-funds-edit').onclick = () => {
        document.querySelector('.edit-funds-container').style.display = 'none';
        window.location.href = 'funds.php';
      };
    </script>
  </body>

  </html>
<?php
} else {
  header("Location: index.php");
  exit();
}
?>