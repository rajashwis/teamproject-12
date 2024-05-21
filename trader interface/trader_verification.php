<?php

    session_start();
    include "../connect.php";

    if(isset($_SESSION['user_id'])) {
        $user = $_SESSION['user_id'];
        header('Location: ../homepage/home.php');    
        exit();
    }

    if(isset($_SESSION['confirmation_id'])) {
        $confirmation_id = $_SESSION['confirmation_id'];

        if(isset($_POST['submit'])) {

            $code = $_POST['code'];

            if($code==$confirmation_id) {

                $trader_id = $_SESSION['trader_id'];
                $query = "UPDATE TRADER SET IS_VERIFIED = 1 WHERE TRADER_ID = $trader_id";
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                echo "<script>alert('Confirmed!')</script>";

                unset($_SESSION['confirmation_id']);

                $_SESSION['user_id'] = $trader_id;
                header("Location: ../trader interface/add product.php");
            }
            else {
                echo "<script>alert('Not Confirmed!')</script>";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="trader_verification.css">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <title>Verify Email</title>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="text">
                Verify Your Email
            </div>
            
            <div class="verify">
                <form method="POST">
                    <input type="text" class="verify-input" name="code" placeholder="verification code">
                    <input type="submit" name="submit" class="submit-button" value="Verify">
                </form>
            </div>
            <div class="dialog">
                Didn't recieve code? <a href="#">Resend Code</a>
            </div>
        </div>
    </div>
</body>
</html>