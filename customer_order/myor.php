<?php

session_start();
error_reporting(0);

include "../connect.php";

if(isset($_SESSION['user_id'])) {
  $user = $_SESSION['user_id']; 
  $username = $_SESSION['username'];
}

$query = "SELECT * FROM ORDERDETAIL WHERE CUSTOMER_ID = $user";
$statement = oci_parse($connection, $query);
oci_execute($statement);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Order</title>
  <link rel="stylesheet" href="myor.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
  <div>
    <div class="box">
      <!--navbar-->
      <div class="navbar" id="nav">
        <nav>
            <ul>
                <li><img class="logo" src="CFXLocalHub - White_Logo.png"></li>
                <div class="search-bar">
                    <form action="search.php" method="GET">
                        <div class="search">
                            <input type="text" name="searchTerm" class="searchTerm" placeholder="   NIKE SHOES...">
                            <button type="submit" class="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="user-box">
                    <div class="signin">
                        <form action="signin.html" method="get">
                            <button class="btn">
                                <u><i class="fa-solid fa-user"></i> Sign in</u>
                            </button>
                        </form>
                    </div>
                    <div class="signup">
                        <form action="signup.html" method="get">
                            <button class="btn-2">
                                Sign up
                            </button>
                        </form>
                    </div>
                </div>
                <li class="basket"><a href="cart.html"><img src="trolley.png" height="30px"></a></li>
            </ul>
        </nav>
    </div>
     
      <div class="vertical-nav">
                <ul>
                    <li><a  href="">My Profile</a></li>
                    <li><a class="active" href="">My Order</a></li>
                    <li><a  href="">My Wishlist</a></li>
                    <li><a href="">Review</a></li>
                </ul>
            </div>



  
    <div class="container">
      

      <div class="row">
        <div class="item"><a href="">Order ID</a></div>
        <div class="item"><a href="">Date</a></div>
        <div class="item"><a href="">Total Price</a></div>
        <div class="item"><a href="">Collection Slot</a></div>
        <div class="item"><a href="">Status</a></div>
        <div class="item"><a href=""></a></div>
      </div>

      <?php

        while($order = oci_fetch_assoc($statement)) {

          echo '<div class="sub-row">'; 
          echo '<div class="item">'.$order['ORDER_ID'].'</div>'; 
          echo '<div class="item">'.$order['ORDER_DATE'].'</div>'; 
          echo '<div class="item"><a href="">$150.00</a></div>'; 
          echo '<div class="item"><a href="">2024-05-05 10:00 AM</a></div>'; 
          echo '<div class="item"><a href="">Shipped</a></div>'; 
          echo '<div class="item"><a href="order-details.html"><i class="fa fa-info-circle"></i></a></div>'; 
          echo '</div>'; 
          echo '<hr>'; 

        }
      ?>

    
    </div>
  </div>
  </div>



  
  <script src="MyOrder.js"></script>
  
</body>
</html>