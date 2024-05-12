<?php

session_start();
include "../connect.php";

$user = $_SESSION['user_id'];

    if($user){
        header('Location: ../component/home.php');    
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
    $dob = $_POST['dob'];
    $role = 'Customer';
    $code = rand(100000, 999999);

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
    
    $sql = "INSERT INTO User_ (user_id, username, email, password_, first_name, last_name, user_role, date_of_birth, gender) VALUES (SEQ_CUSTOMER_ID.NEXTVAL, '$username', '$email', '$password', '$fname', '$lname', '$role', TO_DATE('$dob','YYYY-MM-DD'), '$gender')";

    $sql1 = "INSERT INTO Customer(customer_id, date_joined, verification_code, is_verified) VALUES (SEQ_CUSTOMER_ID.CURRVAL, SYSDATE, '$code', 0)";

    if(oci_execute(oci_parse($connection,$sql)) && oci_execute(oci_parse($connection, $sql1))) {
        header("Location: ../login/login.html");
        exit();
    }
    else {
        echo "error!";
    }

    oci_close($connection);

}
?>