document.addEventListener("DOMContentLoaded", () => {
    // Animate counters
    document.querySelectorAll(".stat-number").forEach((el) => {
        animateCounter(el);
    });

    // Activity animation
    document.querySelectorAll(".activity-item").forEach((item, index) => {
        item.style.opacity = "0";
        item.style.transform = "translateY(20px)";
        item.style.transition = "all 0.3s ease-out";

        setTimeout(() => {
            item.style.opacity = "1";
            item.style.transform = "translateY(0)";
        }, index * 50);
    });

    // Smooth scroll lists
    document.querySelectorAll(".activity-list").forEach((list) => {
        list.style.scrollBehavior = "smooth";
    });

    // Table hover
    document.querySelectorAll(".data-table tbody tr").forEach((row) => {
        row.addEventListener("mouseenter", () => {
            row.style.transform = "scale(1.01)";
        });
        row.addEventListener("mouseleave", () => {
            row.style.transform = "scale(1)";
        });
    });

    // Ripple effect
    document.querySelectorAll(".btn").forEach((button) => {
        button.addEventListener("click", createRipple);
    });

    // Performance log (modern)
    const [nav] = performance.getEntriesByType("navigation");
    if (nav) {
        console.log(
            `Page loaded in ${Math.round(nav.domContentLoadedEventEnd)}ms`
        );
    }
});

// ================= FUNCTIONS =================

function animateCounter(element) {
    const target = parseInt(element.textContent);
    let current = 0;
    const step = Math.max(1, target / 60);

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

function createRipple(e) {
    const btn = e.currentTarget;
    const ripple = document.createElement("span");
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);

    ripple.style.cssText = `
        position:absolute;
        width:${size}px;
        height:${size}px;
        border-radius:50%;
        background:rgba(255,255,255,.6);
        left:${e.clientX - rect.left - size / 2}px;
        top:${e.clientY - rect.top - size / 2}px;
        animation:ripple .6s ease-out;
        pointer-events:none;
    `;

    btn.style.position = "relative";
    btn.style.overflow = "hidden";
    btn.appendChild(ripple);

    setTimeout(() => ripple.remove(), 600);
}
