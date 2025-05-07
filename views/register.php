<?php if (isset($_SESSION['error'])): ?>
    <div class="alert error"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']) ?>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="page" value="register">
    <label>Felhasználónév: <input type="text" name="username" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Jelszó: <input type="password" name="password" required></label><br>
    <label>Jelszó újra: <input type="password" name="confirm_password" required></label><br>
    <button type="submit">Regisztráció</button>
</form>
