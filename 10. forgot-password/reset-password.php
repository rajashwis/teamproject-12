<?php

    session_start();
    include "../connect.php";

    if(isset($_SESSION['password_check_id'])) {

        $password_check_id = $_SESSION['password_check_id'];

        if(isset($_POST['submit'])) {
            $password = $_POST['password'];
            $password_2 = $_POST['password-2'];
            
            echo "<script>alert('hello!')</script>";
    
            if($password == $password_2) {
                $query="UPDATE USER_ SET PASSWORD_ = $password WHERE USER_ID = $password_check_id";
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                echo "<script>alert('heyy')</script>";
            }
            else {
                echo "<script>alert('Passwords don't match, please try again!')</script>";
            }
    
        }

    }



    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="reset-password.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <h1>Change Password</h1>
            <p>Atleast 8 characers, Atleast one special characters(!@#$%^) and number*</p>
            <form method="POST">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="password-2" placeholder="Confirm Password"><br/>

                <button type="submit" name="submit">Change Password</button>
            </form>
        </div>
    </div>
</body>
</html>