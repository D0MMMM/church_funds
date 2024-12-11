<?php
include "../config/connect.php";
$name = "";
$imagePath = "../assets/img/logo.png";

$sql = "SELECT name, image_path FROM treasurer WHERE id = 1";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $imagePath = $row["image_path"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $uploadDir = '../assets/img/';
        $newImagePath = $uploadDir . basename($imageName);

        if (move_uploaded_file($imageTmpPath, $newImagePath)) {
            $imagePath = $newImagePath;
        } else {
            echo "Error uploading the image.";
        }
    }

    $stmt = $connection->prepare("UPDATE treasurer SET name = ?, image_path = ? WHERE id = 1");
    $stmt->bind_param("ss", $name, $imagePath);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>