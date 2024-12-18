$(".owl-carousel.footercar").owlCarousel({
  loop: false,
  rtl: true,
  margin: 10,
  nav: true,
  dots: false,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: true,
    },
    600: {
      items: 1,
      nav: true,
    },
    1000: {
      items: 1,
      nav: true,
    },
  },
});
$(".owl-carousel.adCar").owlCarousel({
  loop: false,
  rtl: true,
  margin: 10,
  nav: true,
  dots: false,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: true,
    },
    600: {
      items: 3,
      nav: true,
    },
    1000: {
      items: 3,
      nav: true,
    },
  },
});
$(".owl-carousel").owlCarousel({
  loop: false,
  rtl: true,
  margin: 10,
  nav: true,
  dots: false,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
      nav: true,
    },
    600: {
      items: 3,
      nav: true,
    },
    1000: {
      items: 5,
      nav: true,
      loop: false,
    },
  },
});
const buttons = document.querySelectorAll(".carousel-button");

buttons.forEach((button) => {
  button.addEventListener("click", () => {
    const offset = button.dataset.carouselButton === "next" ? 1 : -1;
    const slides = button
      .closest("[data-carousel]")
      .querySelector("[data-slides]");

    const activeSlide = slides.querySelector("[data-active]");
    let newIndex = [...slides.children].indexOf(activeSlide) + offset;
    if (newIndex < 0) newIndex = slides.children.length - 1;
    if (newIndex >= slides.children.length) newIndex = 0;

    slides.children[newIndex].dataset.active = true;
    delete activeSlide.dataset.active;
  });
});

const pop = document.querySelector(".popup");
if (pop) {
  window.addEventListener("load", function () {
    setTimeout(function open(event) {
      pop.style.display = "block";
    }, 1000);
  });
}

const close = document.querySelector("#close");
if (close) {
  close.addEventListener("click", function () {
    pop.style.display = "none";
    document.querySelector(".popupCon").style.display = "none";
  });
}
window.onload = function () {
  let slides = document.getElementsByClassName("full-carousel-item");
  let currentIndex = 0;

  function addActive(slide) {
    slide.classList.add("active");
  }

  function removeActive(slide) {
    slide.classList.remove("active");
  }

  function showSlide(index) {
    if (index >= slides.length) {
      currentIndex = 0;
    } else if (index < 0) {
      currentIndex = slides.length - 1;
    } else {
      currentIndex = index;
    }
    for (let i = 0; i < slides.length; i++) {
      removeActive(slides[i]);
    }
    addActive(slides[currentIndex]);
  }

  addActive(slides[0]);

  setInterval(function () {
    showSlide(currentIndex + 1);
  }, 15000);

  document.querySelector(".next-button").addEventListener("click", function () {
    showSlide(currentIndex + 1);
  });

  document.querySelector(".prev-button").addEventListener("click", function () {
    showSlide(currentIndex - 1);
  });
};
