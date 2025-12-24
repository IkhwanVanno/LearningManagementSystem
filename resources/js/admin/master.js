document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("masterModal");
    const form = document.getElementById("masterForm");
    const modalTitle = document.getElementById("modalTitle");
    const submitBtn = document.getElementById("submitBtn");
    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    )?.content;

    if (!modal || !form) return;

    /* ================= TAB ================= */
    document.querySelectorAll(".tab-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const tab = btn.dataset.tab;

            document
                .querySelectorAll(".tab-btn")
                .forEach((b) => b.classList.remove("active"));

            document
                .querySelectorAll(".tab-content")
                .forEach((c) => c.classList.remove("active"));

            btn.classList.add("active");
            document.getElementById(`${tab}-tab`)?.classList.add("active");
        });
    });

    /* ================= MODAL ================= */
    function openModal(type, mode, id = null, name = "") {
        form.reset();
        clearErrors();

        document.getElementById("itemType").value = type;
        document.getElementById("itemId").value = id ?? "";
        document.getElementById("formMethod").value =
            mode === "edit" ? "PUT" : "POST";
        document.getElementById("name").value = name ?? "";

        const titles = {
            "class-status": "Status Kelas",
            "member-status": "Status Anggota",
            "material-type": "Tipe Materi",
            role: "Role",
        };

        modalTitle.textContent =
            (mode === "edit" ? "Edit " : "Tambah ") + titles[type];

        modal.classList.add("show");
    }

    function closeModal() {
        modal.classList.remove("show");
    }

    /* ================= BUTTON EVENTS ================= */
    document.querySelectorAll(".btn-add").forEach((btn) => {
        btn.addEventListener("click", () => {
            openModal(btn.dataset.type, "add");
        });
    });

    document.addEventListener("click", (e) => {
        const editBtn = e.target.closest('[data-action="edit"]');
        const deleteBtn = e.target.closest('[data-action="delete"]');

        if (editBtn) {
            openModal(
                editBtn.dataset.type,
                "edit",
                editBtn.dataset.id,
                editBtn.dataset.name
            );
        }

        if (deleteBtn) {
            deleteItem(deleteBtn.dataset.type, deleteBtn.dataset.id);
        }
    });

    document
        .getElementById("btnCloseModal")
        ?.addEventListener("click", closeModal);

    document
        .getElementById("btnCancelModal")
        ?.addEventListener("click", closeModal);

    /* ================= SUBMIT ================= */
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        submitBtn.textContent = "Menyimpan...";
        clearErrors();

        const formData = new FormData(form);
        const method = document.getElementById("formMethod").value;
        const type = document.getElementById("itemType").value;
        const id = document.getElementById("itemId").value;

        let url = `/admin/master-data/${type}`;
        if (method === "PUT") {
            url += `/${id}`;
            formData.append("_method", "PUT");
        }

        try {
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                body: formData,
            });

            const data = await res.json();

            if (res.ok) {
                closeModal();
                Toast.success(data.message);
                setTimeout(() => location.reload(), 1200);
            } else {
                data.errors
                    ? displayErrors(data.errors)
                    : Toast.error(data.message || "Terjadi kesalahan");
            }
        } catch {
            Toast.error("Server error");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = "Simpan";
        }
    });

    /* ================= DELETE ================= */
    async function deleteItem(type, id) {
        if (!confirm("Hapus data ini?")) return;

        try {
            const res = await fetch(`/admin/master-data/${type}/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
            });

            const data = await res.json();

            res.ok
                ? (Toast.success(data.message),
                  setTimeout(() => location.reload(), 1200))
                : Toast.error(data.message);
        } catch {
            Toast.error("Server error");
        }
    }

    /* ================= UX ================= */
    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });
});

/* ================= HELPERS ================= */
function displayErrors(errors) {
    Object.entries(errors).forEach(([field, msg]) => {
        const el = document.getElementById(`error-${field}`);
        if (el) el.textContent = msg[0];
    });
}

function clearErrors() {
    document
        .querySelectorAll(".error-message")
        .forEach((e) => (e.textContent = ""));
}
