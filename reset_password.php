<?php
$selector = $_GET['selector'] ?? '';
$token = $_GET['token'] ?? '';
?>

<article id="reset_password">
    <h2 class="major">Reset Password</h2>
    <?php if ($selector && $token): ?>
        <form method="post" action="">
            <input type="hidden" name="selector" value="<?php echo htmlspecialchars($selector); ?>">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="fields">
                <div class="field full">
                    <label><strong>New Password</strong></label>
                    <input type="password" name="password" value="" minlength="6" placeholder="******" required/>
                </div>
            </div>
            <ul class="actions">
                <li><input type="submit" name="reset_submit" value="Update Password" class="primary"/></li>
                <li><input type="reset" value="Reset"/></li>
            </ul>
        </form>
    <?php endif; ?>
</article>