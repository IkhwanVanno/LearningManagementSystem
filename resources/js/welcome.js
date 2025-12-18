// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
            target.scrollIntoView({ behavior: "smooth" });
        }
    });
});

// Courses carousel
let currentCourseSlide = 0;
const coursesTrack = document.getElementById("coursesTrack");
const courseCards = document.querySelectorAll(".course-card");
const courseDots = document.querySelectorAll(".courses .dot");

function updateCourseCarousel() {
    const cardWidth = courseCards[0].offsetWidth + 20;
    coursesTrack.style.transform = `translateX(-${
        currentCourseSlide * cardWidth
    }px)`;

    courseDots.forEach((dot, index) => {
        dot.classList.toggle("active", index === currentCourseSlide);
    });
}

courseDots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
        currentCourseSlide = index;
        updateCourseCarousel();
    });
});

// Auto play carousel
setInterval(() => {
    currentCourseSlide = (currentCourseSlide + 1) % courseDots.length;
    updateCourseCarousel();
}, 5000);

// Animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = "1";
            entry.target.style.transform = "translateY(0)";
        }
    });
}, observerOptions);

document
    .querySelectorAll(".service-card, .course-card, .step-card, .pricing-card")
    .forEach((el) => {
        el.style.opacity = "0";
        el.style.transform = "translateY(20px)";
        el.style.transition = "all 0.6s ease";
        observer.observe(el);
    });
