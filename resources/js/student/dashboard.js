document.addEventListener("DOMContentLoaded", function () {
    // Animate stat numbers
    document.querySelectorAll(".stat-number").forEach((element) => {
        animateCounter(element);
    });
});

function animateCounter(element) {
    const target = parseFloat(element.textContent);
    const duration = 1000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target % 1 === 0 ? target : target.toFixed(1);
            clearInterval(timer);
        } else {
            element.textContent =
                current % 1 === 0 ? Math.floor(current) : current.toFixed(1);
        }
    }, 16);
}
