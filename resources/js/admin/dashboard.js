document.addEventListener("DOMContentLoaded", () => {

    /* ===================== COUNTER ANIMATION ===================== */
    function animateCounter(el) {
        const raw = el.textContent.replace(/\D/g, "");
        const target = parseInt(raw || 0, 10);
        const duration = 1000;
        const step = Math.max(1, Math.floor(target / (duration / 16)));
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                el.textContent = target;
                clearInterval(timer);
            } else {
                el.textContent = current;
            }
        }, 16);
    }

    document.querySelectorAll(".stat-number").forEach(animateCounter);

    /* ===================== PROGRESS BAR ANIMATION ===================== */
    document.querySelectorAll(".progress-fill").forEach((bar) => {
        const finalWidth = bar.style.width;
        bar.style.width = "0%";

        requestAnimationFrame(() => {
            setTimeout(() => {
                bar.style.width = finalWidth;
            }, 100);
        });
    });

    /* ===================== CHART.JS ===================== */
    if (typeof Chart === "undefined") {
        console.warn("Chart.js tidak ditemukan");
        return;
    }

    if (typeof monthlyData === "undefined" || !Array.isArray(monthlyData)) {
        console.warn("monthlyData tidak tersedia");
        return;
    }

    const canvas = document.getElementById("monthlyChart");
    if (!canvas) return;

    const labels = monthlyData.map((item) => {
        const date = new Date(item.month + "-01");
        return date.toLocaleDateString("id-ID", {
            month: "short",
            year: "numeric",
        });
    });

    const values = monthlyData.map((item) => item.total);

    new Chart(canvas, {
        type: "line",
        data: {
            labels,
            datasets: [
                {
                    label: "Jumlah User Baru",
                    data: values,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: "top",
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                },
            },
        },
    });
});
