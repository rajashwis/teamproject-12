<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="catalog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>CFXLocalHub HOME PAGE</title>
</head>
    <body>
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
        
    </body>
</html>