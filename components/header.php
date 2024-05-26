<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 

    if (isset($_GET['searchTerm'])) {
        $searchTerm = $_GET['searchTerm'];
        header('Location: ../search_and_sort/search_and_sort.php?searchTerm='.$searchTerm.'');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<style>
*{
    margin: 0;
    padding: 0;
    scroll-behavior: smooth;
}


.navbar{
    position: fixed;
    overflow: hidden;
    height: 70px;
    width: 100%;
    top: 0%;
    /* background-image: url('footer.jpg'); */
    background-color: #000000;
    background-size: 29%;
    display: block;
    transition: top 0.3s;
    z-index: 3;
}

.logo{
    position: absolute;
    height: 102px;
    top: -20%;
    right: 92%;
}

.navbar ul{
    padding: 28px 40px;
}

.navbar ul li{
    text-indent: 30px;
    display: inline-block;
    color: white;
}

.navbar ul li a{
    text-decoration: none;
    color: rgb(255, 255, 255);
    font-size: 13px;
    font-family:"Sofia", sans-serif;
}

.navbar ul li a.active,
.navbar ul li a:hover{
    color: red;
}

/*search bar*/
.search {
    width: 250%;
    position: relative;
    display: flex;
    left: -49%;
}
  
.searchTerm {
    width: 60%;
    border: 3px solid rgb(255, 255, 255);
    border-right: none;
    padding: 2px;
    border-radius: 20px 0px 0px 20px;
    outline: none;
    color: #9DBFAF;
    height: 25px;
}
  
.searchTerm:focus{
    color: #000000;
}
  
.searchButton {
    width: 40px;
    border: 1px solid #f99f1b;
    background-color: #f99f1b;
    text-align: center;
    color: #fff;
    border-radius: 0 20px 20px 0;
    cursor: pointer;
    font-size: 20px;
}


.search-bar{
    width: 30%;
    position: absolute;
    top: 50%;
    left: 55%;
    transform: translate(-50%, -50%);
}
  
.search-btn-e button{
      background-color: greenyellow;
}

.profile-dropdown {
    position: absolute;
    width: fit-content;
    top: 15%;
    right: 9%;
    color: white;
    font-family:"Sofia", sans-serif;
  }
  
  .profile-dropdown-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-right: 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    width: 150px;
    border-radius: 50px;
    color: black;
    background-color: white;  
    cursor: pointer;
    transition: box-shadow 0.2s ease-in, background-color 0.2s ease-in,
      border 0.3s;
  }
  
  .profile-dropdown-btn:hover {
    background-color: #f99f1b;
  }
  
  .profile-img {
    position: relative;
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    background: url('../resources/dummy-images/default-profile.jpg');
    background-size: cover;
  }
  
  .profile-img i {
    position: absolute;
    right: 0;
    bottom: 0.3rem;
    font-size: 0.5rem;
    color: green;
  }
  
  .profile-dropdown-btn span {
    margin: 0 0.5rem;
    margin-right: 0;
  }
  
  .profile-dropdown-list {
    position: fixed;
    top: 8%;
    width: 220px;
    right: 7.5%;
    background-color: white;
    border-radius: 10px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s;
    z-index: 999;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    font-family: "Sofia", sans-serif;
  }
  
  .profile-dropdown-list hr {
    border: 0.5px solid black;
  }
  
  .profile-dropdown-list.active {
    max-height: 500px;
  }
  
  .profile-dropdown-list-item {
    padding: 0.5rem 0rem 0.5rem 1rem;
    transition: background-color 0.2s ease-in, padding-left 0.2s;
  }
  
  .profile-dropdown-list-item a {
    display: flex;
    align-items: center;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--black);
  }
  
  .profile-dropdown-list-item a i {
    margin-right: 0.8rem;
    font-size: 1.1rem;
    width: 2.3rem;
    height: 2.3rem;
    background-color: var(--secondary);
    color: var(--white);
    line-height: 2.3rem;
    text-align: center;
    margin-right: 1rem;
    border-radius: 50%;
  }


  .profile-dropdown-list-item button{
    border: none;
    background-color: transparent;
    cursor: pointer;
  }

  .profile-dropdown-list-item button i{
    margin-right: 0.8rem;
    font-size: 1.1rem;
    width: 2.3rem;
    height: 2.3rem;
    background-color: var(--secondary);
    color: var(--white);
    line-height: 2.3rem;
    text-align: center;
    margin-right: 1rem;
    border-radius: 50%;
  }
  
  .profile-dropdown-list-item:hover {
    background-color: #f99f1b;
  }


