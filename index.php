<?php
session_start();
include 'config/connect.php'; 

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])){
  $username = mysqli_real_escape_string($connection, $_POST['username']);
  $password = mysqli_real_escape_string($connection, $_POST['password']);

  $query = "SELECT * FROM users WHERE username='$username'";
  $result = $connection->query($query);

  if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    if(password_verify($password, $row['password'])){
      // Set session variables
      $_SESSION['id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      header("Location: views/admin.php");
      exit();
    } else {
      $error = "Invalid username or password";
    }
  } else {
    $error = "Invalid username or password";
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])){
  $username = mysqli_real_escape_string($connection, $_POST['reg_username']);
  $password = mysqli_real_escape_string($connection, $_POST['reg_password']);
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
  if($connection->query($query) === TRUE){
    $success = "Registration successful. Please log in.";
  } else {
    $error = "Error: " . $query . "<br>" . $connection->error;
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
  <style>
    .form-group.center {
      text-align: center;
    }
    .form-group.center a {
      color: #000;
      text-decoration: none;
    }
    .message {
      text-align: center;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      position: inherit;
    }
    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
  </style>
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
        <form action="" method="post">
          <h2><span>ADMIN</span> Log in</h2>
          <?php if(isset($error)){?>
            <p class="message error"><?php echo $error; ?></p>
          <?php }?>
          <?php if(isset($success)){?>
            <p class="message success"><?php echo $success; ?></p>
          <?php }?>
          <div class="form-group">
            <label for="username">Username: </label>
            <input type="text" name="username" id="username" placeholder="Username" required>
          </div>
          <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <input type="checkbox" id="show-password-login" onclick="togglePassword('password')"> Show Password
          </div>
          <div class="form-group">
            <button type="submit" name="login">Sign in</button>
          </div>
          <div class="form-group center">
            <a href="#" onclick="document.getElementById('register-form').style.display='block';">Register</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Registration Form -->
  <div id="register-form" class="register-form" style="display:none;">
    <div class="admin-container">
      <div class="login-form">
        <form action="" method="post">
          <h2><span>ADMIN</span> Register</h2>
          <?php if(isset($error)){?>
            <p class="message error"><?php echo $error; ?></p>
          <?php }?>
          <?php if(isset($success)){?>
            <p class="message success"><?php echo $success; ?></p>
          <?php }?>
          <div class="form-group">
            <label for="reg_username">Username: </label>
            <input type="text" name="reg_username" id="reg_username" placeholder="Username" required>
          </div>
          <div class="form-group">
            <label for="reg_password">Password: </label>
            <input type="password" name="reg_password" id="reg_password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <input type="checkbox" id="show-password-register" onclick="togglePassword('reg_password')"> Show Password
          </div>
          <div class="form-group">
            <button type="submit" name="register">Register</button>
          </div>
          <div class="form-group">
            <button type="button" onclick="document.getElementById('register-form').style.display='none';">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function togglePassword(fieldId) {
      var field = document.getElementById(fieldId);
      if (field.type === "password") {
        field.type = "text";
      } else {
        field.type = "password";
      }
    }

    // Hide messages after 5 seconds
    setTimeout(function() {
      var messages = document.querySelectorAll('.message');
      messages.forEach(function(message) {
        message.style.display = 'none';
      });
    }, 1500);
  </script>
  <script src="assets/js/script.js"></script>
</body>
</html>