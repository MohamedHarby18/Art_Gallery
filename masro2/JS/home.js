

// Hero Slider

const heroSlider = new Swiper(".swiper.hero-slider", {
    direction: "horizontal",
    loop: true,

    spaceBetween: 30,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
        delay: 5000, // Delay between transitions in milliseconds (5 seconds)
        disableOnInteraction: false, // Stop autoplay when user interacts with the slider (default: true)
    },
});
(function () {
    splt({target:".splt",
        reveal: true,
    });
    const tl = gsap.timeline();
    heroSlider.on("slideChangeTransitionStart", () => {
        const activeSlide = heroSlider.slides[heroSlider.activeIndex];
        const reveal = activeSlide.querySelectorAll(".reveal");
        tl.fromTo(
            reveal,
            {
                y: "100%",

            },
            {
                y: "0%",
                duration: 0.5,
                stagger: 0.01,
            }
        );
    });
})();


// Special collection Slider

const collectionSlider = new Swiper(".swiper.shop-slider", {
    direction: "horizontal",
    loop: true,
    slidesPerView: 1,
    spaceBetween: 16,
    breakpoints: {
        // Responsive breakpoints
        768: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
        1280: {
            slidesPerView: 4,
            spaceBetween: 30,
        }
    },
});
console.log(collectionSlider)