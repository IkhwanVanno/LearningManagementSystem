document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("classModal");
    const form = document.getElementById("classForm");
    const modalTitle = document.getElementById("modalTitle");
    const btnAdd = document.getElementById("btnAddClass");
    const btnCancelModal = document.getElementById("btnCancelModal");
    const btnCloseModal = document.getElementById("btnCloseModal");

    btnCloseModal?.addEventListener("click", closeModal);
    btnCancelModal?.addEventListener("click", closeModal);

    /* ================= MODAL ================= */

    function openModal(mode, classId = null) {
        form.reset();
        clearErrors();

        if (mode === "add") {
            modalTitle.textContent = "Tambah Kelas";
            document.getElementById("formMethod").value = "POST";
            document.getElementById("classId").value = "";
        }

        if (mode === "edit") {
            modalTitle.textContent = "Edit Kelas";
            document.getElementById("formMethod").value = "PUT";
            document.getElementById("classId").value = classId;
            loadClassData(classId);
        }

        modal.classList.add("show");
    }

    function closeModal() {
        modal.classList.remove("show");
    }

    btnAdd?.addEventListener("click", () => openModal("add"));

    document.querySelector(".close")?.addEventListener("click", closeModal);

    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });

    /* ================= LOAD DATA ================= */

    async function loadClassData(id) {
        const res = await fetch(`/admin/kelas/${id}`);
        const data = await res.json();

        document.getElementById("title").value = data.title;
        document.getElementById("description").value = data.description;
        document.getElementById("mentor_id").value = data.mentor_id;
        document.getElementById("status_id").value = data.status_id;
    }

    /* ================= FORM SUBMIT ================= */

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const method = document.getElementById("formMethod").value;
        const classId = document.getElementById("classId").value;
        const formData = new FormData(form);

        let url = "/admin/kelas";
        if (method === "PUT") {
            url = `/admin/kelas/${classId}`;
            formData.append("_method", "PUT");
        }

        const res = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                    .value,
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
            displayErrors(data.errors);
        }
    });

    /* ================= BUTTON ACTION ================= */

    document.querySelectorAll(".btn-edit-class").forEach((btn) => {
        btn.addEventListener("click", () => openModal("edit", btn.dataset.id));
    });

    document.querySelectorAll(".btn-delete-class").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Hapus kelas ini?")) return;

            const res = await fetch(`/admin/kelas/${btn.dataset.id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            });

            if (res.ok) location.reload();
        });
    });

    document.querySelectorAll(".btn-detail").forEach((btn) => {
        btn.addEventListener("click", () => {
            location.href = `/admin/kelas/${btn.dataset.id}/detail`;
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

function showAlert(message, type = "success") {
    const container =
        document.getElementById("toast-container") || createToastContainer();

    const toast = document.createElement("div");
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span>${message}</span>
        <button class="toast-close">&times;</button>
    `;

    container.appendChild(toast);

    // manual close
    toast.querySelector(".toast-close").addEventListener("click", () => {
        toast.remove();
    });

    // auto close
    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateX(40px)";
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

function createToastContainer() {
    const container = document.createElement("div");
    container.id = "toast-container";
    document.body.appendChild(container);
    return container;
}
