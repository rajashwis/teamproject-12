<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 
    $username = $_SESSION['username'];
    $cart_id = $_SESSION['cart_id'];

    if(isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        $query = "DELETE FROM CARTPRODUCT WHERE PRODUCT_ID = $delete_id AND CART_ID = $cart_id";
        $statement = oci_parse($connection, $query);
        $result = oci_execute($statement);

        if($result) {
            echo "<script>alert('yass! deleted!');</script>";
            header ('Location: cart.php');
        }
    }

?>