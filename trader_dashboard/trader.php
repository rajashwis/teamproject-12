<?php 
  session_start();
  include "../connect.php";

  if(isset($_SESSION['user_id'])) {
    echo '<script>
            alert("You need to log out to access this!");
            window.location.href = "../homepage/home.php";
        </script>';
        exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="trader.css">
    <title>Trader Account Setup</title>
</head>
<body>
    <div class="wrapper">
        <div class="logo">
            <img src="cfxlogo100.png" alt="bg" height="90px">
        </div>
        <div class="sign-in-seller">
            <a href="trader_signin.html">Sign in</a>
        </div>
        <h1>Welcome to CFX Seller Center</h1>
        <h2>Where Every Seller<br/> Finds Their Starting Point</h2>
        <div class="container">
            <div class="center">
              <button class="btn">
                <a href="trader_signup.html">
                  <svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
                    <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                    <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                  </svg>
                  <span>Become a seller</span>
                </a>
              </button>
            </div>
          </div>
    </div>
</body>
</html>