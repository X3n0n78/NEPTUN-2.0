<h1>Dokumentumok</h1>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="document" required>
    <button type="submit">Feltöltés</button>
</form>

<table>
    <thead>
        <tr>
            <th>Fájl neve</th>
            <th>Feltöltve</th>
            <th>Művelet</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documents as $doc): ?>
        <tr>
            <td>
                <a href="uploads/documents/<?= htmlspecialchars($doc['filename']) ?>" target="_blank">
                    <?= htmlspecialchars($doc['original_name']) ?>
                </a>
            </td>
            <td><?= htmlspecialchars($doc['uploaded_at']) ?></td>
            <td>
                <a href="index.php?page=documents&student_id=<?= $student_id ?>&delete=<?= $doc['id'] ?>" onclick="return confirm('Biztosan törlöd?')">Törlés</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
