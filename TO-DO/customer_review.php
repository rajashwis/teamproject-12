<?php

session_start();
error_reporting(0);

include "../connect.php";

$user = $_SESSION['user_id']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="customer_review.css">
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
                        '. $_SESSION['username'] . ' <i class="fa-solid fa-angle-down"></i>
                        </span>
                        </div>
                    </div>';
                    } else {
                        // If user is not logged in, display sign in and sign up buttons
                        echo '<div class="signin">
                        <form action="login.html" method="get">
                            <button class="btn">
                                <u><i class="fa-solid fa-user"></i>
                                    <a href="../login/login.html"> Sign In</a>
                                </u>
                            </button>    
                        </form>
                    </div>
                    <div class="signup">
                        <form action="signup.html" method="get">
                            <button class="btn-2">
                                <a href="../signup/signup.html"> Sign Up</a>
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
                <i class="fa-solid fa-sliders"></i>
                Settings
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
            <form action="../sign out.php" method="post">
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
                <li><a href="decor.html"> HOME & DECOR</a></li>
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
                    <li><a href="decor.html"> HOME & DECOR</a></li>
                    <li><a href=""> ELECTRONICS</a></li>
                    <li><a href=""> FASHION</a></li>
                    <li><a href=""> SALES</a></li>
                    <li class="bs-split"><a href="seller.html"> BECOME A SELLER</a></li>
                </ul>
                
            </nav>
        </div> 
        
    </div>
       

        <!--MY REVIEW DEEPA FRONTEND-->
        <h2 class="heading">MY REVIEWS</h2>
        <div class="container">
            <div class="menu">
                <ul>
                    <li><a href="">My Profile</a></li>
                    <li><a href="" >My Order</a></li>
                    <li><a href="" >My Wishlist</a></li>
                    <li><a class="active" href="" >Reviews</a></li>
                </ul>
            </div>
            <div class="cart-heading">
                <!-- first -->
                <div class="product-item">
                    <img src="../resources/products/jordan.jpg" alt="Product Image">
                    <div class="product-details">
                        <h3>Product Name</h3>
                        <p>Shop Name</p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                    <div class="additional-info">
                        <p>“The product quality is consistently outstanding, exceeding my expectations every time.”</p>
                        <div class="additional-info-ctrl">
                            <button class="edit">Edit</button>
                            <button class="delete">Delete</button>
                        </div>
                    </div>
                </div>
                 <!-- second -->
                <div class="product-item">
                    <img src="../resources/products/airpod.jpg" alt="Product Image">
                    <div class="product-details">
                        <h3>Product Name</h3>
                        <p>Shop Name</p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                    <div class="additional-info">
                        <p>“The product quality is consistently outstanding, exceeding my expectations every time. Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus ipsum, provident tempora consectetur error ea repudiandae nihil. Illo sed quod fuga qui.”</p>
                        <div class="additional-info-ctrl">
                            <button class="edit">Edit</button>
                            <button class="delete">Delete</button>
                        </div>
                       
                    </div>
                </div>
                <!-- third -->
                <div class="product-item">
                    <img src="../resources/products/airpod.jpg" alt="Product Image">
                    <div class="product-details">
                        <h3>Product Name</h3>
                        <p>Shop Name</p>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                    <div class="additional-info">
                        <p>“The product quality is consistently outstanding, exceeding my expectations every time.”</p>
                        <div class="additional-info-ctrl">
                            <button class="edit">Edit</button>
                            <button class="delete">Delete</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    


    <!--New-->
 



    <!--For you-->
    <div class="for-you">
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
<script type="text/javascript" src="customer_review.js"></script>


</script>
</body>
</html>

