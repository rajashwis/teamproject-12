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






