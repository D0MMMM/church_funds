<?php
include "../config/connect.php";

// Handle adding a new expense
if(isset($_POST['add_expenses'])){
    $expenses_name = mysqli_real_escape_string($connection, $_POST['expenses_name']);
    $expenses_amount = mysqli_real_escape_string($connection, $_POST['expenses_amount']);
    $expenses_date = mysqli_real_escape_string($connection, $_POST['expenses_date']);
    $spender_name = mysqli_real_escape_string($connection, $_POST['spender_name']);
    $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
  
    $insert_query = mysqli_query($connection, "INSERT INTO `expenses`(expenses_name, expenses_amount, expenses_date, spender_name, category_id) VALUES('$expenses_name', '$expenses_amount', '$expenses_date', '$spender_name', '$category_id')") or die('query failed');
  
    if($insert_query){
      $_SESSION['message'] = "Expenses added successfully";
    }else{
      $_SESSION['message'] = "Could not add the expenses";
    }
    header('location: expense.php');
    exit();
}

// Handle deleting an expense
if(isset($_GET['delete_expenses'])){
    $delete_id = $_GET['delete_expenses'];
    $delete_query = mysqli_query($connection, "DELETE FROM `expenses` WHERE id = $delete_id") or die('query failed');
    if($delete_query){
      $_SESSION['message'] = "Expenses has been deleted";
    }else{
      $_SESSION['message'] = "Expenses could not be deleted";
    }
    header('location: expense.php');
    exit();
}

// Handle updating an expense
if(isset($_POST['update_expenses'])){
    $update_id = mysqli_real_escape_string($connection, $_POST['update_id']);
    $update_expenses_name = mysqli_real_escape_string($connection, $_POST['update_expenses_name']);
    $update_amount = mysqli_real_escape_string($connection, $_POST['update_amount']);
    $update_date = mysqli_real_escape_string($connection, $_POST['update_date']);
    $update_name = mysqli_real_escape_string($connection, $_POST['update_name']);
    $update_category_id = mysqli_real_escape_string($connection, $_POST['update_category_id']);
  
    $update_query = mysqli_query($connection, "UPDATE `expenses` SET expenses_name = '$update_expenses_name', expenses_amount = '$update_amount', expenses_date = '$update_date', spender_name = '$update_name', category_id = '$update_category_id' WHERE id = '$update_id'") or die('query failed');
  
    if($update_query){
      $_SESSION['message'] = "Expenses updated successfully";
    }else{
      $_SESSION['message'] = "Expenses could not be updated";
    }
    header('location: expense.php');
    exit();
}

// Handle adding a new category
if(isset($_POST['add_category'])){
    $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);
    $insert_category = mysqli_query($connection, "INSERT INTO categories (category_name) VALUES ('$category_name')");
    if($insert_category){
      $_SESSION['message'] = "Category added successfully";
    } else {
      $_SESSION['message'] = "Failed to add category";
    }
    header('location: expense.php');
    exit();
}

// Handle deleting a category
if(isset($_GET['delete_category'])){
    $delete_id = $_GET['delete_category'];
    $delete_query = mysqli_query($connection, "DELETE FROM `categories` WHERE id = $delete_id") or die('query failed');
    if($delete_query){
      $_SESSION['message'] = "Category has been deleted";
    }else{
      $_SESSION['message'] = "Category could not be deleted";
    }
    header('location: expense.php');
    exit();
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