<?php

session_start();
include "../connect.php";

if(isset($_SESSION['user_id'])) {
    $user = $_SESSION['user_id'];
    header('Location: ../homepage/home.php');    
    exit();
}

if(isset($_POST['submit']))
{
    $email = $_POST['email'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
    $password_2 = $_POST['password-2'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $role = 'Trader';
    $code = rand(100000, 999999);

    $sname = $_POST['shop-name'];
    $saddress = $_POST['shop-address'];

    if($gender) {
        if($gender == 'male') {
            $gender = 'M';    
        }
        else if($gender == 'female') {
            $gender = 'F';    
        }
        else {
            $gender = 'O';
        }
    }
    
    $sql = "INSERT INTO User_ (user_id, username, email, password_, first_name, last_name, user_role, date_of_birth, gender, address_) VALUES (SEQ_USER_ID.NEXTVAL, '$username', '$email', '$password', '$fname', '$lname', '$role', TO_DATE('$dob','YYYY-MM-DD'), '$gender', '$address')";

    $sql1 = "INSERT INTO Trader (trader_id, date_joined, verification_code, is_verified, is_approved) VALUES (SEQ_USER_ID.CURRVAL, SYSDATE, '$code', 0, 0)";

    $sql2 = "INSERT INTO Shop VALUES (SEQ_SHOP_ID.NEXTVAL, '$sname', '$saddress', SYSDATE, 0, SEQ_USER_ID.CURRVAL)";

    if(oci_execute(oci_parse($connection,$sql)) && oci_execute(oci_parse($connection, $sql1)) && oci_execute(oci_parse($connection, $sql2))) {
        header("Location: ../trader interface/trader login.html");
        exit();
    }
    else {
        echo "error!";
    }

    oci_close($connection);

}
?>