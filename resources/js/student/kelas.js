document.addEventListener("DOMContentLoaded", () => {
    /* ================= JOIN CLASS ================= */
    document.querySelectorAll(".btn-join").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Bergabung dengan kelas ini?")) return;

            const classId = btn.dataset.id;
            btn.disabled = true;
            btn.textContent = "Memproses...";

            try {
                const res = await fetch(`/student/kelas/${classId}/join`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        Accept: "application/json",
                    },
                });

                const data = await res.json();

                if (res.ok) {
                    showAlert(data.message, "success");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(data.message || "Gagal bergabung", "error");
                    btn.disabled = false;
                    btn.textContent = "Gabung Kelas";
                }
            } catch (error) {
                console.error("Error:", error);
                showAlert("Terjadi kesalahan pada server", "error");
                btn.disabled = false;
                btn.textContent = "Gabung Kelas";
            }
        });
    });

    /* ================= LEAVE CLASS ================= */
    document.querySelectorAll(".btn-leave").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Keluar dari kelas ini?")) return;

            const classId = btn.dataset.id;

            try {
                const res = await fetch(`/student/kelas/${classId}/leave`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        Accept: "application/json",
                    },
                });

                const data = await res.json();

                if (res.ok) {
                    showAlert(data.message, "success");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(
                        data.message || "Gagal keluar dari kelas",
                        "error"
                    );
                }
            } catch (error) {
                console.error("Error:", error);
                showAlert("Terjadi kesalahan pada server", "error");
            }
        });
    });

    /* ================= SEARCH ================= */
    document.getElementById("searchInput")?.addEventListener("input", (e) => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll(".available-class-card").forEach((card) => {
            card.style.display = card.textContent.toLowerCase().includes(val)
                ? ""
                : "none";
        });
    });
});
