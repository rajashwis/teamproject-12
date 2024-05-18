<?php

session_start();
include "../connect.php";

// PHP Mailer and Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if(isset($_SERVER['user_id'])) {
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
    
    $sql = "INSERT INTO User_ (user_id, username, email, password_, first_name, last_name, user_role, date_of_birth, gender) VALUES (SEQ_USER_ID.NEXTVAL, '$username', '$email', '$password', '$fname', '$lname', '$role', TO_DATE('$dob','YYYY-MM-DD'), '$gender')";
    $sql1 = "INSERT INTO CART VALUES (SEQ_CART_ID.NEXTVAL, 0)";
    $sql2 = "INSERT INTO Customer(customer_id, date_joined, verification_code, is_verified, cart_id) VALUES (SEQ_USER_ID.CURRVAL, SYSDATE, '$code', 0, SEQ_CART_ID.CURRVAL)";
    $sql3 = "INSERT INTO WISHLIST VALUES (SEQ_WISHLIST_ID.NEXTVAL, SEQ_USER_ID.CURRVAL)";

    if(oci_execute(oci_parse($connection,$sql)) && oci_execute(oci_parse($connection, $sql1)) && oci_execute(oci_parse($connection, $sql2)) && oci_execute(oci_parse($connection,$sql3))) {

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
            $mail->Subject = 'Verification Code';
            $mail->Body    = "Hi customer $fname,<br><br>Your verification code is: <b>$code</b><br><br>Thank you!";

            $mail->send();

            $query = "SELECT SEQ_USER_ID.CURRVAL FROM DUAL";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $currval = oci_fetch_assoc($statement);
            $currval = $currval['CURRVAL'];

            $query1 = "SELECT VERIFICATION_CODE FROM CUSTOMER WHERE customer_id = $currval";
            $statement1 = oci_parse($connection, $query1);
            oci_execute($statement1);
            $confirm = oci_fetch_assoc($statement1);
            $confirmation_id = $confirm['VERIFICATION_CODE'];

            $_SESSION['customer_id'] = $currval;
            $_SESSION['confirmation_id'] = $confirmation_id;

            header("Location: customer_verification.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    else {
        echo "error!";
    }

    oci_close($connection);

}
?>