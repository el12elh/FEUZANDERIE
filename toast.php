<?php if (!empty($_SESSION['toast'])): ?>
<script>
    const duration = 5000;

    const toast = document.getElementById('toast');
    const message = toast.querySelector('.toast-message');
    const progress = toast.querySelector('.toast-progress');

    message.textContent = "<?= htmlspecialchars($_SESSION['toast']['message']) ?>";

    toast.classList.add(
        'show',
        '<?= $_SESSION['toast']['type'] ?>'
    );

    // RESET BAR
    progress.style.transition = 'none';
    progress.style.transform = 'scaleX(1)';

    // FORCE REFLOW (this fixes index.php issue)
    progress.offsetHeight;

    // START ANIMATION
    progress.style.transition = `transform ${duration}ms linear`;
    progress.style.transform = 'scaleX(0)';

    setTimeout(() => {
        toast.classList.remove('show');
    }, duration);
</script>
<?php unset($_SESSION['toast']); endif; ?>