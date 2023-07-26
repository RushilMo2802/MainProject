<!-- delete.php -->
<?php
// Connect to the database
@include 'conifg.php';

$id = $_GET['id'];

$query = "DELETE FROM company WHERE id=$id";
mysqli_query($connection, $query);

$query = "DELETE FROM images WHERE id=$id";
mysqli_query($connection, $query);

header("Location: add.php");
exit();
?>
