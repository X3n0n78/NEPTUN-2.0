<?php
/**
 * Dokumentumkezelő nézet
 * 
 * @var string $title Oldalcím
 * @var array $documents Dokumentumok tömbje
 * @var int $student_id Tanuló azonosítója
 */
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'layout.php' // Fejléc és menü betöltése ?>
    
    <main class="container">
        <!-- Hiba/siker üzenetek -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <?php unset($_SESSION['success']) ?>
            </div>
        <?php endif; ?>

        <!-- Fő tartalom -->
        <div class="document-header">
            <h1><?= htmlspecialchars($title) ?></h1>
            
            <?php if (hasPermission('upload_documents')): ?>
                <form method="post" enctype="multipart/form-data" class="upload-form">
                    <div class="form-group">
                        <label>Válassz dokumentumot:
                            <input type="file" name="document" required 
                            accept=".pdf,.doc,.docx,.jpg,.png">
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Feltöltés
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Dokumentum lista -->
        <div class="document-list">
            <?php if (empty($documents)): ?>
                <div class="alert alert-info">Nincsenek feltöltött dokumentumok.</div>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fájlnév</th>
                            <th>Méret</th>
                            <th>Típus</th>
                            <th>Feltöltve</th>
                            <th>Feltöltő</th>
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documents as $doc): ?>
                            <tr>
                                <td>
                                    <a href="uploads/documents/<?= $doc['filename'] ?>" 
                                    download="<?= htmlspecialchars($doc['original_name']) ?>"
                                    class="document-link">
                                        <i class="fas fa-file"></i>
                                        <?= htmlspecialchars($doc['original_name']) ?>
                                    </a>
                                </td>
                                <td><?= formatSize(filesize('uploads/documents/'.$doc['filename'])) ?></td>
                                <td><?= strtoupper(pathinfo($doc['filename'], PATHINFO_EXTENSION)) ?></td>
                                <td><?= date('Y.m.d. H:i', strtotime($doc['uploaded_at'])) ?></td>
                                <td><?= htmlspecialchars($doc['username'] ?? 'Rendszer') ?></td>
                                <td>
                                    <?php if (hasPermission('delete_documents')): ?>
                                        <a href="index.php?page=documents&student_id=<?= $student_id ?>&delete=<?= $doc['id'] ?>" 
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Biztos törlöd ezt a dokumentumot?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <!-- Lábléc szkriptek -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    <script>
        // Automatikus időbélyeg formázás
        document.querySelectorAll('td').forEach(td => {
            if (td.textContent.match(/^\d{4}\.\d{2}\.\d{2}\. \d{2}:\d{2}$/)) {
                td.setAttribute('title', new Date(td.textContent.replace(/\./g, '-')).toLocaleString());
            }
        });
    </script>
</body>
</html>
