<h1>Reset Your Password</h1>


<?php if (isset($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php else: ?>
    <form method="POST" action="index.php?action=processResetPassword">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="password" name="password" placeholder="New Password" required>
        <button type="submit">Reset Password</button>
    </form>
<?php endif; ?>