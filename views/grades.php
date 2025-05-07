<h1>Jegyek</h1>

<table class="responsive-table">
    <thead>
        <tr>
            <th>Tanuló</th>
            <th>Tantárgy</th>
            <th>Jegy</th>
            <th>Dátum</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($grades as $grade): ?>
        <tr>
            <td><?= htmlspecialchars($grade['lastname']) ?> <?= htmlspecialchars($grade['firstname']) ?></td>
            <td><?= htmlspecialchars($grade['subject']) ?></td>
            <td><?= htmlspecialchars($grade['grade']) ?></td>
            <td><?= htmlspecialchars($grade['grade_date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Új jegy rögzítése</h2>
<form method="post">
    <label>Tanuló:
        <select name="student_id" required>
            <option value="">Válassz tanulót</option>
            <?php foreach ($students as $student): ?>
                <option value="<?= $student['id'] ?>">
                    <?= htmlspecialchars($student['lastname']) ?> <?= htmlspecialchars($student['firstname']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Tantárgy: <input type="text" name="subject" required></label><br>
    <label>Jegy: <input type="number" name="grade" min="1" max="5" required></label><br>
    <label>Dátum: <input type="date" name="grade_date" required></label><br>
    <button type="submit">Mentés</button>
</form>
