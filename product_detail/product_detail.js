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





// const toggleBtn = document.querySelector('.toggle')
//     const toggleBtnIcon = document.querySelector('.toggle i')
//     const dropdown = document.querySelector('.dropdown')

//     toggleBtn.onclick = function(){
//         dropdown.classList.toggle('open')

//         toggleBtnIcon.classList = isOpen
//         ? 'fa-solid fa-xmark'
//         : 'fa-solid fa-bars'
//     }

//     let profileDropdownList = document.querySelector(".profile-dropdown-list");
// let btn = document.querySelector(".profile-dropdown-btn");

// let classList = profileDropdownList.classList;

// const toggle = () => classList.toggle("active");

// window.addEventListener("click", function (e) {
//   if (!btn.contains(e.target)) classList.remove("active");
// });






