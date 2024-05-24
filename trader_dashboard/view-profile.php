<?php

    session_start();
    error_reporting(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../connect.php";

    if(isset($_SESSION['trader_id'])) {
        $trader_id = $_SESSION['trader_id'];

        $query = "SELECT * FROM USER_ WHERE USER_ID = $trader_id";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);
        $trader = oci_fetch_assoc($statement);
    }

    else {
        header('Location: ../component/home.php');    
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <title>View Profile</title>
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            z-index: 999;
            border-bottom: 1px solid white;
        }

        .profile {
            display: flex;
            align-items: center;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            transition: 2s;
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile span {
            font-size: 16px;
            margin-left: 10px;
        }

        .sign-out-btn {
            background-color: #f99f1b;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 28px;
        }

        .profile-display {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 5%;
        }

        .profile-display h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .profile-display .profile-image {
            margin-bottom: 15px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #000000;
        }

        .profile-display .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-display .profile-info {
            width: 100%;
        }

        .profile-display .profile-info div {
            margin-bottom: 10px;
        }

        .profile-display .profile-info label {
            font-weight: bold;
            color: #555;
        }

        .profile-display .profile-info span {
            display: block;
            margin-left: 10px;
            color: #333;
        }

        .edit-btn {
            padding: 10px 20px;
            background-color: #f99f1b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .edit-btn:hover {
            background-color: #d78b19;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="profile">
            <div class="profile-img">
                <a href="trader-profile.html"><img src="../resources/dummy images/dummy_product.png" alt="Profile Picture"></a>
            </div>
            <span><?php echo $trader['FIRST_NAME']; echo " "; echo $trader['LAST_NAME']; ?></span>
        </div>
        <button class="sign-out-btn">Sign Out</button>
    </div>

    <div class="profile-display">
        <h2>Customer Profile</h2>
        
        <div class="profile-image">
            <img id="profileImg" src="https://via.placeholder.com/100" alt="Profile Image">
        </div>
        
        <div class="profile-info">
            <div>
                <label for="firstName">First Name:</label>
                <span id="firstName"><?php echo $trader['FIRST_NAME'];?></span>
            </div>
            <div>
                <label for="lastName">Last Name:</label>
                <span id="lastName"><?php echo $trader['LAST_NAME'];?></span>
            </div>
            <div>
                <label for="username">Username:</label>
                <span id="username"><?php echo $trader['USERNAME'];?></span>
            </div>
            <div>
                <label for="address">Address:</label>
                <span id="address"><?php echo $trader['ADDRESS_'];?></span>
            </div>
            <div>
                <label for="email">Email:</label>
                <span id="email"><?php echo $trader['EMAIL'];?></span>
            </div>
            <div>
                <label for="dob">Date of Birth:</label>
                <span id="dob"><?php echo $trader['DATE_OF_BIRTH'];?></span>
            </div>
            <div>
                <label for="gender">Gender:</label>
                <span id="gender"><?php echo $trader['GENDER'];?></span>
            </div>
        </div>
        <a href="edit-profile.php?trader_id=<?php echo $trader_id ?>"><button class="edit-btn">Edit Profile</button></a>
        <a href="trader-dashboard.html"><button class="edit-btn">Done</button></a>
    </div>

</body>
</html>
