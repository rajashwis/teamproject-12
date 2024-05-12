<?php

session_start();
include "../connect.php";

/*$user = $_SESSION['user_id'];

    if($user){
        header('Location: ../component/home.php');    
        exit();
    }*/

if(isset($_POST['login']))
{
    $username_or_email = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM User_ WHERE username = '$username_or_email' OR email = '$username_or_email'";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    $user = oci_fetch_assoc($statement);

    if ($user) {
        $pass = $user['PASSWORD_'];

        if ($password == $pass) {
            $user_id = $user['USER_ID'];
            $username = $user['USERNAME'];
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;
            header("Location: ../homepage/homepage.php");
            exit;
        }
        else {
            echo("Incorrect password!");
        }
    } else {
        echo "Invalid Credentials!";
    }
}

oci_close($connection);

?>