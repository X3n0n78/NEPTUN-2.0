<h1>Jegyek</h1>

<table class="responsive-table">
    <thead>
        <tr>
            <th>Tanuló</th>
            <th>Tantárgy</th>
            <th>Jegy</th>
            <th>Dátum</th>
            <th>Műveletek</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($grades as $grade): ?>
        <tr>
            <td><?= htmlspecialchars($grade['lastname']) ?> <?= htmlspecialchars($grade['firstname']) ?></td>
            <td><?= htmlspecialchars($grade['subject']) ?></td>
            <td><?= htmlspecialchars($grade['grade']) ?></td>
            <td><?= htmlspecialchars($grade['grade_date']) ?></td>
            <td>
                <a href="index.php?page=grades&edit=<?= $grade['id'] ?>" class="button">Szerkesztés</a>
                <a href="index.php?page=grades&delete=<?= $grade['id'] ?>" class="button danger" onclick="return confirm('Biztosan törlöd ezt a jegyet?')">Törlés</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (isset($editGrade)): ?>
    <h2>Jegy szerkesztése</h2>
    <form method="post">
        <input type="hidden" name="update_id" value="<?= $editGrade['id'] ?>">
        <label>Tanuló:
            <select name="student_id" required>
                <option value="">Válassz tanulót</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id'] ?>" <?= $editGrade['student_id'] == $student['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($student['lastname']) ?> <?= htmlspecialchars($student['firstname']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Tantárgy:
            <select name="subject" required>
                <option value="">Válassz tantárgyat</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= htmlspecialchars($subject['name']) ?>" <?= $editGrade['subject'] == $subject['name'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($subject['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Jegy: <input type="number" name="grade" min="1" max="5" value="<?= htmlspecialchars($editGrade['grade']) ?>" required></label><br>
        <label>Dátum: <input type="date" name="grade_date" value="<?= htmlspecialchars($editGrade['grade_date']) ?>" required></label><br>
        <button type="submit" class="button">Mentés</button>
        <a href="index.php?page=grades" class="button">Mégse</a>
    </form>
<?php else: ?>
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
        <label>Tantárgy:
            <select name="subject" required>
                <option value="">Válassz tantárgyat</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= htmlspecialchars($subject['name']) ?>">
                        <?= htmlspecialchars($subject['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Jegy: <input type="number" name="grade" min="1" max="5" required></label><br>
        <label>Dátum: <input type="date" name="grade_date" required></label><br>
        <button type="submit" class="button">Mentés</button>
    </form>
<?php endif; ?>
