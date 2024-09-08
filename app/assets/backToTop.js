let backToTopBtn = document.getElementById("backToTopBtn");
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        backToTopBtn.style.display = "block";
    } else {
        backToTopBtn.style.display = "none";
    }
}
backToTopBtn.onclick = function() {
    window.scrollTo({top: 0, behavior: 'smooth'});
}
