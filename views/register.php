<div class="register-box">
    <h2>Regisztráció</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']) ?>
    <?php endif; ?>
    <form method="post">
        <div class="input-group">
            <label for="lastname">Családi név</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>
        <div class="input-group">
            <label for="firstname">Keresztnév</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>
        <div class="input-group">
            <label for="username">Felhasználónév</label>
            <input type="text" id="username" name="username" required autocomplete="username">
        </div>
        <div class="input-group">
            <label for="email">Email cím</label>
            <input type="email" id="email" name="email" required autocomplete="email">
        </div>
        <div class="input-group">
            <label for="password">Jelszó</label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
        </div>
        <div class="input-group">
            <label for="confirm_password">Jelszó újra</label>
            <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password">
        </div>
        <button type="submit" class="register-btn">Regisztráció</button>
    </form>
    <div class="login-link">
        Már van fiókod?
        <a href="index.php?page=login">Lépj be itt!</a>
    </div>
</div>
