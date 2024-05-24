<?php

    session_start();
    include "../connect.php";

    // PHP Mailer and Composer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    if(isset($_SESSION['code'])) {
        $code = $_SESSION['code'];

        if(isset($_POST['submit'])) {

            $confirmation_code = $_POST['confirmation_code'];

            if($code==$confirmation_code) {
                unset($_SESSION['code']);
                header("Location: reset-password.php");
                exit();
            }
            else {
                echo "<script>alert('Wrong code, please try again!')</script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="reset-verify.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <h1>Reset Password</h1>
            <p>Reset password code sent, please enter code to verify</p>
            <form method="POST">
                <input type="number" name="confirmation_code" placeholder="Enter Code"><br/>
                <button type="submit" name="submit">Verify</button>
            </form>

            
        </div>
    </div>
</body>
</html>