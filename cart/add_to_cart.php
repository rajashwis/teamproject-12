<?php

    $user = $_SESSION['user_id']; 
    $username = $_SESSION['username']; 
    $cart_id = $_SESSION['cart_id'];

    if(isset($_GET['product_id'])) { 

        $product_id = $_GET['product_id'];

        $product_query = "SELECT STOCK_AVAILABLE FROM PRODUCT WHERE PRODUCT_ID = $product_id";
        $product_stid=oci_parse($connection, $product_query);
        oci_execute($product_stid);
        $product_stock = oci_fetch_assoc($product_stid);
        $stock = $product_stock['STOCK_AVAILABLE'];

        $stock_ = $stock - 2;

        if($quantity > $stock_) {
            echo "<script>alert('Not enough stock available!')</script>";
        }

        else {

            $query="SELECT CART_ID from CUSTOMER WHERE customer_id = $user";
            $stid=oci_parse($connection, $query);
            oci_execute($stid);
            $row = oci_fetch_assoc($stid);
            $cart_id = $row['CART_ID'];

            $query1 = "SELECT PRODUCT_ID FROM CARTPRODUCT WHERE CART_ID = $cart_id AND PRODUCT_ID = $product_id";
            $stid1 = oci_parse($connection, $query1);
            oci_execute($stid1);
            $row1 = oci_fetch_assoc($stid1);

            if($row1) {
                echo "<script>alert('Product already in Cart!')</script>";
            }

            else {
                $query1="INSERT INTO CARTPRODUCT VALUES (SEQ_CARTPRODUCT_ID.NEXTVAL, $cart_id, $product_id, 1)";
                $stid1=oci_parse($connection, $query1);
                
                if(oci_execute($stid1)) {
                    echo "<script>
                        alert('Category deleted successfully!');
                        window.location.href = 'homepage.php';
                    </script>";
                    exit(); // Ensure script termination after redirection
                }
                
            }

        }

    }
    

?>