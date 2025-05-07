<div class="grades-page">
    <h1>Jegyek</h1>

    <div class="grades-card">
        <div class="table-container">
            <table class="grades-table">
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
                            <td class="grade-mark"><?= htmlspecialchars($grade['grade']) ?></td>
                            <td><?= htmlspecialchars($grade['grade_date']) ?></td>
                            <td>
                                <a href="index.php?page=grades&edit=<?= $grade['id'] ?>" class="btn btn-edit">Szerkesztés</a>
                                <a href="index.php?page=grades&delete=<?= $grade['id'] ?>" class="btn btn-delete" onclick="return confirm('Biztosan törlöd ezt a jegyet?')">Törlés</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <section class="grade-form-section">
            <h2>Új jegy rögzítése</h2>
            <form method="post" class="grade-form">
                <label>
                    Tanuló:
                    <select name="student_id" required>
                        <option value="">Válassz tanulót</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['id'] ?>">
                                <?= htmlspecialchars($student['lastname']) ?> <?= htmlspecialchars($student['firstname']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>
                    Tantárgy:
                    <select name="subject" required>
                        <option value="">Válassz tantárgyat</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= htmlspecialchars($subject['name']) ?>">
                                <?= htmlspecialchars($subject['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>
                    Jegy:
                    <input type="number" name="grade" min="1" max="5" required>
                </label>
                <label>
                    Dátum:
                    <input type="date" name="grade_date" required>
                </label>
                <button type="submit" class="btn btn-primary">Mentés</button>
            </form>
        </section>
    </div>
</div>
