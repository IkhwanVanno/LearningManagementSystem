document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("quizForm");
    const submitBtn = document.getElementById("submitBtn");
    const confirmModal = document.getElementById("confirmModal");
    const resultModal = document.getElementById("resultModal");
    let answeredCount = 0;

    /* ================= TRACK ANSWERS ================= */
    document.querySelectorAll('input[type="radio"]').forEach((radio) => {
        radio.addEventListener("change", () => {
            const questionId = radio.dataset.questionId;
            const indicator = document.getElementById(
                `indicator-${questionId}`
            );

            if (indicator) {
                indicator.textContent = "Sudah Dijawab";
                indicator.classList.add("answered");
            }

            updateProgress();
        });
    });

    function updateProgress() {
        const questions = document.querySelectorAll(".question-card");
        answeredCount = 0;

        questions.forEach((question) => {
            const radios = question.querySelectorAll('input[type="radio"]');
            const answered = Array.from(radios).some((r) => r.checked);
            if (answered) answeredCount++;
        });

        document.getElementById(
            "progressText"
        ).textContent = `${answeredCount} / ${totalQuestions}`;
        const percentage = (answeredCount / totalQuestions) * 100;
        document.getElementById("progressBar").style.width = `${percentage}%`;
    }

    /* ================= SUBMIT BUTTON ================= */
    submitBtn.addEventListener("click", () => {
        updateProgress();
        document.getElementById("answeredCount").textContent = answeredCount;
        confirmModal.classList.add("show");
    });

    /* ================= CANCEL SUBMIT ================= */
    document.getElementById("btnCancelSubmit").addEventListener("click", () => {
        confirmModal.classList.remove("show");
    });

    /* ================= CONFIRM SUBMIT ================= */
    document
        .getElementById("btnConfirmSubmit")
        .addEventListener("click", async () => {
            confirmModal.classList.remove("show");
            submitBtn.disabled = true;
            submitBtn.textContent = "Mengumpulkan...";

            const formData = new FormData(form);

            try {
                const res = await fetch(`/student/tugas/${exerciseId}/submit`, {
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
                    // Show result
                    document.getElementById("finalScore").textContent =
                        data.score;
                    document.getElementById("correctCount").textContent =
                        data.correct;
                    document.getElementById("wrongCount").textContent =
                        data.total - data.correct;

                    // Change emoji based on score
                    const emoji = data.score >= 70 ? "🎉" : "😊";
                    document.getElementById("resultEmoji").textContent = emoji;

                    resultModal.classList.add("show");
                } else {
                    showAlert(
                        data.message || "Gagal mengumpulkan jawaban",
                        "error"
                    );
                    submitBtn.disabled = false;
                    submitBtn.textContent = "Kumpulkan Jawaban";
                }
            } catch (error) {
                console.error("Error:", error);
                showAlert("Terjadi kesalahan pada server", "error");
                submitBtn.disabled = false;
                submitBtn.textContent = "Kumpulkan Jawaban";
            }
        });

    /* ================= PREVENT BACK ================= */
    window.addEventListener("beforeunload", (e) => {
        if (answeredCount > 0) {
            e.preventDefault();
            e.returnValue = "";
        }
    });
});

function confirmBack() {
    if (confirm("Yakin ingin keluar? Jawaban yang sudah diisi akan hilang.")) {
        window.location.href = "/student/tugas";
    }
}
