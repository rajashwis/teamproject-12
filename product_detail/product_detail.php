
<?php


    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id'];
    $cart_id = $_SESSION['cart_id'];
    $wishlist_id = $_SESSION['wishlist_id'];

    if (isset($_SESSION['cart_product_added']) && $_SESSION['cart_product_added'] === true) {
        echo "<script>alert('Product Added to Cart!')</script>";
        unset($_SESSION['cart_product_added']);
    }

    if (isset($_SESSION['wishlist_product_added']) && $_SESSION['wishlist_product_added'] === true) {
        echo "<script>alert('Product Added to Wishlist!')</script>";
        unset($_SESSION['wishlist_product_added']);
    }

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        $query="SELECT * from PRODUCT WHERE product_id = $product_id";
        $stid=oci_parse($connection, $query);
        oci_execute($stid);
        $product = oci_fetch_assoc($stid);
        $category_id = $product['CATEGORY_ID'];
        $shop_id = $product['SHOP_ID'];

        $query1 = "SELECT * FROM PRODUCTCATEGORY WHERE category_id = $category_id";
        $stid1=oci_parse($connection, $query1);
        oci_execute($stid1);
        $category = oci_fetch_assoc($stid1);

        $query2 = "SELECT * FROM SHOP WHERE shop_id = $shop_id";
        $stid2=oci_parse($connection, $query2);
        oci_execute($stid2);
        $shop = oci_fetch_assoc($stid2);

        if (isset($_POST['add_to_cart'])) {

            if(!$user) {
                header('LOCATION: ../login/login.html');
            }
    
            else {
                $quantity = $_POST['quantity'];
    
                $query1 = "SELECT PRODUCT_ID FROM CARTPRODUCT WHERE CART_ID = $cart_id AND PRODUCT_ID = $product_id";
                $stid1=oci_parse($connection, $query1);
                oci_execute($stid1);
                $row = oci_fetch_assoc($stid1);
    
                if($row) {
                    echo "<script>alert('Product already in Cart!')</script>";
                }
    
                else {
                    $query1="INSERT INTO CARTPRODUCT VALUES (SEQ_CARTPRODUCT_ID.NEXTVAL, $cart_id, $product_id, $quantity)";
                    $stid1=oci_parse($connection, $query1);
                    
                    if(oci_execute($stid1)) {
                        $_SESSION['cart_product_added'] = true;
                        header("LOCATION: ../product_detail/product_detail.php?product_id=$product_id");
                    }
                    
                }
                
            }
    
        }
    
        if (isset($_POST['wishlist_button'])) {
    
            if(!$user) {
                header('LOCATION: ../login/login.html');
            }
    
            else {
    
                $query1 = "SELECT PRODUCT_ID FROM WISHLISTPRODUCT WHERE PRODUCT_ID = $product_id AND WISHLIST_ID = $wishlist_id";
                $stid1=oci_parse($connection, $query1);
                oci_execute($stid1);
                $row = oci_fetch_assoc($stid1);
    
                if($row) {
                    echo "<script>alert('Product already in Wishlist!')</script>";
                }
    
                else {
                    $query1 = "INSERT INTO WISHLISTPRODUCT VALUES (SEQ_WISHLISTPRODUCT_ID.NEXTVAL, $wishlist_id, $product_id)";
                    $stid1=oci_parse($connection, $query1);
                    
                    if(oci_execute($stid1)) {
                        $_SESSION['wishlist_product_added'] = true;
                        header("LOCATION: ../product_detail/product_detail.php?product_id=$product_id");
                    }
                    
                }
                
            }
    
        }

    }

    else {
        header('location: ../homepage/home.php');
    }
    
    
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="product_detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                        echo

                            '<div class="profile-dropdown">
                        <div onclick="toggle()" class="profile-dropdown-btn">
                        <div class="profile-img">
                            <i class="fa-solid fa-circle"></i>
                        </div>

                        <span>
                        ' . $_SESSION['username'] . ' <i class="fa-solid fa-angle-down"></i>
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

   


    <main class="main">
         <!-- DEEPA Front end -->
        <div class="container">
            <div class="product-details">
                <div class="image-container">
                    <!---IMAGE--->
                    <?php
                        $imageData = $product['PRODUCT_IMAGE']->load();
                        $encodedImageData = base64_encode($imageData);
                        // Determine the image type based on the first few bytes of the image data
                        $header = substr($imageData, 0, 4);
                        $imageType = 'image/jpeg'; // default to JPEG
                        if (strpos($header, 'FFD8') === 0) {
                            $imageType = 'image/jpeg'; // JPEG
                        } elseif (strpos($header, '89504E47') === 0) {
                            $imageType = 'image/png'; // PNG
                        }

                        echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';

                    ?>
                </div>
                <form method="POST">
                    <button class="wishlist-btn" type="submit" name="wishlist_button">&#10084;</button>
                </form>
                <div class="content">
                    <?php
                        echo '<h2>'.$product['PRODUCT_NAME'].'</h2>';
                        echo '<p>'.$product['DESCRIPTION_'].'</p>';
                        echo '<p> Store: '.$shop['SHOP_NAME'].'</p>';
                        echo '<p>Price: '.$product['PRICE'].'</p>';
                        echo '<form method="POST">';
                        echo '<div class="quantity-input">';
                        echo '<label for="quantity">Quantity:</label>';
                        echo '<div class="quantity-control">';
                        echo '<button class="minus-btn" id="minusBtn">-</button>';
                        echo '<input type="number" id="quantity" name="quantity" value="1" min="1">';
                        echo '<button class="plus-btn" id="plusBtn">+</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<input type="submit" class = "add-to-cart-btn" value="Add to Cart" name="add_to_cart">';
                        echo '</form>';
                    ?>
                </div>
            </div>
        </div>  


        <div class="customer-reviews-container">


            <div class="rating">
                <p>Rating 5.0 </p>
                <div class="rating-row">
                    <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                </div>
            </div>


            <hr class="comment-line">
                <div class="comments">
                    <div class="customer-profile">
                        <div class="profile-img">
                            <img src="../resources/user.jpg" alt="profile-img">
                        </div>
                        <h5 class="customer-name">John Doe</h5>
                    </div>
                    <div class="customer-ratings">
                        <h5>Rate:</h5>
                        <div class="rating-rows">
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="comment-text">
                        <p>This is the user review for the elit. Illo culpa eligendi quibusdam vel consequuntur, non dicta nulla exercitationem! Laudantium libero quos rem perferendis mollitia beatae sequi laborum consequatur neque sunt recusandae, voluptate blanditiis. Consequuntur, sed? Aperiam  asperiores?</p>
                    </div>
                </div>

                <div class="comments">
                    <div class="customer-profile">
                        <div class="profile-img">
                            <img src="../resources/user.jpg" alt="profile-img">
                        </div>
                        <h5 class="customer-name">John Doe</h5>
                    </div>
                    <div class="customer-ratings">
                        <h5>Rate:</h5>
                        <div class="rating-rows">
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="comment-text">
                        <p>This is the user review for the product Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cupiditate voluptatem molestiae vel accusantium sequi dolorum dicta officiis, quibusdam aperiam exercitationem.culpa eligendi quibusdam vel consequuntur, non dicta nulla exercitationem! Laudantium libero quos rem perferendis mollitia beatae sequi laborum consequatur neque sunt recusandae, voluptate blanditiis. Consequuntur, sed? Aperiam  asperiores?</p>
                    </div>
                </div>



            <div class="comments">
                <div class="customer-profile">
                    <div class="profile-img">
                        <img src="../resources/user.jpg" alt="profile-img">
                    </div>
                    <h5 class="customer-name">John Doe</h5>
                </div>
                <div class="customer-ratings">
                    <h5>Rate:</h5>
                    <div class="rating-rows">
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    </div>
                </div>
                <div class="comment-box">
                    <textarea placeholder="Add your comment here..."></textarea>
                    <button class="add-comment-btn">Add Comment</button>
                </div>
            </div>
        </div>
    </main>

   




    <!--For you-->
    <div class="for-you">
        <!--footer-->
        <div class="footer-background">
            <div class="container-footer w-container">
                <div class="w-row">
                    <div class="footer-column w-clearfix w-col w-col-4"><img src="../resources/cfxlocalhubwhitelogo.png"
                            alt="" width="40" class="failory-logo-image">
                        <h3 class="footer-failory-name">CFXLocalHub</h3>
                        <p class="footer-description-failory">Best Shopping Online!<br></p>
                    </div>
                    <div class="footer-column w-col w-col-8">
                        <div class="w-row">
                            <div class="w-col w-col-8">
                                <div class="w-row">
                                    <div class="w-col w-col-7 w-col-small-6 w-col-tiny-7">
                                        <h3 class="footer-titles">Get in touch</h3><br>
                                        <p class="footer-links"><a href="" target="_blank"><span class="footer-link"><i
                                                        class="fa-solid fa-envelope"></i>
                                                    cfxsupport@gmail.com<br></span></a><a href=""><span
                                                    class="footer-link"><i class="fa-solid fa-phone"></i> +977
                                                    01577257<br></span></a><a href=""><span class="footer-link"><i
                                                        class="fa-brands fa-facebook"></i>
                                                    Facebook</span></a><span><br></span><a href=""><span
                                                    class="footer-link"><i class="fa-brands fa-x-twitter"></i>
                                                    Twitter<br></span></a><a href=""><span class="footer-link"><i
                                                        class="fa-brands fa-square-instagram"></i>
                                                    Instagram<br></span></a><strong><br></strong></p>
                                    </div>
                                    <div class="w-col w-col-5 w-col-small-6 w-col-tiny-5">
                                        <h3 class="footer-titles">Join a Newsletter</h3><br><br>
                                        <p class="newsletter-footer">Your Email</p><br>
                                        <form>
                                            <input id="form-email" type="email" placeholder="example@gmail.com"><br><br>
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


    <script type="text/javascript" src="product_details.js"></script>
    <script>
        const toggleBtn = document.querySelector('.toggle')
        const toggleBtnIcon = document.querySelector('.toggle i')
        const dropdown = document.querySelector('.dropdown')

        toggleBtn.onclick = function () {
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