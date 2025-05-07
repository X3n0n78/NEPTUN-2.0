<div class="login-box">
    <h2>Bejelentkezés</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']) ?>
    <?php endif; ?>

    <form method="post">
        <div class="input-group">
            <label for="username">Felhasználónév</label>
            <input type="text" id="username" name="username" required autocomplete="username">
        </div>
        <div class="input-group">
            <label for="password">Jelszó</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">
        </div>
        <button type="submit" class="login-btn">Belépés</button>
    </form>
    <div class="register-link">
        Nincs fiókod?
        <a href="index.php?page=register">Regisztrálj itt!</a>
    </div>
</div>
