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







