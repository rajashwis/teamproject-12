<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>

    </head>
        <link rel="stylesheet" href="navbar.css">
    <body>
        <div class="home-page">
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

        </div>

        <script type="text/javascript" src="navbar.js"></script>
        <script>
            const toggleBtn = document.querySelector(".toggle");
            const toggleBtnIcon = document.querySelector(".toggle i");
            const dropdown = document.querySelector(".dropdown");

            toggleBtn.onclick = function () {
                dropdown.classList.toggle("open");

                toggleBtnIcon.classList = isOpen
                    ? "fa-solid fa-xmark"
                    : "fa-solid fa-bars";
            };

            let profileDropdownList = document.querySelector(
                ".profile-dropdown-list"
            );
            let btn = document.querySelector(".profile-dropdown-btn");

            let classList = profileDropdownList.classList;

            const toggle = () => classList.toggle("active");

            window.addEventListener("click", function (e) {
                if (!btn.contains(e.target)) classList.remove("active");
            });
        </script>
    </body>
</html>
