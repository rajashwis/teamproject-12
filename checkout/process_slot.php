<?php
session_start();
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day = $_POST['day'];
    $time = $_POST['time'];
    $cart_id = $_SESSION['cart_id'];
    
    // Validate the input
    if (empty($day) || empty($time)) {
        die('Please select a valid day and time slot.');
    }

    $datetime = new DateTime($day);
    $dayOfWeek = $datetime -> format('l');
    
    $selectedDay = new DateTime($day);
    $currentDay = new DateTime();
    $currentDay->setTime(0, 0, 0);
    
    $diff = $selectedDay->diff($currentDay)->format('%a');
    if ($diff < 1) {
        die('Please select a day at least 24 hours from now.');
    }
    
    $_SESSION['date'] = $day;
    $_SESSION['day'] = $dayOfWeek;
    $_SESSION['time'] = $time;

    echo "<script>alert('".$time."')</script>";
    
    $query = "SELECT COLLECTION_SLOT_ID FROM COLLECTIONSLOT WHERE DAY_OF_WEEK = '$dayOfWeek' AND TIME_ = '$time'";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    $collection_slot = oci_fetch_assoc($statement);
    $collection_slot_id = $collection_slot['COLLECTION_SLOT_ID'];

    // Check for the maximum number of orders
    $query = "SELECT COUNT(*) AS ORDER_COUNT FROM ORDERDETAIL WHERE COLLECTION_SLOT_ID = $collection_slot_id";
    $statement = oci_parse($connection, $query); 
    oci_execute($statement);
    
    $orderCount = 0;
    if ($row = oci_fetch_assoc($statement)) {
        $orderCount = $row['ORDER_COUNT'];
    }
    
    if ($orderCount >= 20) {
        die('This time slot is fully booked. Please select another slot.');
    }
    
    oci_close($connection);

    header('Location: checkout.php');
    exit;
} else {
    die('Invalid request method.');
}
?>