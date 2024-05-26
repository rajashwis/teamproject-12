<?php

session_start();
include "../connect.php";

if(isset($_SESSION['trader_id'])) {
    $trader = $_SESSION['trader_id'];

        if($trader){
            header('Location: ../homepage/');    
            exit();
        }
    }

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM User_ WHERE email = '$email' AND USER_ROLE ='Trader'";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    $user = oci_fetch_assoc($statement);

    if ($user) {
        $trader_id = $user['USER_ID'];
        $query1 = "SELECT * FROM TRADER WHERE TRADER_ID = $trader_id";
        $statement1 = oci_parse($connection, $query1);
        oci_execute($statement1);

        $trader = oci_fetch_assoc($statement1);
        $verified = $trader['IS_VERIFIED'];
        $approved = $trader['IS_APPROVED'];

        if($verified == 0) {

            echo '<script>
            alert("Sorry, you are not verified yet! Please check your email for the verification code!");
            window.location.href = "trader_signin.html";
            </script>';
            exit();

        }
        
        if ($approved == 0) {
            echo '<script>
            alert("Sorry, you are not approved yet! Please wait for admin approval!");
            window.location.href = "trader_signin.html";
            </script>';
            exit();
        }

        else {
            $pass = $user['PASSWORD_'];

            if ($password == $pass) {
                $user_id = $user['USER_ID'];
                $_SESSION['trader_id'] = $user_id;

                header("Location: trader-dashboard.php");
                exit();
            }
            else {
                echo '<script>alert("Incorrect Password!")</script>';
            }
        }
        
    } else {
        echo '<script>alert("Username not found!")</script>';
    }
}


?>