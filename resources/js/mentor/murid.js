document.addEventListener("DOMContentLoaded", () => {
    const checkAll = document.getElementById("checkAll");
    const memberCheckboxes = document.querySelectorAll(".member-checkbox");
    const btnBulkApprove = document.getElementById("btnBulkApprove");
    const btnBulkReject = document.getElementById("btnBulkReject");

    /* ================= CHECKBOX HANDLING ================= */

    checkAll?.addEventListener("change", (e) => {
        memberCheckboxes.forEach((checkbox) => {
            checkbox.checked = e.target.checked;
        });
        toggleBulkButtons();
    });

    memberCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", toggleBulkButtons);
    });

    function toggleBulkButtons() {
        const checkedCount = document.querySelectorAll(
            ".member-checkbox:checked"
        ).length;

        if (checkedCount > 0) {
            btnBulkApprove.style.display = "inline-block";
            btnBulkReject.style.display = "inline-block";
        } else {
            btnBulkApprove.style.display = "none";
            btnBulkReject.style.display = "none";
        }
    }

    /* ================= SINGLE ACTIONS ================= */

    document.querySelectorAll(".btn-approve").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Setujui siswa ini?")) return;

            const approvedStatus = await getStatusId("approved");
            if (!approvedStatus) return;

            await updateMemberStatus(btn.dataset.id, approvedStatus);
        });
    });

    document.querySelectorAll(".btn-reject").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Tolak siswa ini?")) return;

            const rejectedStatus = await getStatusId("rejected");
            if (!rejectedStatus) return;

            await updateMemberStatus(btn.dataset.id, rejectedStatus);
        });
    });

    document.querySelectorAll(".btn-remove").forEach((btn) => {
        btn.addEventListener("click", async () => {
            if (!confirm("Keluarkan siswa ini dari kelas?")) return;

            await removeMember(btn.dataset.id);
        });
    });

    /* ================= BULK ACTIONS ================= */

    btnBulkApprove?.addEventListener("click", async () => {
        const selectedIds = getSelectedIds();
        if (selectedIds.length === 0) return;

        if (!confirm(`Setujui ${selectedIds.length} siswa terpilih?`)) return;

        try {
            const res = await fetch("/mentor/murid/bulk-approve", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ member_ids: selectedIds }),
            });

            const data = await res.json();

            if (res.ok) {
                showAlert(data.message, "success");
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert(data.message || "Gagal menyetujui siswa", "error");
            }
        } catch (error) {
            console.error("Error:", error);
            showAlert("Terjadi kesalahan pada server", "error");
        }
    });

    btnBulkReject?.addEventListener("click", async () => {
        const selectedIds = getSelectedIds();
        if (selectedIds.length === 0) return;

        if (!confirm(`Tolak ${selectedIds.length} siswa terpilih?`)) return;

        try {
            const res = await fetch("/mentor/murid/bulk-reject", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ member_ids: selectedIds }),
            });

            const data = await res.json();

            if (res.ok) {
                showAlert(data.message, "success");
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert(data.message || "Gagal menolak siswa", "error");
            }
        } catch (error) {
            console.error("Error:", error);
            showAlert("Terjadi kesalahan pada server", "error");
        }
    });

    /* ================= HELPER FUNCTIONS ================= */

    function getSelectedIds() {
        return Array.from(
            document.querySelectorAll(".member-checkbox:checked")
        ).map((cb) => cb.value);
    }

    async function getStatusId(statusName) {
        // This would typically come from the backend
        // For now, we'll use the status name directly
        return statusName;
    }

    async function updateMemberStatus(memberId, statusId) {
        // Since we're passing status name, we need to find the actual status_id
        // This is a simplified version - in production, you'd want to pass the actual ID
        try {
            const res = await fetch(`/mentor/murid/${memberId}/status`, {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ status_name: statusId }),
            });

            const data = await res.json();

            if (res.ok) {
                showAlert(data.message, "success");
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert(data.message || "Gagal mengubah status", "error");
            }
        } catch (error) {
            console.error("Error:", error);
            showAlert("Terjadi kesalahan pada server", "error");
        }
    }

    async function removeMember(memberId) {
        try {
            const res = await fetch(`/mentor/murid/${memberId}`, {
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
                showAlert(data.message || "Gagal mengeluarkan siswa", "error");
            }
        } catch (error) {
            console.error("Error:", error);
            showAlert("Terjadi kesalahan pada server", "error");
        }
    }

    /* ================= SEARCH ================= */

    document.getElementById("searchInput")?.addEventListener("input", (e) => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll(".data-table tbody tr").forEach((row) => {
            row.style.display = row.textContent.toLowerCase().includes(val)
                ? ""
                : "none";
        });
    });
});
