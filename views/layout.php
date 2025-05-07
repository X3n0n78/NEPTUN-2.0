<ul>
    <?php foreach ($config['menu'] as $key => $value): ?>
        <li><a href="index.php?page=<?= $key ?>"><?= $value ?></a></li>
    <?php endforeach; ?>
    <?php if (!isset($_SESSION['user'])): ?>
        <li><a href="index.php?page=login">Belépés</a></li>
    <?php else: ?>
        <li><a href="index.php?page=logout">Kilépés</a></li>
    <?php endif; ?>
</ul>
<?php if (isset($_SESSION['user'])): ?>
    <div>Bejelentkezett: <?= htmlspecialchars($_SESSION['user']['lastname']) ?>
        <?= htmlspecialchars($_SESSION['user']['firstname']) ?>
        (<?= htmlspecialchars($_SESSION['user']['username']) ?>)
    </div>
<?php endif; ?>
