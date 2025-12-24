document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("materiModal");
    const viewModal = document.getElementById("viewModal");
    const form = document.getElementById("materiForm");
    const modalTitle = document.getElementById("modalTitle");
    const btnAdd = document.getElementById("btnAddMateri");
    const btnCancelModal = document.getElementById("btnCancelModal");
    const btnCloseModal = document.getElementById("btnCloseModal");
    const btnCloseView = document.getElementById("btnCloseView");

    /* ================= MODAL MANAGEMENT ================= */

    function openModal(mode, materiId = null) {
        form.reset();
        clearErrors();

        if (mode === "add") {
            modalTitle.textContent = "Tambah Materi";
            document.getElementById("formMethod").value = "POST";
            document.getElementById("materiId").value = "";
            document.getElementById("class_id_form").disabled = false;
        }

        if (mode === "edit") {
            modalTitle.textContent = "Edit Materi";
            document.getElementById("formMethod").value = "PUT";
            document.getElementById("materiId").value = materiId;
            document.getElementById("class_id_form").disabled = true;
            loadMateriData(materiId);
        }

        modal.classList.add("show");
    }

    function closeModal() {
        modal.classList.remove("show");
    }

    function closeViewModal() {
        viewModal.classList.remove("show");
    }

    btnAdd?.addEventListener("click", () => openModal("add"));
    btnCloseModal?.addEventListener("click", closeModal);
    btnCancelModal?.addEventListener("click", closeModal);
    btnCloseView?.addEventListener("click", closeViewModal);

    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
        if (e.target === viewModal) closeViewModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeModal();
            closeViewModal();
        }
    });

    /* ================= LOAD DATA ================= */

    async function loadMateriData(id) {
        try {
            const res = await fetch(`/mentor/materi/${id}`);
            const data = await res.json();

            document.getElementById("class_id_form").value = data.class_id;
            document.getElementById("type_id").value = data.type_id;
            document.getElementById("title").value = data.title;
            document.getElementById("content").value = data.content;
        } catch (error) {
            console.error("Error loading materi:", error);
            showAlert("Gagal memuat data materi", "error");
        }
    }

    async function viewMateri(id) {
        try {
            const res = await fetch(`/mentor/materi/${id}`);
            const data = await res.json();

            document.getElementById("viewTitle").textContent = data.title;
            document.getElementById(
                "viewClass"
            ).textContent = `📚 ${data.class_room.title}`;
            document.getElementById(
                "viewType"
            ).textContent = `📄 ${data.type.name}`;
            document.getElementById("viewContent").textContent = data.content;

            viewModal.classList.add("show");
        } catch (error) {
            console.error("Error viewing materi:", error);
            showAlert("Gagal memuat detail materi", "error");
        }
    }

    /* ================= FORM SUBMIT ================= */

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const method = document.getElementById("formMethod").value;
        const materiId = document.getElementById("materiId").value;
        const formData = new FormData(form);

        let url = "/mentor/materi";
        if (method === "PUT") {
            url = `/mentor/materi/${materiId}`;
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

    document.querySelectorAll(".btn-edit").forEach((btn) => {
        btn.addEventListener("click", () => openModal("edit", btn.dataset.id));
    });

    document.querySelectorAll(".btn-delete").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Hapus materi ini?")) return;

            try {
                const res = await fetch(`/mentor/materi/${btn.dataset.id}`, {
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
                    showAlert(
                        data.message || "Gagal menghapus materi",
                        "error"
                    );
                }
            } catch (error) {
                console.error("Error:", error);
                showAlert("Terjadi kesalahan pada server", "error");
            }
        });
    });

    document.querySelectorAll(".btn-view").forEach((btn) => {
        btn.addEventListener("click", () => viewMateri(btn.dataset.id));
    });

    /* ================= SEARCH ================= */

    document.getElementById("searchInput")?.addEventListener("input", (e) => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll(".material-card").forEach((card) => {
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
