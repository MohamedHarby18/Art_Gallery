// navbar
const burgerMenu = document.querySelector(".burger-menu");
console.log("load main")
burgerMenu.addEventListener("click", () => {
    const tl = gsap.timeline({
        defaults: { duration: 1, ease: "power2.inOut" },
    });
    const menu = document.querySelector(".menu");

    tl.set("body", { overflow: "hidden" })
        .to(menu, { x: 0, duration: 0.5 })
        .to(".close-menu div div", { width: "2rem", duration: 0.2 })
        .to(".close-menu div div:first-of-type", { rotate: 45, duration: 0.3 })
        .to(
            ".close-menu div div:last-of-type",
            { rotate: 90 + 45, duration: 0.3 },
            "-=.3"
        )
        .to(
            ".close-menu + nav ul li",
            { opacity: 1, x: 0, duration: 0.5, stagger: 0.1 },
            "-=.25"
        );
    const closeMenu = document.querySelector(".close-menu");
    closeMenu.addEventListener("click", () => {
        tl.reverse();
    });
});