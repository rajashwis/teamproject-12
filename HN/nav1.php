<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="header.css">
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
    height: 15px;
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

.signin{
    position: absolute;
    top: 27%;
    right: 11%;
}

.btn{
    padding: 10px;
    border: none;
    background-color: transparent;
    color: white;
    font-size: 15px;
    cursor:pointer;
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

.btn-2 :hover{
   color: #000000;
}

.basket{
    position: absolute;
    left: 95%;
    top: 30%;
    transition: transform .2s; 
}

.basket :hover{
    transform: scale(1.1);
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
                    <img class="logo" src="cfxlocalhubwhitelogo.png">
            
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
                                <form action="login.html" method="get">
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
                        <div class="basket">
                            <a href="cart.html"><img src="trolley.png" height="30px"></a>
                        </div>
                <div class="toggle"><i class="fa-solid fa-bars"></i></div>
            </nav> 
            
        </div>
        <div class="dropdown">
            <ul>
                <li><a href="">HOME</a></li>
                <li><a href="trending.html"> TRENDING</a></li>
                <li><a href="decor.html"> HOME & DECOR</a></li>
                <li><a href=""> ELECTRONICS</a></li>
                <li><a href=""> FASHION</a></li>
                <li><a href=""> SALES</a></li>
                <li><a href=""> BECOME A SELLER</a></li>
                <li><a href="">Sign In</a></li>
                <li><a href="">Sign Up</a></li>
                <li><a href=""><img src="trolley.png" height="30px"></a></li>
            </ul>
        </div>

</div>
<script href="navbar.js"></script>
<script>
    //**NAVBAR**//
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
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


//slide
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

//profile drop down

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



    //navmenu dropdown
    const toggleBtn = document.querySelector('.toggle')
    const toggleBtnIcon = document.querySelector('.toggle i')
    const dropdown = document.querySelector('.dropdown')

    toggleBtn.onclick = function(){
        dropdown.classList.toggle('open')

        toggleBtnIcon.classList = isOpen
        ? 'fa-solid fa-xmark'
        : 'fa-solid fa-bars'
    }
</script>


</body>
</html>