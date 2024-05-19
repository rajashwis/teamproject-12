<?php

session_start();
include "../connect.php";
    
$user = $_SESSION['user_id'];

    if($user){
        header('Location: ../homepage/home.php');    
        exit();
    }

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

            $query = "SELECT * FROM Customer WHERE customer_id = $user_id";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $customer = oci_fetch_assoc($statement);

            $cart_id = $customer['CART_ID'];
            $_SESSION['cart_id'] = $cart_id;

            $query1 = "SELECT WISHLIST_ID FROM WISHLIST WHERE customer_id = $user_id";
            $statement1 = oci_parse($connection, $query1);
            oci_execute($statement1);
            $wishlist = oci_fetch_assoc($statement1);

            $wishlist_id = $wishlist['WISHLIST_ID'];
            $_SESSION['wishlist_id'] = $wishlist_id;

            header("Location: ../homepage/home.php");
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