<?php
// views/documents.php
?>

<!-- Hiba/siker üzenetek -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <?php unset($_SESSION['success']) ?>
    </div>
<?php endif; ?>

<!-- Dokumentumkezelő fejléc -->
<div class="document-header">
    <h1><?= htmlspecialchars($title) ?></h1>
    <?php if (hasPermission('upload_documents')): ?>
        <form method="post" enctype="multipart/form-data" class="upload-form">
            <div class="upload-container">
                <label for="file-upload">Válassz dokumentumot:</label>
                <div>
                    <label for="file-upload" class="custom-file-upload">
                        Fájl kiválasztása
                    </label>
                    <input id="file-upload" type="file" name="document" accept=".pdf,.doc,.docx,.jpg,.png" required>
                    <button type="submit" class="upload-btn">Feltöltés</button>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<!-- Dokumentum lista -->
<div class="document-list">
    <?php if (empty($documents)): ?>
        <div class="alert alert-info">Nincsenek feltöltött dokumentumok.</div>
    <?php else: ?>
        <table class="document-table">
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
                            class="file-link">
                                <?= htmlspecialchars($doc['original_name']) ?>
                            </a>
                        </td>
                        <td><?= function_exists('formatSize') ? formatSize(filesize('uploads/documents/'.$doc['filename'])) : filesize('uploads/documents/'.$doc['filename']).' B' ?></td>
                        <td><?= strtoupper(pathinfo($doc['filename'], PATHINFO_EXTENSION)) ?></td>
                        <td><?= date('Y.m.d. H:i', strtotime($doc['uploaded_at'])) ?></td>
                        <td><?= htmlspecialchars($doc['username'] ?? 'Rendszer') ?></td>
                        <td>
                            <?php if (hasPermission('delete_documents')): ?>
                                <form method="get" style="display:inline;">
                                    <input type="hidden" name="page" value="documents">
                                    <input type="hidden" name="student_id" value="<?= $student_id ?>">
                                    <input type="hidden" name="delete" value="<?= $doc['id'] ?>">
                                    <button type="submit" class="delete-btn" title="Törlés" onclick="return confirm('Biztos törlöd ezt a dokumentumot?')">🗑</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
