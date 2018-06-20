// JavaScript Document
function confdel() {
	answer=confirm("Wollen sie den Eintrag wirklich löschen?");
	return answer;
}

// Open the Modal
function openModal() {
    document.getElementById('myModal').style.display = "block";
    console.log("opend!");
}

// Close the Modal
function closeModal() {
    document.getElementById('myModal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var deleteIcons = document.getElementsByClassName("del");
    var editIcons = document.getElementsByClassName("ed");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
        deleteIcons[i].style.display = "none";
        editIcons[i].style.display = "none";

    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    editIcons[slideIndex-1].style.display = "block";
    deleteIcons[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    // aptionText.innerHTML = dots[slideIndex-1].alt;
}