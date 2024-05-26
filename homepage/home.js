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