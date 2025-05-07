<form method="post">
    <h2>Belépés</h2>
    <?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <label>Felhasználónév: <input type="text" name="username" required></label><br>
    <label>Jelszó: <input type="password" name="password" required></label><br>
    <button type="submit">Belépés</button>
    <p>Még nincs fiókod? <a href="index.php?page=register">Regisztráció</a></p>
</form>
