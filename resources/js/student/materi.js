document.addEventListener("DOMContentLoaded", () => {
    const viewModal = document.getElementById("viewModal");
    const btnCloseView = document.getElementById("btnCloseView");

    btnCloseView?.addEventListener("click", () => {
        viewModal.classList.remove("show");
    });

    document.querySelectorAll(".btn-view").forEach((btn) => {
        btn.addEventListener("click", async () => {
            const materialId = btn.dataset.id;

            try {
                const res = await fetch(`/student/materi/${materialId}`);
                const data = await res.json();

                if (res.ok) {
                    document.getElementById("viewTitle").textContent =
                        data.title;
                    document.getElementById(
                        "viewClass"
                    ).textContent = `📚 ${data.class_room.title}`;
                    document.getElementById(
                        "viewType"
                    ).textContent = `📄 ${data.type.name}`;
                    document.getElementById("viewContent").textContent =
                        data.content;

                    viewModal.classList.add("show");
                } else {
                    showAlert(data.message || "Gagal memuat materi", "error");
                }
            } catch (error) {
                console.error("Error:", error);
                showAlert("Terjadi kesalahan pada server", "error");
            }
        });
    });

    // Search
    document.getElementById("searchInput")?.addEventListener("input", (e) => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll(".material-card").forEach((card) => {
            card.style.display = card.textContent.toLowerCase().includes(val)
                ? ""
                : "none";
        });
    });

    window.addEventListener("click", (e) => {
        if (e.target === viewModal) {
            viewModal.classList.remove("show");
        }
    });
});
