<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navbar</title>
</head>


<style>
    * {
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }

    .home-page {
        background-size: cover;
        /* height: 100vh; */
        background-color: aliceblue;
    }

    .navbar {
        position: fixed;
        overflow: hidden;
        height: 70px;
        width: 100%;
        top: 0%;
        background-color: #000000;
        background-size: 29%;
        display: block;
        transition: top 0.3s;
        z-index: 3;
    }

    .logo {
        position: absolute;
        height: 102px;
        top: -20%;
        right: 92%;
    }

    .navbar ul {
        padding: 28px 40px;
    }

    .navbar ul li {
        text-indent: 30px;
        display: inline-block;
        color: white;
    }

    .navbar ul li a {
        text-decoration: none;
        color: rgb(255, 255, 255);
        font-size: 13px;
        font-family: "Sofia", sans-serif;
    }

    .navbar ul li a.active,
    .navbar ul li a:hover {
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
        height: 15px;
        border-radius: 20px 0px 0px 20px;
        outline: none;
        color: #9DBFAF;
        height: 25px;
    }

    .searchTerm:focus {
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

    .search-bar {
        width: 30%;
        position: absolute;
        top: 50%;
        left: 55%;
        transform: translate(-50%, -50%);
    }

    .search-btn-e button {
        background-color: greenyellow;
    }

    .profile-dropdown {
        position: absolute;
        width: fit-content;
        top: 15%;
        right: 9%;
        color: white;
        font-family: "Sofia", sans-serif;
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
        box-shadow: var(--shadow);

        cursor: pointer;
        border: 1px solid var(--secondary);
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
        background: url('default-profile.jpg');
        background-size: cover;
    }

    .profile-img i {
        position: absolute;
        right: 0;
        bottom: 0.3rem;
        font-size: 0.5rem;
        color: var(--green);
    }

    .profile-dropdown-btn span {
        margin: 0 0.5rem;
        margin-right: 0;
    }

    .profile-dropdown-list {
        position: absolute;
        top: 8%;
        width: 220px;
        right: 7.5%;
        background-color: white;
        border-radius: 10px;
        max-height: 0;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: max-height 0.5s;
        z-index: 3;
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


    .profile-dropdown-list-item button {
        border: none;
        background-color: transparent;
        cursor: pointer;
    }

    .profile-dropdown-list-item button i {
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


    .logout {
        position: absolute;
        top: 40%;
        right: 13%;
        color: white;
        font-family: "Sofia", sans-serif;
    }



    .signin {
        position: absolute;
        top: 27%;
        right: 11%;
    }

    .btn {
        padding: 10px;
        border: none;
        background-color: transparent;
        color: white;
        font-size: 15px;
        cursor: pointer;
    }

    .btn :hover {
        color: red;
    }

    .signup {
        position: absolute;
        top: 27%;
        right: 6%;
    }

    .btn-2 {
        padding: 10px;
        border: none;
        border-radius: 20px;
        background-color: #f99f1b;
        color: white;
        font-size: 15px;
        cursor: pointer;
    }

    .btn-2 :hover {
        color: #000000;
    }

    .basket {
        position: absolute;
        left: 97%;
        top: 30%;
        transition: transform .2s;
    }

    .basket :hover {
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

    .navbar .toggle {
        color: rgb(255, 255, 255);
        position: relative;
        margin-left: 97%;
        margin-top: 26px;
        cursor: pointer;
        display: none;
    }

    .navbar2 ul li a img{
    height: 15px;
    scale: 1.4;
    position: relative;
    }


    .navbar2 ul li a.active,
    .navbar2 ul li a:hover {
        color: #f99f1b;
    }

    .home-split {
        position: relative;
        right: 5%;
    }

    .bs-split {
        position: relative;
        left: 5%;
    }

    .dropdown {
        display: none;
        position: absolute;
        right: 1rem;
        top: 80px;
        width: 300px;
        height: 0;
        background: rgba(0, 0, 0, 0.11);
        backdrop-filter: blur(15px);
        border-radius: 10px;
        overflow: hidden;
        transition: height 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 1;
    }

    .dropdown.open {
        height: 410px;
    }

    .dropdown ul li a {
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

    .dropdown ul li a:hover {
        background-color: #f99f1b;
        border-radius: 10px;
    }

    /*responsive*/

    @media (max-width: 1280px) {

        .navbar .user-box,
        .navbar .basket,
        .navbar2 {
            display: none;
        }

        .navbar .logo {
            position: absolute;
            height: 102px;
            top: -20%;
            right: 90%;
        }

        .navbar .toggle {
            display: block;
        }

        .dropdown {
            display: block;
        }

    }

    @media (max-width: 1024px) {

        .navbar .user-box,
        .navbar .basket,
        .navbar2 {
            display: none;
        }

        .navbar .logo {
            position: absolute;
            height: 102px;
            top: -20%;
            right: 87%;
        }

        .navbar .toggle {
            display: block;
        }

    }

    @media (max-width: 768px) {

        .navbar .user-box,
        .navbar .basket,
        .navbar2 {
            display: none;
        }

        .navbar .logo {
            position: absolute;
            height: 102px;
            top: -20%;
            right: 84%;
        }

        .navbar .toggle {
            display: block;
            margin-left: 96%;
        }

    }

    @media (max-width: 640px) {

        .navbar .user-box,
        .navbar .basket,
        .navbar2 {
            display: none;
        }

        .navbar .logo {
            position: absolute;
            height: 102px;
            top: -20%;
            right: 82%;
        }

        .navbar .toggle {
            display: block;
            margin-left: 95%;
        }

    }

    @media (max-width: 475px) {

        .navbar .user-box,
        .navbar .basket,
        .navbar2 {
            display: none;
        }

        .navbar .logo {
            position: absolute;
            height: 102px;
            top: -20%;
            right: 75%;
        }

        .navbar .toggle {
            display: block;
            margin-left: 94%;
        }

    }






    .footer-background {
        background-image: url('../resources/bluewallpaper.jpg');
    }

    div.container-footer.w-container {
        box-sizing: border-box;
        margin-left: auto;
        margin-right: auto;
        max-width: 900px;
        padding-bottom: 40px;
        padding-top: 70px;
    }

    div.container-footer.w-container:after {
        clear: both;
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.container-footer.w-container:before {
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.w-row {
        box-sizing: border-box;
        margin-left: -10px;
        margin-right: -10px;
    }

    div.w-row:after {
        clear: both;
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.w-row:before {
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.footer-column.w-clearfix.w-col.w-col-4 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 10px;
        padding-right: 10px;
        position: relative;
        width: 33.3333%;
    }

    div.footer-column.w-clearfix.w-col.w-col-4:after {
        clear: both;
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.footer-column.w-clearfix.w-col.w-col-4:before {
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    img.failory-logo-image {
        border-width: 0;
        box-sizing: border-box;
        display: inline-block;
        /* float: left; */
        height: 100px;
        width: 150px;
        vertical-align: middle;
    }

    h3.footer-failory-name {
        box-sizing: border-box;
        color: #FFFFFF;
        display: block;
        font-family: Lato, sans-serif;
        font-size: 20px;
        font-weight: 900;
        line-height: 1.1em;
        margin-bottom: 10px;
        margin-left: 10px;
        margin-top: 24px;
    }

    p.footer-description-failory {
        box-sizing: border-box;
        color: rgba(255, 255, 255, 0.8);
        display: block;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 300;
        letter-spacing: .5px;
        line-height: 1.5em;
        margin-bottom: 16px;
        margin-top: 15px;
    }

    br {
        box-sizing: border-box;
    }

    div.footer-column.w-col.w-col-8 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 10px;
        padding-right: 10px;
        position: relative;
        width: 66.6667%;
    }

    div.w-col.w-col-8 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 0;
        padding-right: 0;
        position: relative;
        width: 66.6667%;
    }

    div.w-col.w-col-7.w-col-small-6.w-col-tiny-7 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 0;
        padding-right: 0;
        position: relative;
        width: 58.3333%;
    }

    h3.footer-titles {
        box-sizing: border-box;
        color: #FFFFFF;
        display: block;
        font-family: Lato, sans-serif;
        font-size: 15px;
        font-weight: 900;
        line-height: 1.1em;
        margin-bottom: 0;
        margin-left: 0;
        margin-top: 24px;
    }

    p.footer-links {
        box-sizing: border-box;
        color: rgba(255, 255, 255, 0.8);
        display: block;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 300;
        letter-spacing: .5px;
        line-height: 1.8em;
        margin-bottom: 16px;
        margin-top: 2px;
    }

    a {
        background-color: transparent;
        box-sizing: border-box;
        color: #FFFFFF;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 400;
        line-height: 1.2em;
        text-decoration: none;
    }

    a:active {
        outline: 0;
    }

    a:hover {
        outline: 0;
    }

    span.footer-link {
        box-sizing: border-box;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 300;
    }

    span.footer-link:hover {
        color: #FFFFFF;
        font-weight: 400;
    }

    span {
        box-sizing: border-box;
    }

    strong {
        box-sizing: border-box;
        font-weight: 700;
    }

    div.w-col.w-col-5.w-col-small-6.w-col-tiny-5 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 0;
        padding-right: 0;
        position: relative;
        width: 41.6667%;
    }

    div.column-center-mobile.w-col.w-col-4 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 0;
        padding-right: 0;
        position: relative;
        width: 33.3333%;
    }

    a.footer-social-network-icons.w-inline-block {
        background-color: transparent;
        box-sizing: border-box;
        color: #FFFFFF;
        display: inline-block;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 400;
        line-height: 1.2em;
        margin-right: 8px;
        margin-top: 10px;
        max-width: 100%;
        opacity: .8;
        text-decoration: none;
    }

    a.footer-social-network-icons.w-inline-block:active {
        outline: 0;
    }

    a.footer-social-network-icons.w-inline-block:hover {
        opacity: 1;
        outline: 0;
    }

    img {
        border-width: 0;
        box-sizing: border-box;
        display: inline-block;
        max-width: 100%;
        vertical-align: middle;
    }

    p.footer-description {
        box-sizing: border-box;
        color: rgba(255, 255, 255, 0.8);
        display: block;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 300;
        letter-spacing: .5px;
        line-height: 1.5em;
        margin-bottom: 16px;
        margin-top: 15px;
    }

    strong.link-email-footer {
        box-sizing: border-box;
        font-weight: 700;
    }

    .newsletter-footer {
        color: rgb(141, 139, 139);
        font-family: Lato, sans-serif;

    }

    #form-email {
        height: 40px;
        width: 300px;
        border-radius: 2px;
        border: none;
        text-align: center;
    }

    .btn-email {
        background-color: #f99f1b;
        padding: 20px;
        width: 150px;
        border-radius: 8px;
        border: none;
    }

    @media (max-width: 1416px) {
        .card {
            background-color: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 450px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 20px;
            overflow: hidden;
            /* Hide overflowing content */
            height: 535px;
            /* Increased height */
            display: flex;
            /* Added flex display */
            flex-direction: column;
            /* Added column direction */
            justify-content: space-between;
            /* Space between elements */
        }

        .card-4 {
            background-color: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 20px;
            overflow: hidden;
            /* Hide overflowing content */
            height: 500px;
            /* Increased height */
            display: flex;
            /* Added flex display */
            flex-direction: column;
            /* Added column direction */
            justify-content: space-between;
            /* Space between elements */
        }




    }


    @media (max-width: 1275px) {
        .card {
            background-color: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 20px;
            overflow: hidden;
            /* Hide overflowing content */
            height: 500px;
            /* Increased height */
            display: flex;
            /* Added flex display */
            flex-direction: column;
            /* Added column direction */
            justify-content: space-between;
            /* Space between elements */
        }

    }

    @media (max-width: 1164px) {
        .card {
            background-color: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 20px;
            overflow: hidden;
            /* Hide overflowing content */
            height: 500px;
            /* Increased height */
            display: flex;
            /* Added flex display */
            flex-direction: column;
            /* Added column direction */
            justify-content: space-between;
            /* Space between elements */
        }
    }

    @media (max-width: 455px) {}
</style>
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
                    if (isset($user) && isset($username)) {
                        echo

                            '<div class="profile-dropdown">
                            <div onclick="toggle()" class="profile-dropdown-btn">
                            <div class="profile-img">
                                <i class="fa-solid fa-circle"></i>
                            </div>

                            <span>
                            ' . $username . ' <i class="fa-solid fa-angle-down"></i>
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

    <!-- <script type="text/javascript" src="navbar.js"></script> -->
    <script>
        //**NAVBAR**//
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function () {
            var currentScrollPos = window.pageYOffset;
            /*FOR NAVBAR 1*/
            // if (prevScrollpos > currentScrollPos) {
            // document.getElementById("nav").style.top = "0";
            // } else {
            // document.getElementById("nav").style.top = "-190px";
            // }
            /*FOR NAVBAR 2*/
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("nav2").style.top = "8%";
            } else {
                document.getElementById("nav2").style.top = "-10px";
            }
            prevScrollpos = currentScrollPos;
        }



        let slideIndex = 0;
        const slides = document.querySelector('.slides');
        const slideWidth = document.querySelector('.slides img').clientWidth;

        function showSlides() {
            slides.style.transform = `translateX(-${slideIndex * slideWidth}px)`;
        }

        showSlides();

        function nextSlide() {
            slideIndex++;
            if (slideIndex >= slides.children.length) {
                slideIndex = 0;
            }
            showSlides();
        }

        setInterval(nextSlide, 4000);

        function plusSlides(n) {
            slideIndex += n;
            if (slideIndex < 0) {
                slideIndex = slides.children.length - 1;
            } else if (slideIndex >= slides.children.length) {
                slideIndex = 0;
            }
            showSlides();
        }

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