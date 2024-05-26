<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 
    $username = $_SESSION['username'];
    $wishlist_id = $_SESSION['wishlist_id'];

    if(isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        $query = "DELETE FROM WISHLISTPRODUCT WHERE PRODUCT_ID = $delete_id AND WISHLIST_ID = $wishlist_id";
        $statement = oci_parse($connection, $query);
        $result = oci_execute($statement);

        if($result) {
            echo "<script>
                alert('Product removed successfully!');
                window.location.href = 'wishlist.php';
              </script>";
            exit(); // Ensure script termination after redirection
        }
    }

?>