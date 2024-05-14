<?php

session_start();
error_reporting(0);

include "../connect.php";

$user = $_SESSION['user_id']; 
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="home.css">
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
                            if(isset($user) && isset($username)) {
                        echo
                        
                    '<div class="profile-dropdown">
                        <div onclick="toggle()" class="profile-dropdown-btn">
                        <div class="profile-img">
                            <i class="fa-solid fa-circle"></i>
                        </div>

                        <span>
                        '. $username . ' <i class="fa-solid fa-angle-down"></i>
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

        <!--products-->
        <div class="container">
            <div class="card">
                <div class="image-container">
                    <?php
                        $query="SELECT * from PRODUCT WHERE product_id = 15";
                        $stid=oci_parse($connection, $query);
                        oci_execute($stid);
                        $row = oci_fetch_assoc($stid);
                        $product_id = $row['PRODUCT_ID'];
                        
                        $category_id = $row['CATEGORY_ID'];
                        $query1 = "SELECT * FROM PRODUCTCATEGORY WHERE category_id = $category_id";
                        $stid1=oci_parse($connection, $query1);
                        oci_execute($stid1);
                        $category = oci_fetch_assoc($stid1);

                        $imageData = $row['PRODUCT_IMAGE']->load();

                        $encodedImageData = base64_encode($imageData);
            
                        // Determine the image type based on the first few bytes of the image data
                        $header = substr($imageData, 0, 4);
                        $imageType = 'image/jpeg'; // default to JPEG
                        if (strpos($header, 'FFD8') === 0) {
                            $imageType = 'image/jpeg'; // JPEG
                        } elseif (strpos($header, '89504E47') === 0) {
                            $imageType = 'image/png'; // PNG
                        }

                        echo '<a href="../product_detail/product_detail.php?product_id='.$product_id.'">';
                        echo '<td><img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"></td>';
                        echo '<h1>'.$row['PRODUCT_NAME'].'</h1>';
                        echo '<p class="price">'.$row['PRICE'].'<i class="fa-solid fa-tag"></i></p>';
                        echo '<p>'.$category['CATEGORY_NAME'].'</p>';
                    ?>
                </div>
                <p><button>Buy</button></p><br>
            </div>
        </div>
        <!--slide-->
        <div class="slideshow-container">
            <div class="slides">
              <img src="../resources/slide_img1.jpg" alt="Image 1">
              <img src="../resources/slide_img2.jpg" alt="Image 2">
              <img src="../resources/slide-img3.jpg" alt="Image 3">
            </div>
            <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
            <button class="next" onclick="plusSlides(1)">&#10095;</button>
        </div>
    </div>
    <!--Sales-->
    <div class="home-page2">
        <label class="text-sales">Sales:</label>
        <div class="container-4">
            <div class="card-4">
                <div class="image-container">
                    <img src="../resources/products/jordan.jpg" alt="jordan-shoe">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        
            <div class="card-4">
                <div class="image-container">
                    <img src="../resources/products/watch.jpg" alt="watch">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        
            <div class="card-4">
                <div class="image-container">
                    <img src="../resources/products/airpod.jpg" alt="airpod">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        </div>
        
    </div>
    <!--New-->
    <div class="new-item">
        <label class="text-new">New:</label>
        <div class="box">
            <div class="card-5">
                <img src="../resources/products/watch.jpg" alt="jordan" style="width:100%"><br><br>
            </div>

            <div class="card-5">
                <img src="../resources/products/watch.jpg" alt="jordan" style="width:100%"><br><br>
            </div>

            <div class="card-5">
                <img src="../resources/products/watch.jpg" alt="jordan" style="width:100%"><br><br>
            </div>
        </div>    
    </div>
    <!--For you-->
    <div class="for-you">
        <label class="text-foryou">For You:</label>
        <div class="container-5">
            <div class="card-6">
                <div class="image-container">
                    <img src="../resources/products/jordan.jpg" alt="jordan">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        
            <div class="card-6">
                <div class="image-container">
                    <img src="../resources/products/watch.jpg" alt="jordan">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        
            <div class="card-6">
                <div class="image-container">
                    <img src="../resources/products/airpod.jpg" alt="jordan">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>

            <div class="card-6">
                <div class="image-container">
                    <img src="../resources/products/jordan.jpg" alt="jordan">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        
            <div class="card-6">
                <div class="image-container">
                    <img src="../resources/products/watch.jpg" alt="jordan">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        
            <div class="card-6">
                <div class="image-container">
                    <img src="../resources/products/airpod.jpg" alt="jordan">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        </div>
            <br><br><br><br><br><br><br><br><br><br><br>
            <!--map-->
            <div class="location">
                <p><i class="fa-solid fa-location-dot"></i> Location</p><br>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d44Supportlogou1.60166153526745!2d85.31895302088176!3d27.692164950951184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1711632997867!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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

