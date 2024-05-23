<?php

session_start();
include "../connect.php";

$trader = $_SESSION['trader_id'];

    if($trader){
        header('Location: ../component/home.php');    
        exit();
    }

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM User_ WHERE email = '$email'";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    $user = oci_fetch_assoc($statement);

    if ($user) {
        $pass = $user['PASSWORD_'];

        if ($password == $pass) {
            $user_id = $user['USER_ID'];
            $_SESSION['trader_id'] = $user_id;
            /*dummy page*/
            header("Location: add product.php");
            exit();
        }
        else {
            echo "<script>alert</script>";
            echo("Incorrect password!");
        }
    } else {
        echo "Username not found!";
    }
}


?>