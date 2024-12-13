<?php
session_start();
include "../config/connect.php";

// Check if user is logged in
if(isset($_SESSION['id']) && isset($_SESSION['username'])){

// Handle Update User
if(isset($_POST['update_user'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    
    if(!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = mysqli_query($connection, 
            "UPDATE users 
             SET username = '$username', password = '$hashed_password' 
             WHERE id = '$id'"
        );
    } else {
        $update_query = mysqli_query($connection, 
            "UPDATE users 
             SET username = '$username' 
             WHERE id = '$id'"
        );
    }
    
    if($update_query) {
        $_SESSION['message'] = "User updated successfully";
        $_SESSION['username'] = $username; // Update session username
    } else {
        $_SESSION['message'] = "Could not update user";
    }
}

// Fetch the logged-in user's details
$user_id = $_SESSION['id'];
$user_query = mysqli_query($connection, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($user_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <link rel="stylesheet" href="../assets/fontawesome-free-6.5.2-web/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .account-container {
            position: inherit;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 5em;
            flex-direction: column;
        }
        .edit-form-container {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .edit-form-container .form-group {
            margin-bottom: 15px;
        }
        .edit-form-container .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .edit-form-container .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .edit-form-container .form-group button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-form-container .form-group button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?php include "../includes/sidebar.php";?>
    <div class="main-content">
        <?php include "../includes/dropdown.php";?>
        
        <div class="account-container">
            <h2>ACCOUNT MANAGEMENT</h2>
            
            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert <?php echo strpos($_SESSION['message'], 'successfully') !== false ? 'alert-success' : 'alert-error'; ?>">
                    <?php 
                        echo $_SESSION['message']; 
                        unset($_SESSION['message']);
                    ?>
                </div>
                <script>
                setTimeout(function() {
                    document.querySelector('.alert').style.display = 'none';
                }, 1500);
                </script>
            <?php endif; ?>

            <!-- Edit User Form -->
            <div class="edit-form-container">
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <div class="form-group">
                        <label for="username">Username: </label>
                        <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_user">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>

<?php
} else {
    header("Location: ../index.php");
    exit();
}
?>