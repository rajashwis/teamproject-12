<?php

$connection = oci_connect("cfx_12", "cfxadmin#22", "//localhost/xe"); 

if (!$connection) {
    $error_message = oci_error();
    echo "Failed to connect to Oracle: " . $error_message['message'];
    exit();
}

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM User_ WHERE username = '$username'";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    $user = oci_fetch_assoc($statement);

    if ($user) {
        $pass = $user['PASSWORD_'];

        if ($password == $pass) {
            //$_SESSION['username'] = $username;
            header("Location: homepage.html");
            exit;
        }
        else {
            echo("Incorrect password!");
        }
    } else {
        echo "Username not found!";
    }
}

oci_close($connection);

?>