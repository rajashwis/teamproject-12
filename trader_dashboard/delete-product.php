<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    if(isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        $query = "DELETE FROM PRODUCT WHERE PRODUCT_ID = $delete_id";
        $statement = oci_parse($connection, $query);
        $result = oci_execute($statement);

        if($result) {
            echo "<script>
                alert('Product deleted successfully!');
                window.location.href = 'trader-dashboard.php#products';
              </script>";
            exit(); // Ensure script termination after redirection
        }
    }

?>