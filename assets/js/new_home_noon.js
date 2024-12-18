const navButton = document.querySelector(".nav-btn");
const navbarLinks = document.querySelector(".navbar-links");

 
navButton.addEventListener("click", function() {
  navbarLinks.classList.toggle("hiddenLinks"); 
});
$('.owl-carousel.footercar').owlCarousel({
    loop:false,
    rtl:true,
    margin:10,
    nav:true,
    dots: false,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:1,
            nav:true
        },
        1000:{
            items:1,
            nav:true,
        }
    }
});
$('.owl-carousel.adCar').owlCarousel({
    loop:false,
    rtl:true,
    margin:10,
    nav:true,
    dots: false,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:true
        },
        1000:{
            items:4,
            nav:true,
        }
    }
});
$('.owl-carousel.adCar2').owlCarousel({
    loop:false,
    rtl:true,
    margin:10,
    nav:true,
    dots: false,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:true
        },
        1000:{
            items:5,
            nav:true,
        }
    }
});
$('.owl-carousel').owlCarousel({
    loop:false,
    rtl:true,
    margin:10,
    nav:true,
    dots: false,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:3,
            nav:true
        },
        1000:{
            items:5,
            nav:true,
            loop:false
        }
    }
});
const buttons = document.querySelectorAll(".carousel-button");

buttons.forEach(button => {
    button.addEventListener("click", () => {
        const offset = button.dataset.carouselButton === "next" ? 1 : -1
        const slides = button
        .closest("[data-carousel]")
        .querySelector("[data-slides]")

        const activeSlide = slides.querySelector("[data-active]")
        let newIndex = [...slides.children].indexOf(activeSlide) + offset
        if (newIndex < 0) newIndex = slides.children.length - 1
        if (newIndex >= slides.children.length) newIndex = 0

        slides.children[newIndex].dataset.active = true
        delete activeSlide.dataset.active
    })
})

 
const pop = document.querySelector('.popup');
window.addEventListener("load", function() {
    setTimeout(
        function open(event){
            pop.style.display = 'block';
        }, 1000
    )
});

document.querySelector('#close').addEventListener('click', function(){
    pop.style.display = 'none';
    document.querySelector('.popupCon').style.display = 'none';
});

function resizeImage(className){
    let images = document.querySelectorAll(className);
        var nrOfElements = images.length;
        var elementsArray = [];
        for (var j = 0; j < nrOfElements; j++) {
            elementsArray.push(images[j]);
        }
        var minWidth = 0;
        var minHeight = 0;
        if (nrOfElements > 1) {
            var width = elementsArray[0].naturalWidth;
            var height = elementsArray[0].naturalHeight;
            minWidth = width;
            minHeight = height;
            for (var i = 1; i < nrOfElements; i++) {
                minWidth = Math.min(minWidth, elementsArray[i].naturalWidth);
                minHeight = Math.min(minHeight, elementsArray[i].naturalHeight);
            }
            
             for (var i = 0; i < nrOfElements; i++) {
               images[i].style.width = minWidth + 'px';
               images[i].style.height = minHeight + 'px';
               /*images[i].style.maxWidth= "100%"; 
               images[i].style.maxHeight= "100%"; */
             }
             
                            }
    console.log("images resized");
}
