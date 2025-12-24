document.addEventListener("DOMContentLoaded", () => {
    /* ================= TAB SWITCHING ================= */

    const tabButtons = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const targetTab = button.dataset.tab;

            // Remove active class from all buttons and contents
            tabButtons.forEach((btn) => btn.classList.remove("active"));
            tabContents.forEach((content) =>
                content.classList.remove("active")
            );

            // Add active class to clicked button and corresponding content
            button.classList.add("active");
            document.getElementById(`${targetTab}-tab`).classList.add("active");
        });
    });

    /* ================= SEARCH FUNCTIONALITY ================= */

    // Search Members
    const searchMembers = document.getElementById("searchMembers");
    if (searchMembers) {
        searchMembers.addEventListener("input", (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll("#membersTableBody tr");

            rows.forEach((row) => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? "" : "none";
            });
        });
    }

    // Search Materials
    const searchMaterials = document.getElementById("searchMaterials");
    if (searchMaterials) {
        searchMaterials.addEventListener("input", (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const items = document.querySelectorAll(".material-item");

            items.forEach((item) => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? "" : "none";
            });
        });
    }

    // Search Exercises
    const searchExercises = document.getElementById("searchExercises");
    if (searchExercises) {
        searchExercises.addEventListener("input", (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const items = document.querySelectorAll(".exercise-item");

            items.forEach((item) => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? "" : "none";
            });
        });
    }

    /* ================= ANIMATIONS ================= */

    // Animate info numbers
    const infoNumbers = document.querySelectorAll(".info-number");
    infoNumbers.forEach((element) => {
        animateCounter(element);
    });

    // Fade in list items
    const materialItems = document.querySelectorAll(".material-item");
    materialItems.forEach((item, index) => {
        item.style.opacity = "0";
        item.style.transform = "translateY(20px)";
        item.style.transition = "all 0.3s ease-out";

        setTimeout(() => {
            item.style.opacity = "1";
            item.style.transform = "translateY(0)";
        }, index * 50);
    });

    const exerciseItems = document.querySelectorAll(".exercise-item");
    exerciseItems.forEach((item, index) => {
        item.style.opacity = "0";
        item.style.transform = "translateY(20px)";
        item.style.transition = "all 0.3s ease-out";

        setTimeout(() => {
            item.style.opacity = "1";
            item.style.transform = "translateY(0)";
        }, index * 50);
    });
});

/* ================= HELPER FUNCTIONS ================= */

function animateCounter(element) {
    const target = parseInt(element.textContent);
    if (isNaN(target)) return;

    const duration = 1000;
    const step = target / (duration / 16);
    let current = 0;

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
