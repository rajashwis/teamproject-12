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
                    <li class="bs-split"><a href=""> BECOME A SELLER</a></li>
                </ul>
                
            </nav>
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