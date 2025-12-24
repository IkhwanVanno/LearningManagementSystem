document.addEventListener("DOMContentLoaded", function () {
    // Animate stat numbers
    document.querySelectorAll(".stat-number").forEach((element) => {
        animateCounter(element);
    });

    // Fade in activity items
    const activityItems = document.querySelectorAll(".activity-item");
    activityItems.forEach((item, index) => {
        item.style.opacity = "0";
        item.style.transform = "translateY(20px)";
        item.style.transition = "all 0.3s ease-out";

        setTimeout(() => {
            item.style.opacity = "1";
            item.style.transform = "translateY(0)";
        }, index * 50);
    });

    // Initialize chart if data exists
    const chartCanvas = document.getElementById("performanceChart");
    if (chartCanvas && typeof Chart !== "undefined") {
        initPerformanceChart();
    }
});

function animateCounter(element) {
    const target = parseInt(element.textContent);
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

function initPerformanceChart() {
    // This will be populated with data from backend
    // For now, using placeholder
    const ctx = document.getElementById("performanceChart");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Kelas A", "Kelas B", "Kelas C"],
            datasets: [
                {
                    label: "Rata-rata Nilai",
                    data: [85, 78, 92],
                    backgroundColor: [
                        "rgba(102, 126, 234, 0.5)",
                        "rgba(52, 152, 219, 0.5)",
                        "rgba(46, 204, 113, 0.5)",
                    ],
                    borderColor: [
                        "rgb(102, 126, 234)",
                        "rgb(52, 152, 219)",
                        "rgb(46, 204, 113)",
                    ],
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function (value) {
                            return value;
                        },
                    },
                },
            },
        },
    });
}
