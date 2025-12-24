document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("userModal");
    const form = document.getElementById("userForm");
    const submitBtn = document.getElementById("submitBtn");
    const tableBody = document.getElementById("userTableBody");
    const btnAddUser = document.getElementById("btnAddUser");
    const btnCloseModal = document.getElementById("btnCloseModal");
    const btnCancelModal = document.getElementById("btnCancelModal");

    btnCloseModal?.addEventListener("click", closeModal);
    btnCancelModal?.addEventListener("click", closeModal);

    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    )?.content;

    if (!modal || !form || !csrfToken) return;

    /* ======================
        MODAL HANDLER
    ====================== */
    function openModal(mode, userId = null) {
        form.reset();
        clearErrors();

        const title = document.getElementById("modalTitle");
        const passwordInput = document.getElementById("password");
        const passwordHint = document.getElementById("passwordHint");
        const passwordRequired = document.getElementById("passwordRequired");

        document.getElementById("formMethod").value =
            mode === "edit" ? "PUT" : "POST";
        document.getElementById("userId").value = userId ?? "";

        if (mode === "edit") {
            title.textContent = "Edit User";
            passwordInput.required = false;
            passwordHint.style.display = "block";
            passwordRequired.style.display = "none";
            loadUserData(userId);
        } else {
            title.textContent = "Tambah User";
            passwordInput.required = true;
            passwordHint.style.display = "none";
            passwordRequired.style.display = "inline";
        }

        modal.classList.add("show");
    }

    function closeModal() {
        modal.classList.remove("show");
    }

    /* ======================
        ADD USER BUTTON
    ====================== */
    btnAddUser?.addEventListener("click", () => {
        openModal("add");
    });

    /* ======================
        TABLE ACTIONS (EDIT / DELETE)
    ====================== */
    tableBody?.addEventListener("click", (e) => {
        const btn = e.target.closest("button");
        if (!btn) return;

        const action = btn.dataset.action;
        const userId = btn.dataset.id;

        if (action === "edit") {
            openModal("edit", userId);
        }

        if (action === "delete") {
            deleteUser(userId);
        }
    });

    /* ======================
        LOAD USER DATA
    ====================== */
    async function loadUserData(id) {
        try {
            const res = await fetch(`/admin/users/${id}`, {
                headers: { Accept: "application/json" },
            });

            if (!res.ok) throw new Error();

            const user = await res.json();

            document.getElementById("name").value = user.name;
            document.getElementById("email").value = user.email;
            document.getElementById("phone").value = user.phone;
            document.getElementById("role_id").value = user.role_id;
        } catch {
            showToast("Gagal memuat data user", "error");
        }
    }

    /* ======================
        SUBMIT FORM
    ====================== */
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        clearErrors();

        submitBtn.disabled = true;
        submitBtn.textContent = "Menyimpan...";

        const formData = new FormData(form);
        const method = document.getElementById("formMethod").value;
        const userId = document.getElementById("userId").value;

        let url = "/admin/users";
        if (method === "PUT") {
            url = `/admin/users/${userId}`;
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
                showToast(data.message, "success");
                setTimeout(() => location.reload(), 1200);
            } else {
                data.errors
                    ? displayErrors(data.errors)
                    : showToast(data.message || "Terjadi kesalahan", "error");
            }
        } catch {
            showToast("Kesalahan server", "error");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = "Simpan";
        }
    });

    /* ======================
        DELETE USER (DOUBLE CONFIRM TOAST)
    ====================== */
    let confirmDelete = false;

    async function deleteUser(id) {
        if (!confirmDelete) {
            confirmDelete = true;
            showToast("Klik hapus sekali lagi untuk konfirmasi", "warning");
            setTimeout(() => (confirmDelete = false), 3000);
            return;
        }

        try {
            const res = await fetch(`/admin/users/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
            });

            const data = await res.json();

            if (res.ok) {
                showToast(data.message, "success");
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast(data.message || "Gagal menghapus", "error");
            }
        } catch {
            showToast("Kesalahan server", "error");
        } finally {
            confirmDelete = false;
        }
    }

    /* ======================
        SEARCH
    ====================== */
    const search = document.getElementById("searchInput");
    search?.addEventListener("input", (e) => {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll("#userTableBody tr").forEach((row) => {
            row.style.display = row.textContent.toLowerCase().includes(term)
                ? ""
                : "none";
        });
    });

    /* ======================
        ERROR HANDLING
    ====================== */
    function displayErrors(errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const el = document.getElementById(`error-${field}`);
            if (el) {
                el.textContent = messages[0];
                el.classList.add("show");
            }
        });
    }

    function clearErrors() {
        document.querySelectorAll(".error-message").forEach((el) => {
            el.textContent = "";
            el.classList.remove("show");
        });
    }

    /* ======================
        CLOSE MODAL
    ====================== */
    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });
});


/* ================= TOAST HANDLER ================= */
function showToast(message, type = "success") {
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
