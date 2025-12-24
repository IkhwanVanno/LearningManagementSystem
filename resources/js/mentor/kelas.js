document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("classModal");
    const form = document.getElementById("classForm");
    const modalTitle = document.getElementById("modalTitle");
    const btnCancelModal = document.getElementById("btnCancelModal");
    const btnCloseModal = document.getElementById("btnCloseModal");

    btnCloseModal?.addEventListener("click", closeModal);
    btnCancelModal?.addEventListener("click", closeModal);

    /* ================= MODAL ================= */

    function openModal(classId) {
        form.reset();
        clearErrors();

        modalTitle.textContent = "Edit Kelas";
        document.getElementById("classId").value = classId;
        loadClassData(classId);

        modal.classList.add("show");
    }

    function closeModal() {
        modal.classList.remove("show");
    }

    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });

    /* ================= LOAD DATA ================= */

    async function loadClassData(id) {
        try {
            const res = await fetch(`/mentor/kelas/${id}`);
            const data = await res.json();

            document.getElementById("title").value = data.title;
            document.getElementById("description").value = data.description;
            document.getElementById("status_id").value = data.status_id;
        } catch (error) {
            console.error("Error loading class data:", error);
            showAlert("Gagal memuat data kelas", "error");
        }
    }

    /* ================= FORM SUBMIT ================= */

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const classId = document.getElementById("classId").value;
        const formData = new FormData(form);
        formData.append("_method", "PUT");

        const submitBtn = document.getElementById("submitBtn");
        submitBtn.disabled = true;
        submitBtn.textContent = "Menyimpan...";

        try {
            const res = await fetch(`/mentor/kelas/${classId}`, {
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

    /* ================= BUTTON ACTION ================= */

    document.querySelectorAll(".btn-edit-class").forEach((btn) => {
        btn.addEventListener("click", () => openModal(btn.dataset.id));
    });

    document.querySelectorAll(".btn-detail").forEach((btn) => {
        btn.addEventListener("click", () => {
            location.href = `/mentor/kelas/${btn.dataset.id}/detail`;
        });
    });

    /* ================= SEARCH ================= */

    document.getElementById("searchInput")?.addEventListener("input", (e) => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll(".class-card").forEach((card) => {
            card.style.display = card.textContent.toLowerCase().includes(val)
                ? ""
                : "none";
        });
    });

    /* ================= FILTER ================= */

    document.getElementById("statusFilter")?.addEventListener("change", (e) => {
        document.querySelectorAll(".class-card").forEach((card) => {
            card.style.display =
                !e.target.value || card.dataset.status === e.target.value
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
