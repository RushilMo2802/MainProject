<?php
// Connect to the database
include 'config.php'; // Corrected the inclusion from @include to include

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $num1 = isset($_POST['contact']) ? $_POST['contact'] : '';
  $num2 = isset($_POST['contact1']) ? $_POST['contact1'] : '';

  // Check if all three entries are sent properly
  if (empty($name) || empty($num1) || empty($num2)) {
    // Data is missing, display an alert and stop execution
    echo "<script>alert('Please fill in all the required fields.'); window.location.href = 'your_form_page.php';</script>";
    exit();
  }

  // Display the data in an alert box
  echo "<script>alert('Received Data:\\nName: $name\\nContact 1: $num1\\nContact 2: $num2');</script>";

  // Delay execution of the MySQL query using setTimeout
  echo "<script>setTimeout(function() { document.getElementById('form').submit(); }, 5000);</script>";


  // You mentioned 'email' in the INSERT query, but it's not present in the POST data. So, I'll remove it from the query.
  $query = "INSERT INTO company (name, num1 , num2) VALUES ('$name', '$num1', '$num2')";
  $result = mysqli_query($conn, $query); // Use $conn instead of $connection_ to fix the "null" issue
  if ($result) {
    $user_id = mysqli_insert_id($conn);

    $user_folder = "uploads/" . $name . "/";
    if (!file_exists($user_folder)) {
      mkdir($user_folder, 0777, true);
    }

    if (!empty($_FILES['image']['name'][0])) {
      $totalFiles = count($_FILES['image']['name']);
      for ($i = 0; $i < $totalFiles; $i++) {
        $imageName = $_FILES['image']['name'][$i];
        $imageTempPath = $_FILES['image']['tmp_name'][$i];
        $targetPath = $user_folder . $imageName;
        move_uploaded_file($imageTempPath, $targetPath);

        $query = "INSERT INTO images (id, image_path) VALUES ($user_id, '$targetPath')";
        mysqli_query($conn, $query);
      }
    }

    header("Location: list.php");
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>
