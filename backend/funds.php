<?php
// session_start();
include "../config/connect.php";

// Handle adding a new fund
if(isset($_POST['add_funds'])){
    $amount = mysqli_real_escape_string($connection, $_POST['amount']);
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $depositor_name = mysqli_real_escape_string($connection, $_POST['depositor_name']);
  
    $insert_query = mysqli_query($connection, "INSERT INTO `funds`(amount, date, depositor_name) VALUES('$amount', '$date', '$depositor_name')") or die('query failed');
  
    if($insert_query){
      $_SESSION['message'] = "Funds added successfully";
    }else{
      $_SESSION['message'] = "Could not add the funds";
    }
    header('location: funds.php');
    exit();
}

// Handle updating a fund
if(isset($_POST['update_funds'])){
  $update_id = mysqli_real_escape_string($connection, $_POST['update_id']);
  $update_amount = mysqli_real_escape_string($connection, $_POST['update_amount']);
  $update_date = mysqli_real_escape_string($connection, $_POST['update_date']);
  $update_name = mysqli_real_escape_string($connection, $_POST['update_name']);

  $update_query = mysqli_query($connection, "UPDATE `funds` SET amount = '$update_amount', date = '$update_date', depositor_name = '$update_name' WHERE id = '$update_id'");

  if($update_query){
     $_SESSION['message'] = "Funds updated successfully";
  }else{
     $_SESSION['message'] = "Funds could not be updated";
  }
  header('location: funds.php');
  exit();
}

// Handle deleting a fund
if(isset($_GET['delete_funds'])){
  $delete_id = $_GET['delete_funds'];
  $delete_query = mysqli_query($connection, "DELETE FROM `funds` WHERE id = $delete_id") or die('query failed');
  if($delete_query){
     $_SESSION['message'] = "Funds has been deleted";
  }else{
     $_SESSION['message'] = "Funds could not be deleted";
  }
  header('location: funds.php');
  exit();
}

// Handle updating funds balance
if(isset($_POST['funds_balance_update'])){
  $update_id = mysqli_real_escape_string($connection, $_POST['update_id']);
  $update_amount = mysqli_real_escape_string($connection, $_POST['update_amount']);

  $update_query = mysqli_query($connection, "UPDATE `funds_balance` SET amount = '$update_amount' WHERE id = '$update_id'");
}

// Fetch treasurer details
$sql = "SELECT name, image_path FROM treasurer WHERE id = 1";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $name = $row["name"];
  $imagePath = $row["image_path"];
}
?>