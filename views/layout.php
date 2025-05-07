<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Tanulónyilvántartó rendszer' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <nav>
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
    </nav>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="logged-in">
            Bejelentkezett:
            <?= htmlspecialchars($_SESSION['user']['lastname']) ?>
            <?= htmlspecialchars($_SESSION['user']['firstname']) ?>
            (<?= htmlspecialchars($_SESSION['user']['username']) ?>)
        </div>
    <?php endif; ?>

    <main>
        <?php if (isset($content)) include $content; ?>
    </main>
</body>
</html>
