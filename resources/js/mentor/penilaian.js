document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("gradeModal");
    const form = document.getElementById("gradeForm");
    const btnCancelModal = document.getElementById("btnCancelModal");
    const btnCloseModal = document.getElementById("btnCloseModal");

    // Animate stat numbers
    document.querySelectorAll(".stat-number").forEach((element) => {
        animateCounter(element);
    });

    /* ================= MODAL MANAGEMENT ================= */

    function openModal(resultId, studentName, exerciseName, currentScore) {
        form.reset();
        clearErrors();

        document.getElementById("resultId").value = resultId;
        document.getElementById("studentName").textContent = studentName;
        document.getElementById("exerciseName").textContent = exerciseName;

        if (currentScore && currentScore !== "null") {
            document.getElementById("score").value = currentScore;
        }

        modal.classList.add("show");
    }

    function closeModal() {
        modal.classList.remove("show");
    }

    btnCloseModal?.addEventListener("click", closeModal);
    btnCancelModal?.addEventListener("click", closeModal);

    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });

    /* ================= FORM SUBMIT ================= */

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const resultId = document.getElementById("resultId").value;
        const formData = new FormData(form);
        formData.append("_method", "PUT");

        const submitBtn = document.getElementById("submitBtn");
        submitBtn.disabled = true;
        submitBtn.textContent = "Menyimpan...";

        try {
            const res = await fetch(`/mentor/penilaian/result/${resultId}`, {
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
            submitBtn.textContent = "Simpan Nilai";
        }
    });

    /* ================= BUTTON ACTIONS ================= */

    document.querySelectorAll(".btn-grade").forEach((btn) => {
        btn.addEventListener("click", () => {
            openModal(
                btn.dataset.id,
                btn.dataset.student,
                btn.dataset.exercise,
                btn.dataset.score
            );
        });
    });

    /* ================= SEARCH ================= */

    document.getElementById("searchInput")?.addEventListener("input", (e) => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll(".data-table tbody tr").forEach((row) => {
            row.style.display = row.textContent.toLowerCase().includes(val)
                ? ""
                : "none";
        });
    });

    /* ================= DYNAMIC EXERCISE LOADING ================= */

    window.loadExercises = async function (classId) {
        const exerciseSelect = document.getElementById("exercise_id");

        if (!classId) {
            exerciseSelect.innerHTML = '<option value="">Semua Tugas</option>';
            return;
        }

        try {
            // This would need a backend endpoint to fetch exercises by class
            // For now, we'll just submit the form
            document.querySelector(".filter-form").submit();
        } catch (error) {
            console.error("Error loading exercises:", error);
        }
    };
});

/* ================= HELPERS ================= */

function animateCounter(element) {
    const target = parseFloat(element.textContent);
    const duration = 1000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target % 1 === 0 ? target : target.toFixed(1);
            clearInterval(timer);
        } else {
            element.textContent =
                current % 1 === 0 ? Math.floor(current) : current.toFixed(1);
        }
    }, 16);
}

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
