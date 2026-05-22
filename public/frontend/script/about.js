
// Slide show
const slides = document.querySelectorAll('.about-image.slideshow .slide');
    if (slides.length > 1) {
        let slideIndex = 0;
        function showNextSlide() {
            slides[slideIndex].classList.remove('active');
            slideIndex = (slideIndex + 1) % slides.length;
            slides[slideIndex].classList.add('active');
        }
        setInterval(showNextSlide, 2000);
    }