.logout{
    position: absolute;
    top: 40%;
    right: 13%;
    color: white;
    font-family:"Sofia", sans-serif;
}



.signin{
    position: absolute;
    top: 27%;
    right: 11%;
}

.btn{
    padding: 10px;
    border: none;
    background-color: transparent;
    font-size: 15px;
    cursor:pointer;
}

.btn i{
    color: white;
}

.btn a{
    color: white;
}

.btn :hover{
    color: red;
}

.signup{
    position: absolute;
    top: 27%;
    right: 6%;
}

.btn-2{
    padding: 10px;
    border: none;
    border-radius: 20px;
    background-color: #f99f1b;
    color: white;
    font-size: 15px;
    cursor: pointer;
}

.btn-2 a{
    color: white;
}

.btn-2 :hover{
   color: #000000;
}

.basket{
    position: absolute;
    left: 97%;
    top: 30%;
    transition: transform .2s; 
}

.basket :hover{
    transform: scale(1.1);
}

/*NAV 2*/
.navbar2 {
    position: fixed;
    overflow: hidden;
    height: 65px;
    width: 100%;
    top: 8%;
    /* background-image: url('footer.jpg'); */
    background-color: #000000;
    background-size: 29%;
    position: fixed;
    display: block;
    transition: top 0.3s;
    z-index: 2;
}

.navbar2 ul {
    padding: 23px;
    text-align: center;
    position: relative;
    left: -3px;
    margin: 0;
}

.navbar2 ul li {
    text-indent: 50px;
    display: inline-block;
}

.navbar2 ul li a {
    text-decoration: none;
    color: rgb(255, 255, 255);
    font-size: 15px;
    font-family: "Sofia", sans-serif;
    padding: 15px;
    position: relative;
}

.navbar .toggle{
    color: rgb(255, 255, 255);
    position: relative;
    margin-left: 97%;
    margin-top: 26px;
    cursor: pointer;
    display: none;
}

/* .navbar2 ul li a img{
    height: 15px;
    scale: 1.4;
    position: relative;
} */


.navbar2 ul li a.active,
.navbar2 ul li a:hover {
    color: #f99f1b;
}

.home-split{
    position: relative;
    right: 5%;
}

.bs-split{
    position: relative;
    left: 5%;
}

.dropdown{
    display: none;
    position: fixed;
    right: 1rem;
    top: 80px;
    width: 300px;
    height: 0;
    background: rgb(255, 255, 255);
    backdrop-filter: blur(15px);
    border-radius: 10px;
    overflow: hidden;
    transition: height 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    z-index: 1;
}

.dropdown.open{
    height: 410px;
}

.dropdown ul li a{
    text-decoration: none;
    color: rgb(0, 0, 0);
    font-size: 15px;
    font-family: "Sofia", sans-serif;
    padding: 15px;
    display: flex;
    padding: 0.7rem;
    align-items: center;
    justify-content: center;
}

.dropdown ul li a:hover{
    background-color: #f99f1b;
    border-radius: 10px;
}

/*responsive*/

@media (max-width: 1280px){
    .navbar .user-box,
    .navbar .basket,
    .navbar2{
        display: none;
    }

    .navbar .logo{
        position: absolute;
        height: 102px;
        top: -20%;
        right: 90%;
    }

    .navbar .toggle{
        display: block;
    }

    .dropdown{
        display: block;
    }

}

@media (max-width: 1024px){
    .navbar .user-box,
    .navbar .basket,
    .navbar2{
        display: none;
    }

    .navbar .logo{
        position: absolute;
        height: 102px;
        top: -20%;
        right: 87%;
    }

    .navbar .toggle{
        display: block;
    }

}

@media (max-width: 768px){
    .navbar .user-box,
    .navbar .basket,
    .navbar2{
        display: none;
    }

    .navbar .logo{
        position: absolute;
        height: 102px;
        top: -20%;
        right: 84%;
    }

    .navbar .toggle{
        display: block;
        margin-left: 96%;
    }

}

@media (max-width: 640px){
    .navbar .user-box,
    .navbar .basket,
    .navbar2{
        display: none;
    }

    .navbar .logo{
        position: absolute;
        height: 102px;
        top: -20%;
        right: 82%;
    }

    .navbar .toggle{
        display: block;
        margin-left: 95%;
    }

}

@media (max-width: 475px){
    .navbar .user-box,
    .navbar .basket,
    .navbar2{
        display: none;
    }

    .navbar .logo{
        position: absolute;
        height: 102px;
        top: -20%;
        right: 75%;
    }

    .navbar .toggle{
        display: block;
        margin-left: 94%;
    }

}

