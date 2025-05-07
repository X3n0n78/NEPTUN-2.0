<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Tanulónyilvántartó rendszer' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/brands.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Főoldal</a></li>

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
            
            <?php /*
                <?php if (hasPermission('manage_documents')): ?>
                    <li><a href="index.php?page=documents">Dokumentumok</a></li>
                <?php endif; ?>
            */ ?>
            <li><a href="index.php?page=contact">Kapcsolat</a></li>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="index.php?page=messages">Üzenetek</a></li>
            <?php endif; ?>

            <?php if (hasPermission('admin_panel')): ?>
                <li><a href="index.php?page=admin">Admin</a></li>
            <?php endif; ?>

            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="index.php?page=logout">Kilépés</a></li>
            <?php else: ?>
                <li><a href="index.php?page=login">Belépés</a></li>
            <?php endif; ?>

        </ul>
    </nav>

    <?php if (isset($_SESSION['user'])): ?>
    <div class="user-info-card">
        <div class="user-avatar">
            <span><?= strtoupper(mb_substr($_SESSION['user']['lastname'] ?? '', 0, 1)) ?></span>
        </div>
        <div class="user-details">
            <div class="user-name">
                <?= htmlspecialchars($_SESSION['user']['lastname'] ?? '') ?>
                <?= htmlspecialchars($_SESSION['user']['firstname'] ?? '') ?>
                <span class="user-username">
                    (<?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?>)
                </span>
            </div>
            <?php if (!empty($_SESSION['user']['roles'])): ?>
                <div class="user-roles">
                    <?= implode(', ', array_map('htmlspecialchars', $_SESSION['user']['roles'])) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
                
    <main>
        <?php if (isset($content)) include $content; ?>
    </main>
    <footer class="site-footer">
    <div class="footer-content">
        <div class="footer-left">
            © <?= date('Y') ?> Tanulónyilvántartó rendszer. Stier Kristóf(H5KPH4).
        </div>
        <div class="footer-right">
            <a href="mailto:info@iskola.hu" title="E-mail"><span class="footer-icon">📧</span></a>
            <a href="https://facebook.com/" target="_blank" title="Facebook"><span class="footer-icon">🌐</span></a>
            
        </div>
    </div>
</footer>

</body>
</html>