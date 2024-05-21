<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id'];
    $username = $_SESSION['username']; 
    $cart_id = $_SESSION['cart_id'];

    $query2 = "SELECT COUNT(*) FROM CARTPRODUCT";
    $stid2=oci_parse($connection, $query2);
    oci_execute($stid2);
    $count = oci_fetch_assoc($stid2);
    $count = $count['COUNT(*)'];

    echo '<script>alert(' . $count . ')</script>';

    $query2 = "INSERT INTO ORDERDETAIL (order_id, order_date, quantity, is_paid, cart_id, customer_id) VALUES (SEQ_ORDERDETAIL_ID.NEXTVAL, SYSDATE, $count, 0, $cart_id, $user)";
    $stid2=oci_parse($connection, $query2);
    oci_execute($stid2);

    $query = "SELECT * FROM CARTPRODUCT WHERE CART_ID = $cart_id";
    $stid=oci_parse($connection, $query);
    oci_execute($stid);

    while($cartproduct = oci_fetch_assoc($stid)) {

        $product_id = $cartproduct['PRODUCT_ID'];
        $quantity = $cartproduct['PRODUCT_QUANTITY'];

        echo '<script>alert(' . $quantity . ')</script>';

        $query2="INSERT INTO ORDERPRODUCT VALUES (SEQ_ORDERPRODUCT_ID.NEXTVAL, SEQ_ORDERDETAIL_ID.CURRVAL, $product_id, $quantity)";
        $stid2=oci_parse($connection, $query2);
        oci_execute($stid2);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="check-out.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>CFXLocalHub HOME PAGE</title>
</head>
<body>
    <div class="home-page">
        <!--navbar-->
        <div class="navbar" id="nav">
            <nav>
                    <img class="logo" src="../resources/cfxlocalhubwhitelogo.png">
            
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
                    <?php
                            session_start(); // Ensure session is started
                            if(isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                        echo
                        
                    '<div class="profile-dropdown">
                        <div onclick="toggle()" class="profile-dropdown-btn">
                        <div class="profile-img">
                            <i class="fa-solid fa-circle"></i>
                        </div>

                        <span>
                        '. $_SESSION['username'] . ' <i class="fa-solid fa-caret-down"></i>
                        </span>
                        </div>
                    </div>';
                    } else {
                        // If user is not logged in, display sign in and sign up buttons
                        echo '<div class="signin">
                        <form action="login.html" method="get">
                            <button class="btn">
                                <u><i class="fa-solid fa-user"></i>
                                    <a href="/teamproject-12-main/login/login.html"> Sign In</a>
                                </u>
                            </button>    
                        </form>
                    </div>
                    <div class="signup">
                        <form action="signup.html" method="get">
                            <button class="btn-2">
                                <a href="/teamproject-12-main/signup/signup.html"> Sign Up</a>
                            </button>    
                        </form>
                    </div>';
                    }
                    ?>
                    </div>

                        <div class="basket">
                            <a href="cart.html"><img src="../resources/trolley.png" height="30px"></a>
                        </div>
                <div class="toggle"><i class="fa-solid fa-bars"></i></div>
            </nav> 
            
        </div>
        <div class="profile-drop">
            <ul class="profile-dropdown-list">
            <li class="profile-dropdown-list-item">
                <a href="#">
                <i class="fa-regular fa-user"></i>
                Edit Profile
                </a>
            </li>

            <li class="profile-dropdown-list-item">
                <a href="#">
                <i class="fa-regular fa-envelope"></i>
                Inbox
                </a>
            </li>

            <li class="profile-dropdown-list-item">
                <a href="#">
                <i class="fa-regular fa-bookmark"></i>
                Wishlist
                </a>
            </li>

            <li class="profile-dropdown-list-item">
                <a href="#">
                <i class="fa-regular fa-circle-question"></i>
                Help & Support
                </a>
            </li>
            <hr />

            <li class="profile-dropdown-list-item">
            <form action="logout.php" method="post">
                <button type="submit">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout</a>
                </button>
            </form>
            </li>
            </ul>
        </div>

        <div class="dropdown">
            <ul>
                <li><a href="teamproject-12/component/home.php">HOME</a></li>
                <li><a href="trending.html"> TRENDING</a></li>
                <li><a href="decor.html"> Bakery</a></li>
                <li><a href=""> ELECTRONICS</a></li>
                <li><a href=""> FASHION</a></li>
                <li><a href=""> SALES</a></li>
                <li><a href="seller.html"> BECOME A SELLER</a></li>
                <li><a href="">Sign In</a></li>
                <li><a href="">Sign Up</a></li>
                <li><a href=""><img src="../resources/trolley.png" height="30px"></a></li>
            </ul>
        </div>
        <!--navbar 2-->
        <div class="navbar2" id="nav2">
            <nav>
                <ul>
                    <li class="home-split"><a class="active" href=""> HOME</a></li>
                    <li><a href="trending.html"> TRENDING</a></li>
                    <li><a href="decor.html"> BAKERY</a></li>
                    <li><a href=""> ELECTRONICS</a></li>
                    <li><a href=""> FASHION</a></li>
                    <li><a href=""> SALES</a></li>
                    <li class="bs-split"><a href="seller.html"> BECOME A SELLER</a></li>
                </ul>
                
            </nav>
        </div> 
        
        <!--checkout-->
        <div class="container-checkout">
                   <h2 style="text-align: center;">Your Order</h2>
                   <hr>
                    <p>
                        <img src="jordanyellow.png" alt="Airpods" height="50px"> 
                        <span class="product-name">Airpods</span>
                        <span class="quantity">
                            <button class="minus" aria-label="Decrease">&minus;</button>
                            <input type="number" class="input-box" value="1" min="1" max="10">
                            <button class="plus" aria-label="Increase">&plus;</button>
                        </span>
                        <span class="price">$15</span>
                    </p>
                    <p>
                        <img src="jordan1red.png" alt="Product 2" height="50px"> 
                        <span class="product-name">Product 2</span>
                        <span class="quantity">x1</span>
                        <span class="price">$5</span>
                    </p>
                    <p>
                        <img src="jordanyellow.png" alt="Product 3" height="50px"> 
                        <span class="product-name">Product 3</span>
                        <span class="quantity">x1</span>
                        <span class="price">$8</span>
                    </p>
                    <p>
                        <img src="jordan1red.png" alt="Product 4" height="50px"> 
                        <span class="product-name">Product 4</span>
                        <span class="quantity">x1</span>
                        <span class="price">$2</span>
                    </p>
                    <hr>
                    <p>Total <span class="price" style="color:rgb(176, 176, 176)"><b>$30</b></span></p>
                </div>
    
        <div class="payment-method">
            <h2>Payment</h2>
            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
            <script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
            <script>
                function initPayPalButton() {
                    paypal.Buttons({
                        style: {
                            shape: 'rect',
                            color: 'gold',
                            layout: 'vertical',
                            label: 'paypal',
                        },
            
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{"amount":{"currency_code": "USD", "value": 0.99}}]
                            });
                        },
            
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(orderData) {
            
                                // Full available details
                                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            
                                // Show a success message within this page, for example:
                                const element = document.getElementById('paypal-button-container');
                                element.innerHTML = '';
                                element.innerHTML = '<h3>Thank you for your payment!</h3>';
            
                                // Or go to another URL:  actions.redirect('thank_you.html');
            
                            });
                        },
            
                        onError: function(err) {
                            console.log(err);
                        }
                    }).render('#paypal-button-container');
                }
                initPayPalButton();
            </script>
        </div>
    </div>
        
            
            <!--footer-->
            <div class="footer-background">
            <div class="container-footer w-container">
                <div class="w-row">
                  <div class="footer-column w-clearfix w-col w-col-4"><img src="../resources/cfxlocalhubwhitelogo.png" alt="" width="40" class="failory-logo-image">
                    <h3 class="footer-failory-name">CFXLocalHub</h3>
                    <p class="footer-description-failory">Best Shopping Online!<br></p>
                  </div>
                  <div class="footer-column w-col w-col-8">
                    <div class="w-row">
                      <div class="w-col w-col-8">
                        <div class="w-row">
                          <div class="w-col w-col-7 w-col-small-6 w-col-tiny-7">
                            <h3 class="footer-titles">Get in touch</h3><br>
                            <p class="footer-links"><a href="" target="_blank"><span class="footer-link"><i class="fa-solid fa-envelope"></i> cfxsupport@gmail.com<br></span></a><a href=""><span class="footer-link"><i class="fa-solid fa-phone"></i> +977 01577257<br></span></a><a href=""><span class="footer-link"><i class="fa-brands fa-facebook"></i> Facebook</span></a><span><br></span><a href=""><span class="footer-link"><i class="fa-brands fa-x-twitter"></i> Twitter<br></span></a><a href=""><span class="footer-link"><i class="fa-brands fa-square-instagram"></i> Instagram<br></span></a><strong><br></strong></p>
                          </div>
                          <div class="w-col w-col-5 w-col-small-6 w-col-tiny-5">
                            <h3 class="footer-titles">Join a Newsletter</h3><br><br>
                            <p class="newsletter-footer">Your Email</p><br>
                            <form>
                                <input id="form-email"  type="email" placeholder="example@gmail.com"><br><br>
                                <button class="btn-email" type="submit">Subscribe</button>
                            </form>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
<script type="text/javascript" src="home.js"></script>
<script>
    const toggleBtn = document.querySelector('.toggle')
    const toggleBtnIcon = document.querySelector('.toggle i')
    const dropdown = document.querySelector('.dropdown')

    toggleBtn.onclick = function(){
        dropdown.classList.toggle('open')

        toggleBtnIcon.classList = isOpen
        ? 'fa-solid fa-xmark'
        : 'fa-solid fa-bars'
    }

    let profileDropdownList = document.querySelector(".profile-dropdown-list");
    let btn = document.querySelector(".profile-dropdown-btn");

    let classList = profileDropdownList.classList;

    const toggle = () => classList.toggle("active");

    window.addEventListener("click", function (e) {
    if (!btn.contains(e.target)) classList.remove("active");
});



</script>
</body>
</html>

