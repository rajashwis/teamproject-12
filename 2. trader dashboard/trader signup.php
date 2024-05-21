<?php

    session_start();
    include "../connect.php";

    // PHP Mailer and Composer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

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
        
        // Insert user data into the database
        $sql = "INSERT INTO User_ (user_id, username, email, password_, first_name, last_name, user_role, date_of_birth, gender, address_) VALUES (SEQ_USER_ID.NEXTVAL, '$username', '$email', '$password', '$fname', '$lname', '$role', TO_DATE('$dob','YYYY-MM-DD'), '$gender', '$address')";
        $stmt = oci_parse($connection, $sql);
        $success = oci_execute($stmt);

        if ($success) {
            // Insert trader data into the database
            $sql1 = "INSERT INTO Trader (trader_id, date_joined, verification_code, is_verified, is_approved) VALUES (SEQ_USER_ID.CURRVAL, SYSDATE, '$code', 0, 0)";
            $stmt1 = oci_parse($connection, $sql1);
            $success1 = oci_execute($stmt1);

            if ($success1) {
                // Insert shop data into the database
                $sql2 = "INSERT INTO Shop VALUES (SEQ_SHOP_ID.NEXTVAL, '$sname', '$saddress', SYSDATE, 0, SEQ_USER_ID.CURRVAL)";
                $stmt2 = oci_parse($connection, $sql2);
                $success2 = oci_execute($stmt2);

                if ($success2) {
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
                        $mail->Body    = "Hi $fname,<br><br>Your verification code is: <b>$code</b><br><br>Thank you!";

                        $mail->send();

                        $query = "SELECT SEQ_USER_ID.CURRVAL FROM DUAL";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                        $currval = oci_fetch_assoc($statement);
                        $currval = $currval['CURRVAL'];

                        $query1 = "SELECT VERIFICATION_CODE FROM TRADER WHERE trader_id = $currval";
                        $statement1 = oci_parse($connection, $query1);
                        oci_execute($statement1);
                        $confirm = oci_fetch_assoc($statement1);
                        $confirmation_id = $confirm['VERIFICATION_CODE'];

                        $_SESSION['trader_id'] = $currval;
                        $_SESSION['confirmation_id'] = $confirmation_id;

                        header("Location: ../trader interface/trader_verification.php");
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    echo "Error inserting shop data";
                }
            } else {
                echo "Error inserting trader data";
            }
        } else {
            echo "Error inserting user data";
        }

        oci_close($connection);
    }
?>