<!-- edit.php -->
<?php
// Connect to the database
@include'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $age = $_POST['age'];

  // Check if a new image is uploaded
  $targetPath = null;
  if (!empty($_FILES['image']['name'])) {
    $targetDirectory = "uploads/";
    $imageName = $_FILES['image']['name'];
    $imageTempPath = $_FILES['image']['tmp_name'];
    $targetPath = $targetDirectory . $imageName;
    move_uploaded_file($imageTempPath, $targetPath);
  } else {
    // If no new image is uploaded, retain the existing image path
    $query = "SELECT image FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $userData = mysqli_fetch_assoc($result);
    $targetPath = $userData['image'];
  }

  $query = "UPDATE users SET name='$name', email='$email', age=$age, image='$targetPath' WHERE id=$id";
  mysqli_query($connection, $query);

  header("Location: index.php");
  exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);
?>