</style>
<body>

<!--navbar-->
<div class="navbar" id="nav">
            <nav>
                    <img class="logo" src="../resources/cfxlocalhubwhitelogo.png">
            
                    <div class="search-bar">
                        <form method="GET">
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
                        <form action="signin.html" method="get">
                            <button class="btn">
                                <u><i class="fa-solid fa-user"></i>
                                    <a href="../signin/signin.html"> Sign In</a>
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
                            <a href="../cart/cart.php"><img src="../resources/trolley.png" height="30px"></a>
                        </div>
                <div class="toggle"><i class="fa-solid fa-bars"></i></div>
            </nav> 
            
        </div>
        <div class="profile-drop">
            <ul class="profile-dropdown-list">
            <li class="profile-dropdown-list-item">
                <a href="../customer/customer_profile.php">
                <i class="fa-regular fa-user"></i>
                Edit Profile
                </a>
            </li>

            <li class="profile-dropdown-list-item">
                <a href="../customer/wishlist.php">
                <i class="fa-regular fa-bookmark"></i>
                Wishlist
                </a>
            </li>

            <li class="profile-dropdown-list-item">
                <a href="../customer/customer_review.php">
                <i class="fa-solid fa-star-half-stroke"></i>
                My Reviews
                </a>
            </li>
            <hr>

            <li class="profile-dropdown-list-item">
            <form action="../sign_out.php" method="post">
                <button type="submit">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout</a>
                </button>
            </form>
            </li>
            </ul>
        </div>

        <div class="dropdown">
            <ul>
                <li><a href="../homepage/home.php">HOME</a></li>
                <!-- <li><a href="../trending.html"> TRENDING</a></li> -->
                <li><a href="../search_and_sort/shop.php?sort-products=default"> SHOPS</a></li>
                <li><a href="../search_and_sort/sort_category.php?sort-products=default"> CATEGORIES</a></li>
                <li><a href="../search_and_sort/sort_discount.php?sort-products=default"> DISCOUNT</a></li>
                <li><a href="../components/aboutus.html"> ABOUT</a></li>
                <li><a href="../trader_dashboard/trader_signin.html"> BECOME A SELLER</a></li>
                <li><a href="../signin/signin.html">Sign In</a></li>
                <li><a href="../signup/signup.html">Sign Up</a></li>
                <li><a href=""><img src="../resources/trolley.png" height="30px"></a></li>
            </ul>
        </div>
        <!-- navbar 2-->
        <div class="navbar2" id="nav2">
            <nav>
                <ul>
                    <li class="home-split"><a class="active" href="../homepage/home.php"> HOME</a></li>
                    <!-- <li><a href="#"> TRENDING</a></li> -->
                    <li><a href="../search_and_sort/shop.php?sort-products=default"> SHOPS</a></li>
                    <li><a href="../search_and_sort/sort_category.php?sort-products=default"> CATEGORIES</a></li>
                    <li><a href="../search_and_sort/sort_discount.php?sort-products=default"> DISCOUNTS</a></li>
                    <li><a href="../components/aboutus.html"> ABOUT</a></li>
                    <li class="bs-split"><a href="../trader_dashboard/trader.php"> BECOME A SELLER</a></li>
                </ul>
                
            </nav>
        </div> 

        <script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.querySelector('.toggle');
        const toggleBtnIcon = document.querySelector('.toggle i');
        const dropdown = document.querySelector('.dropdown');

        toggleBtn.onclick = function () {
            dropdown.classList.toggle('open');
            toggleBtnIcon.classList = dropdown.classList.contains('open')
                ? 'fa-solid fa-xmark'
                : 'fa-solid fa-bars';
        };

        let profileDropdownList = document.querySelector(".profile-dropdown-list");
        let btn = document.querySelector(".profile-dropdown-btn");

        const toggle = () => profileDropdownList.classList.toggle("active");

        btn.addEventListener("click", toggle);

        window.addEventListener("click", function (e) {
            if (!btn.contains(e.target)) {
                profileDropdownList.classList.remove("active");
            }
        });

        //**NAVBAR**//
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;

            /*FOR NAVBAR 1*/
            // if (prevScrollpos > currentScrollPos) {
            //     document.getElementById("nav").style.top = "0";
            // } else {
            //     document.getElementById("nav").style.top = "-190px";
            // }

            /*FOR NAVBAR 2*/
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("nav2").style.top = "8%";
            } else {
                document.getElementById("nav2").style.top = "-10px";
            }
            prevScrollpos = currentScrollPos;
        };
    });
</script>

</body>

</html>