<?php
session_start();
include('../connect.php');

// PHP Mailer and Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_GET['total_price'])) {

    $totalPrice = $_GET['total_price'];
    $user = $_SESSION['user_id'];
    $username = $_SESSION['username']; 
    $cart_id = $_SESSION['cart_id'];

    echo "<script>alert('".$totalPrice."')</script>";

    $date = $_SESSION['date'];
    $dayOfWeek = $_SESSION['day'];
    $time = $_SESSION['time'];

    $query = "SELECT COLLECTION_SLOT_ID FROM COLLECTIONSLOT WHERE DAY_OF_WEEK = :dayOfWeek AND TIME_ = :time";
    $statement = oci_parse($connection, $query);
    oci_bind_by_name($statement, ':dayOfWeek', $dayOfWeek);
    oci_bind_by_name($statement, ':time', $time);
    if (!oci_execute($statement)) {
        $error = oci_error($statement);
        die("SQL Error: " . $error['message']);
    }

    $collection_slot = oci_fetch_assoc($statement);
    if (!$collection_slot) {
        die('Collection slot not found.');
    }
    $collection_slot_id = $collection_slot['COLLECTION_SLOT_ID'];

    $query1 = "INSERT INTO ORDERDETAIL (ORDER_ID, ORDER_DATE, QUANTITY, IS_PAID, CART_ID, CUSTOMER_ID, COLLECTION_SLOT_ID, STATUS, COLLECTION_DATE)
    VALUES (SEQ_ORDERDETAIL_ID.NEXTVAL, SYSDATE, NULL, 1, :cart_id, :user_id, :collection_slot_id, 'PROCESSING', :collection_date)";
    $statement1 = oci_parse($connection, $query1);
    oci_bind_by_name($statement1, ':cart_id', $cart_id);
    oci_bind_by_name($statement1, ':user_id', $user);
    oci_bind_by_name($statement1, ':collection_slot_id', $collection_slot_id);
    oci_bind_by_name($statement1, ':collection_date', $date);

    if (!oci_execute($statement1)) {
    $error = oci_error($statement1);
    die("SQL Error: " . $error['message']);
    }

    $query22 = "SELECT SEQ_ORDERDETAIL_ID.CURRVAL FROM DUAL";
    $statement22 = oci_parse($connection, $query22);
    oci_execute($statement22);

    $order_id = oci_fetch_assoc($statement22);
    $order_id = $order_id['CURRVAL'];

    $query2 = "INSERT INTO PAYMENT (PAYMENT_ID, PAYMENT_AMOUNT, PAYMENT_DATE, ORDER_ID, PAYMENT_TYPE_ID, CUSTOMER_ID)
    VALUES (SEQ_PAYMENT_ID.NEXTVAL, :total_price, SYSDATE, :order_id, 1, :user_id)";
    $statement2 = oci_parse($connection, $query2);
    oci_bind_by_name($statement2, ':total_price', $totalPrice);
    oci_bind_by_name($statement2, ':order_id', $order_id);
    oci_bind_by_name($statement2, ':user_id', $user);

    if (!oci_execute($statement2)) {
    $error = oci_error($statement2);
    die("SQL Error: " . $error['message']);
}

    $query3 = "SELECT * FROM CARTPRODUCT WHERE CART_ID = :cart_id";
    $statement3 = oci_parse($connection, $query3);
    oci_bind_by_name($statement3, ':cart_id', $cart_id);

    if (!oci_execute($statement3)) {
        $error = oci_error($statement3);
        die("SQL Error: " . $error['message']);
    }

    while ($cart_product = oci_fetch_assoc($statement3)) {
        $product_id = $cart_product['PRODUCT_ID'];
        $product_quantity = $cart_product['PRODUCT_QUANTITY'];

        $query4 = "INSERT INTO ORDERPRODUCT (ORDER_PRODUCT_ID, ORDER_ID, PRODUCT_ID, ITEM_QUANTITY)
                   VALUES (SEQ_ORDERPRODUCT_ID.NEXTVAL, SEQ_ORDERDETAIL_ID.CURRVAL, :product_id, :product_quantity)";
        $statement4 = oci_parse($connection, $query4);
        oci_bind_by_name($statement4, ':product_id', $product_id);
        oci_bind_by_name($statement4, ':product_quantity', $product_quantity);

        if (!oci_execute($statement4)) {
            $error = oci_error($statement4);
            die("SQL Error: " . $error['message']);
        }
    }

    $delete_query = "DELETE FROM CARTPRODUCT WHERE CART_ID = :cart_id";
    $statement5 = oci_parse($connection, $delete_query);
    oci_bind_by_name($statement5, ':cart_id', $cart_id);

    if (!oci_execute($statement5)) {
        $error = oci_error($statement5);
        die("SQL Error: " . $error['message']);
    }

    // verification code to  verify trader...
    $mail = new PHPMailer(true);
    try {
        //Server settings ..gmail.. ..cfxlocalhub@gmail.com is our official gmail for sending mails/newsletters
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cfxlocalhub@gmail.com';
        $mail->Password = 'grax abbj upqq uzhd'; // Using App-password of cfxlocalhub@gmail.com..
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        
        $mail->setFrom('cfxlocalhub@gmail.com', 'CFXsupport');
        $mail->addAddress($email, $fname . ' ' . $lname);

        // Mail output :
        $mail->isHTML(true);
        $mail->Subject = 'Invoice';
        $mail->Body    = "
        
        <html>
        <style>
        body{
            font-family: 'Sofia', sans-serif;
        }
        
        .order-table-container {
            overflow-x: auto;
        }

        .order-table {
            border-collapse: collapse;
            width: 100%;
        }

        .order-table th,
        .order-table td {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .order-table th {
            background-color: #b0b0b0;
        }

        .order-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .order-table tbody tr:hover {
            background-color: #ddd;
        }

        .order-table button{
            border: 1px solid black;
            cursor: pointer;
            border-radius: 3px;
            padding: 5px;
        }

        .order-table button:hover{
            background-color: #bebebe;
        }

       </style>
        <body>
        Order ID : 786e8327edb<br>
        Order Date : 1/23/24 <br>
        <br>
    
            
            <div class='order-table-container'>
                <table class='order-table'>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    
                    <tbody>"?>
                    <?php
                    $query5 = "SELECT 
                            od.order_id,
                            cs.collection_slot_id,
                            op.product_id,
                            p.product_name,
                            p.price AS product_price,
                            op.item_quantity,
                            (p.price * op.item_quantity) AS total_price
                        FROM 
                            OrderDetail od
                        JOIN 
                            OrderProduct op ON od.order_id = op.order_id
                        JOIN 
                            Product p ON op.product_id = p.product_id
                        JOIN 
                            CollectionSlot cs ON od.collection_slot_id = cs.collection_slot_id
                        WHERE OD.ORDER_ID = SEQ_ORDER_ID.CURRVAL";
                    $statement5 = oci_parse($connection, $query5);
                    oci_execute($statement5);
                    
                    while($invoice = oci_fetch_assoc($statement5)) {
                        echo '<tr>';
                        echo '<td>'.$invoice['PRODUCT_ID'].'</td>';
                        echo '<td>'.$invoice['PRODUCT_NAME'].'</td>';
                        echo '<td>'.$invoice['ITEM_QUANTITY'].'</td>';
                        echo '<td>'.$invoice['TOTAL PRICE'].'</td>';
                        echo '</tr>';
                    }
                    
                    ?>
                    <?php
                    "
    
                        
                    
                </table>
            </div>
        
        <br>
        Collection Slot<br>
        Pick Up address : Address
        
        <p> Thank You for your business! Hope you enjoy your new product.

        </body>
        </html>
        ";
        

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    unset($_SESSION['date']);
    unset($_SESSION['day']);
    unset($_SESSION['time']);

    header('Location: ../homepage/');
    exit;
}
?>
