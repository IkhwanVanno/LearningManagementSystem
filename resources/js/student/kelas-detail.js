document.addEventListener("DOMContentLoaded", () => {
    // Tab switching
    const tabButtons = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const targetTab = button.dataset.tab;

            tabButtons.forEach((btn) => btn.classList.remove("active"));
            tabContents.forEach((content) =>
                content.classList.remove("active")
            );

            button.classList.add("active");
            document.getElementById(`${targetTab}-tab`).classList.add("active");
        });
    });

    // View material
    const modal = document.getElementById("materialModal");
    const btnClose = document.getElementById("btnCloseModal");

    btnClose?.addEventListener("click", () => {
        modal.classList.remove("show");
    });

    document.querySelectorAll(".btn-view-material").forEach((btn) => {
        btn.addEventListener("click", async () => {
            const materialId = btn.dataset.id;

            try {
                const res = await fetch(`/student/materi/${materialId}`);
                const data = await res.json();

                if (res.ok) {
                    document.getElementById("materialTitle").textContent =
                        data.title;
                    document.getElementById(
                        "materialType"
                    ).textContent = `📄 ${data.type.name}`;
                    document.getElementById("materialContent").textContent =
                        data.content;

                    modal.classList.add("show");
                } else {
                    showAlert(data.message || "Gagal memuat materi", "error");
                }
            } catch (error) {
                console.error("Error:", error);
                showAlert("Terjadi kesalahan pada server", "error");
            }
        });
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.remove("show");
        }
    });
});
