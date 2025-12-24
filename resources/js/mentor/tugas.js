document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("tugasModal");
    const form = document.getElementById("tugasForm");
    const modalTitle = document.getElementById("modalTitle");
    const btnAdd = document.getElementById("btnAddTugas");
    const btnCancelModal = document.getElementById("btnCancelModal");
    const btnCloseModal = document.getElementById("btnCloseModal");

    /* ================= MODAL MANAGEMENT ================= */

    function openModal(mode, tugasId = null) {
        form.reset();
        clearErrors();

        if (mode === "add") {
            modalTitle.textContent = "Tambah Tugas";
            document.getElementById("formMethod").value = "POST";
            document.getElementById("tugasId").value = "";
            document.getElementById("class_id_form").disabled = false;
        }

        if (mode === "edit") {
            modalTitle.textContent = "Edit Tugas";
            document.getElementById("formMethod").value = "PUT";
            document.getElementById("tugasId").value = tugasId;
            document.getElementById("class_id_form").disabled = true;
            loadTugasData(tugasId);
        }

        modal.classList.add("show");
    }

    function closeModal() {
        modal.classList.remove("show");
    }

    btnAdd?.addEventListener("click", () => openModal("add"));
    btnCloseModal?.addEventListener("click", closeModal);
    btnCancelModal?.addEventListener("click", closeModal);

    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });

    /* ================= LOAD DATA ================= */

    async function loadTugasData(id) {
        try {
            const res = await fetch(`/mentor/tugas/${id}`);
            const data = await res.json();

            document.getElementById("class_id_form").value = data.class_id;
            document.getElementById("title").value = data.title;
            document.getElementById("description").value = data.description;
        } catch (error) {
            console.error("Error loading tugas:", error);
            showAlert("Gagal memuat data tugas", "error");
        }
    }

    /* ================= FORM SUBMIT ================= */

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const method = document.getElementById("formMethod").value;
        const tugasId = document.getElementById("tugasId").value;
        const formData = new FormData(form);

        let url = "/mentor/tugas";
        if (method === "PUT") {
            url = `/mentor/tugas/${tugasId}`;
            formData.append("_method", "PUT");
        }

        const submitBtn = document.getElementById("submitBtn");
        submitBtn.disabled = true;
        submitBtn.textContent = "Menyimpan...";

        try {
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
                body: formData,
            });

            const data = await res.json();

            if (res.ok) {
                closeModal();
                showAlert(data.message, "success");
                setTimeout(() => location.reload(), 1000);
            } else {
                if (data.errors) {
                    displayErrors(data.errors);
                } else {
                    showAlert(data.message || "Terjadi kesalahan", "error");
                }
            }
        } catch (error) {
            console.error("Error:", error);
            showAlert("Terjadi kesalahan pada server", "error");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = "Simpan";
        }
    });

    /* ================= BUTTON ACTIONS ================= */

    document.querySelectorAll(".btn-manage").forEach((btn) => {
        btn.addEventListener("click", () => {
            location.href = `/mentor/tugas/${btn.dataset.id}/edit`;
        });
    });

    document.querySelectorAll(".btn-edit-tugas").forEach((btn) => {
        btn.addEventListener("click", () => openModal("edit", btn.dataset.id));
    });

    document.querySelectorAll(".btn-delete-tugas").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Hapus tugas ini beserta semua soalnya?")) return;

            try {
                const res = await fetch(`/mentor/tugas/${btn.dataset.id}`, {
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
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(data.message || "Gagal menghapus tugas", "error");
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
        document.querySelectorAll(".exercise-card").forEach((card) => {
            card.style.display = card.textContent.toLowerCase().includes(val)
                ? ""
                : "none";
        });
    });
});

/* ================= HELPERS ================= */

function clearErrors() {
    document
        .querySelectorAll(".error-message")
        .forEach((e) => (e.textContent = ""));
}

function displayErrors(errors = {}) {
    Object.entries(errors).forEach(([field, msg]) => {
        const el = document.getElementById(`error-${field}`);
        if (el) el.textContent = msg[0];
    });
}
