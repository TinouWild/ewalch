/*
 * Affiche les messages flash Symfony sous forme de pop-up (toasts Bootstrap).
 * Le markup est généré par templates/partials/_flash_messages.html.twig.
 */
function initFlashToasts() {
    const bootstrap = window.bootstrap;
    if (!bootstrap || !bootstrap.Toast) {
        return;
    }

    document.querySelectorAll('.toast-container .toast').forEach((el) => {
        const toast = bootstrap.Toast.getOrCreateInstance(el);
        toast.show();
        el.addEventListener('hidden.bs.toast', () => el.remove());
    });
}

if (document.readyState !== 'loading') {
    initFlashToasts();
} else {
    document.addEventListener('DOMContentLoaded', initFlashToasts);
}
