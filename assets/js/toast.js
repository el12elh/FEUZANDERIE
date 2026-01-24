
    const duration = 5000;

    const toast = document.getElementById('toast');
    const message = toast.querySelector('.toast-message');
    const progress = toast.querySelector('.toast-progress');

    message.textContent = "<?= htmlspecialchars($_SESSION['toast']['message']) ?>";

    toast.classList.add(
        'show',
        '<?= $_SESSION['toast']['type'] ?>'
    );

    // Force reset (important si plusieurs toasts)
    progress.style.transition = 'none';
    progress.style.transform = 'scaleX(1)';

    // Trigger animation
    requestAnimationFrame(() => {
        progress.style.transition = `transform ${duration}ms linear`;
        progress.style.transform = 'scaleX(0)';
    });

    setTimeout(() => {
        toast.classList.remove('show');
    }, duration);
