<?php 
@include 'config.php';


if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $select = "SELECT * FROM form WHERE email = '$email' AND password = '$password'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result)>0){

        $row = mysqli_fetch_assoc($result);

    } else{
        echo "error";
    }
}

?>