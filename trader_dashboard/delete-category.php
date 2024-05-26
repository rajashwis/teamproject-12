<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    if(isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        $query = "DELETE FROM PRODUCTCATEGORY WHERE CATEGORY_ID = $delete_id";
        $statement = oci_parse($connection, $query);
        $result = oci_execute($statement);

        if($result) {
            echo "<script>
                alert('Category deleted successfully!');
                window.location.href = 'trader-dashboard.php#shop';
              </script>";
            exit(); // Ensure script termination after redirection
        }
    }

?>