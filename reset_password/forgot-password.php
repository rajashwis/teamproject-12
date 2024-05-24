<?php

    session_start();
    include "../connect.php";

    // PHP Mailer and Composer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];

        $query = "SELECT USER_ID FROM USER_ WHERE EMAIL = '$email'";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);

        $email_check = oci_fetch_assoc($statement);

        if ($email_check) {

            $email_check = $email_check['USER_ID'];
            $code = rand(100000, 999999);

            $_SESSION['password_check_id'] = $email_check;
            $_SESSION['code'] = $code;
    
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
    
                header("Location: reset-verify.php");
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        else {
            echo '<script>alert("Email not found!")</script>';
        }


    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="forgot-password.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <h1>Forgot Password?</h1>
            <p>Please enter your email you'd like to send reset mail</p>
            <form method="POST">
                <input type="email" name="email" placeholder="Your Email"><br/>
                <button type="submit" name="submit">Send Verification Code</button>

            </form>
        </div>
    </div>
</body>
</html>