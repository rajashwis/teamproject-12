<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        if(isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
        }
    }

    else {
      header('Location: ../homepage/');    
      exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
body {
    padding: 0;
    margin: 0;
    font-family: "Sofia", sans-serif;
}

#invoice-POS {
    box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    padding: 4mm;
    margin: 0 auto;
    width: 80%;
    height: auto;
    background: #FFF;
}

::selection {
    background: #f31544;
    color: #FFF;
}

::moz-selection {
    background: #f31544;
    color: #FFF;
}

h1 {
    font-size: 2em;
    color: #222;
}

h2 {
    font-size: 1.2em;
}

h3 {
    font-size: 1.5em;
    font-weight: 300;
    line-height: 2em;
}

p {
    font-size: 1em;
    color: #666;
    line-height: 1.5em;
}

#top,
#mid,
#bot {
    border-bottom: 1px solid #EEE;
}

#top {
    min-height: 150px;
}

#mid {
    min-height: 100px;
}

#bot {
    min-height: 70px;
}

#top .logo {
    height: 100px;
    width: 100px;
    background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
    background-size: 100px 100px;
}

.clientlogo {
    float: left;
    height: 100px;
    width: 100px;
    background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
    background-size: 100px 100px;
    border-radius: 50px;
}

.info {
    display: block;
    margin-left: 0;
}

.title {
    float: right;
}

.title p {
    text-align: right;
}

table {
    width: 100%;
    border-collapse: collapse;
}

.tabletitle {
    font-size: 1em;
    background: #EEE;
}

.service {
    border-bottom: 1px solid #EEE;
}

.item {
    width: 24mm;
}

.itemtext {
    font-size: 1em;
}

#legalcopy {
    margin-top: 5mm;
}

@media (max-width: 600px) {
    #invoice-POS {
        width: 95%;
        margin-top: 2%;
        padding: 2mm;
    }

    h1 {
        font-size: 1.5em;
    }

    h2 {
        font-size: 1em;
    }

    h3 {
        font-size: 1.2em;
    }

    p {
        font-size: 0.9em;
    }

    .tabletitle {
        font-size: 0.9em;
    }

    .itemtext {
        font-size: 0.9em;
    }

    #top .logo {
        height: 60px;
        width: 60px;
        background-size: 60px 60px;
    }

    .clientlogo {
        height: 60px;
        width: 60px;
        background-size: 60px 60px;
    }
}
</style>
<body>

<div id="invoice-POS">
    <div id="mid">
        <div class="info">
            <h2><img src="../resources/cfxfaviconnew.png" width="150px"></h2>
            <p>

            <?php
                $order_query = "SELECT * FROM ORDERDETAIL WHERE ORDER_ID = $order_id";
                $order_statement = oci_parse($connection, $order_query);
                oci_execute($order_statement);

                $orderdetail = oci_fetch_assoc($order_statement);

                echo '<h1>Order Details</h1>';
                echo 'Order ID : '.$orderdetail['ORDER_ID'].'<br>';
                echo 'Customer Name : Dipson<br>';
                echo 'Date : '.$orderdetail['ORDER_DATE'].'<br>';
                echo 'Status : '.$orderdetail['STATUS'].'<br>';
            ?>
                
            </p>
        </div>
    </div><!--End Invoice Mid-->
    
    <div id="bot">
        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h2>Product SNo.</h2></td>
                    <td class="Hours"><h2>Product Name</h2></td>
                    <td class="Rate"><h2>Price</h2></td>
                    <td class="Rate"><h2>Quantity</h2></td>
                    <td class="Rate"><h2>Total Price</h2></td>
                    <td class="Rate"><h2>Shop</h2></td>
                </tr>

                <?php 
                    $query = "SELECT op.ORDER_PRODUCT_ID, p.PRODUCT_NAME, op.ITEM_QUANTITY, p.PRICE, s.shop_name, (p.price * op.item_quantity) AS TOTAL_PRICE
                    FROM ORDERPRODUCT op
                    JOIN PRODUCT p ON op.PRODUCT_ID = p.PRODUCT_ID
                    JOIN SHOP s ON p.shop_id = s.shop_id
                    WHERE op.ORDER_ID = $order_id";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);

                    $count = 1;

                    while($order = oci_fetch_assoc($statement)) {
                        echo '<tr class="service">';
                        echo '<td class="tableitem"><p class="itemtext">'.$count.'</p></td>';
                        echo '<td class="tableitem"><p class="itemtext">'.$order['PRODUCT_NAME'].'</p></td>';
                        echo '<td class="tableitem"><p class="itemtext">'.$order['PRICE'].'</p></td>';
                        echo '<td class="tableitem"><p class="itemtext">'.$order['ITEM_QUANTITY'].'</p></td>';
                        echo '<td class="tableitem"><p class="itemtext">'.$order['TOTAL_PRICE'].'</p></td>';
                        echo '<td class="tableitem"><p class="itemtext">'.$order['SHOP_NAME'].'</p></td>';
                        echo '</tr>';

                        $count++;
                    }
   
                ?>

            </table>
        </div><!--End Table-->

        <div id="legalcopy">
            <p class="legal"><strong>Thank you for your purchase! We appreciate your business and hope you enjoy your new product.</strong></p>
        </div>
    </div><!--End InvoiceBot-->
</div><!--End Invoice-->

</body>
</html>
