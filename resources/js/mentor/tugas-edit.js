document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("questionModal");
    const form = document.getElementById("questionForm");
    const modalTitle = document.getElementById("modalTitle");
    const btnAddQuestion = document.getElementById("btnAddQuestion");
    const btnCancelModal = document.getElementById("btnCancelModal");
    const btnCloseModal = document.getElementById("btnCloseModal");
    const exerciseId = document.querySelector(
        'input[name="exercise_id"]'
    )?.value;

    /* ================= MODAL MANAGEMENT ================= */

    function openModal(mode, questionId = null) {
        form.reset();
        clearErrors();

        if (mode === "add") {
            modalTitle.textContent = "Tambah Soal";
            document.getElementById("formMethod").value = "POST";
            document.getElementById("questionId").value = "";
        }

        if (mode === "edit") {
            modalTitle.textContent = "Edit Soal";
            document.getElementById("formMethod").value = "PUT";
            document.getElementById("questionId").value = questionId;
            loadQuestionData(questionId);
        }

        modal.classList.add("show");
    }

    function closeModal() {
        modal.classList.remove("show");
    }

    btnAddQuestion?.addEventListener("click", () => openModal("add"));
    btnCloseModal?.addEventListener("click", closeModal);
    btnCancelModal?.addEventListener("click", closeModal);

    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });

    /* ================= LOAD DATA ================= */

    function loadQuestionData(questionId) {
        // Find question data from the page
        const questionItem = document
            .querySelector(`[data-id="${questionId}"]`)
            .closest(".question-item");

        if (questionItem) {
            const questionText =
                questionItem.querySelector(".question-text").textContent;
            const options = questionItem.querySelectorAll(".option");
            const correctAnswer = questionItem
                .querySelector(".correct-indicator")
                .textContent.split(": ")[1];

            document.getElementById("question_text").value = questionText;
            document.getElementById("option_a").value = options[0].textContent
                .replace("A.", "")
                .trim();
            document.getElementById("option_b").value = options[1].textContent
                .replace("B.", "")
                .trim();
            document.getElementById("option_c").value = options[2].textContent
                .replace("C.", "")
                .trim();
            document.getElementById("option_d").value = options[3].textContent
                .replace("D.", "")
                .trim();
            document.getElementById("correct_answer").value = correctAnswer;
        }
    }

    /* ================= FORM SUBMIT ================= */

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const method = document.getElementById("formMethod").value;
        const questionId = document.getElementById("questionId").value;
        const formData = new FormData(form);

        let url = `/mentor/tugas/${exerciseId}/questions`;
        if (method === "PUT") {
            url = `/mentor/tugas/questions/${questionId}`;
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
            if (!confirm("Hapus soal ini?")) return;

            try {
                const res = await fetch(
                    `/mentor/tugas/questions/${btn.dataset.id}`,
                    {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                            Accept: "application/json",
                        },
                    }
                );

                const data = await res.json();

                if (res.ok) {
                    showAlert(data.message, "success");
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(data.message || "Gagal menghapus soal", "error");
                }
            } catch (error) {
                console.error("Error:", error);
                showAlert("Terjadi kesalahan pada server", "error");
            }
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
