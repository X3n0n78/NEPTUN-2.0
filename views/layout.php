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
            <?php if (hasPermission('view_dashboard')): ?>
                <li><a href="index.php">Főoldal</a></li>
            <?php endif; ?>

            <?php if (hasPermission('manage_students')): ?>
                <li><a href="index.php?page=students">Tanulók</a></li>
            <?php endif; ?>

            <?php if (hasPermission('manage_grades')): ?>
                <li><a href="index.php?page=grades">Jegyek</a></li>
            <?php endif; ?>

            <?php if (hasPermission('manage_subjects')): ?>
                <li><a href="index.php?page=subjects">Tantárgyak</a></li>
            <?php endif; ?>

            <?php if (hasPermission('view_reports')): ?>
                <li><a href="index.php?page=reports">Jelentések</a></li>
            <?php endif; ?>

            <?php if (hasPermission('manage_documents')): ?>
                <li><a href="index.php?page=documents">Dokumentumok</a></li>
            <?php endif; ?>

            <?php if (hasPermission('admin_panel')): ?>
                <li><a href="index.php?page=admin">Admin</a></li>
            <?php endif; ?>

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
            <?= htmlspecialchars($_SESSION['user']['lastname'] ?? '') ?>
            <?= htmlspecialchars($_SESSION['user']['firstname'] ?? '') ?>
            (<?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?>)
            <?php if (!empty($_SESSION['user']['roles'])): ?>
                <span class="roles">
                    [
                    <?= implode(', ', array_map('htmlspecialchars', $_SESSION['user']['roles'])) ?>
                    ]
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <main>
        <?php if (isset($content)) include $content; ?>
    </main>
</body>
</html>