<?php
include 'config/connect.php'; 

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";

  $result = $connection->query($query);

  if($result->num_rows == 1){
    header("Location: views/admin.php");
    exit();
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Church|Funds</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="bg-img"></div>
  <div class="wrapper-login">
    <img class="img-logo" src="assets/img/logo.png" alt="img-logo">
    <div class="intro-wrapper">
      <p><span>Get started</span>
       with Church funds management system
      </p>
    </div>
    <div class="admin-container">
      <div class="login-form">
          <form action="backend/login.php" method="post">
          <h2><span>ADMIN</span> Log in</h2>
          <?php if(isset($_GET['error'])){?>
            <p class="error"><?php echo $_GET['error']; ?></p>
          <?php }?>
            <div class="form-group">
              <label for="username">Username: </label>
              <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="password">Password: </label>
              <input type="password" name="password" id="password" placeholder="Password">
            </div>
          <div class="form-group">
            <button type="submit" name="submit">Sign in</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <script src="assets/js/script.js"></script>
</body>
</html>