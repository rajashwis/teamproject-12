<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    if(isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        $query = "DELETE FROM DISCOUNT WHERE DISCOUNT_ID = $delete_id";
        $statement = oci_parse($connection, $query);
        $result = oci_execute($statement);

        if($result) {
            echo "<script>
                alert('Discount deleted successfully!');
                window.location.href = 'trader-dashboard.php#discount';
              </script>";
            exit(); // Ensure script termination after redirection
        }
    }

?>