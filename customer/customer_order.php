<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }

    else {
        echo '<script>
        alert("Sorry, you need to be logged in to access this!");
        window.location.href = "../homepage/home.php";
        </script>';
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="customer_order.css">
    <title>Document</title>
</head>
<body>
    <?php 
        include '../components/header.php';
    ?>
    <div class="menu">
        <ul>
            <li><a href="customer_profile.php">My Profile</a></li>
            <li><a class="active" href="customer_order.php">My Order</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
            <li><a href="customer_review.php">Reviews</a></li>
        </ul>
    </div>

<div class="position">
    <div id="orders" class="content">
        <h1>Orders</h1>
        <div class="order-table-container">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Collection Date</th>
                        <th>Collection Time</th>
                        <th>Delivery Status</th>
                        <th>Order Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        $query = "SELECT O.*, C.DAY_OF_WEEK, C.TIME_
                            FROM ORDERDETAIL O
                            JOIN COLLECTIONSLOT C ON O.COLLECTION_SLOT_ID = C.COLLECTION_SLOT_ID
                            JOIN CUSTOMER CT ON CT.CUSTOMER_ID = O.CUSTOMER_ID
                            WHERE CT.CUSTOMER_ID = $user_id";

                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);

                        while($orderdetail = oci_fetch_assoc($statement)) {
                            echo '<tr>';
                            echo '<td>'.$orderdetail['ORDER_ID'].'</td>';
                            echo '<td>'.$orderdetail['ORDER_DATE'].'</td>';
                            echo '<td>'.$orderdetail['COLLECTION_DATE'].'</td>';
                            echo '<td>'.$orderdetail['TIME_'].'</td>';
                            echo '<td>'.$orderdetail['STATUS'].'</td>';
                            echo '<td><a href="customer_order_details.php?order_id='.$orderdetail['ORDER_ID'].'"><button>View Order</button></a></td>';
                            echo '</tr>';
                        }
                    ?>

                   
                    
                
            </table>
        </div>
    </div>
</div>
</body>
</html>