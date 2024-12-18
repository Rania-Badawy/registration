let slides = document.querySelectorAll(".slide");
var currentActive;

function previousSlide() {
     document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
  slides.forEach((slide, i) => {
    if (slide.classList.contains("active")) currentActive = i;
    slide.classList.remove("active");
  });
  if (currentActive == 0) {
    currentActive = slides.length - 1;
    slides[currentActive].classList.add("active");
  } else {
    slides[currentActive - 1].classList.add("active");
  }
}

