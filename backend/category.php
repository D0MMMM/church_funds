<?php 
// Handle adding a new category
if(isset($_POST['add_category'])){
    $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);
    $insert_category = mysqli_query($connection, "INSERT INTO categories (category_name) VALUES ('$category_name')");
    if($insert_category){
        echo "<script>alert('Category added successfully');</script>";
        echo "<script>window.location.href = 'expense.php';</script>";
    } else {
        echo "<script>alert('Failed to add category');</script>";
        echo "Error: " . mysqli_error($connection);
    }
}
?>