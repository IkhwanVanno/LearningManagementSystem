document.addEventListener('DOMContentLoaded', () => {
    const toasts = document.querySelectorAll('.toast');

    toasts.forEach(toast => {
        // auto close
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(40px)';
            setTimeout(() => toast.remove(), 300);
        }, 4000);

        // manual close
        toast.querySelector('.toast-close')
            .addEventListener('click', () => toast.remove());
    });
});
