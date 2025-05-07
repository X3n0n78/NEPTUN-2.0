<div class="students-page">
    <h1>Tanulók listája</h1>

    <?php if (isset($editStudent)): ?>
        <section class="student-form-section">
            <h2>Tanuló szerkesztése</h2>
            <form method="post" enctype="multipart/form-data" class="student-form">
                <input type="hidden" name="update_id" value="<?= $editStudent['id'] ?>">
                <input type="hidden" name="old_photo" value="<?= $editStudent['photo'] ?? '' ?>">
                
                <label>
                    OM azonosító:
                    <input type="text" name="om_azonosito" value="<?= htmlspecialchars($editStudent['om_azonosito']) ?>" required maxlength="11">
                </label>
                
                <label>
                    Vezetéknév:
                    <input type="text" name="lastname" value="<?= htmlspecialchars($editStudent['lastname']) ?>" required>
                </label>
                
                <label>
                    Keresztnév:
                    <input type="text" name="firstname" value="<?= htmlspecialchars($editStudent['firstname']) ?>" required>
                </label>
                
                <label>
                    Születési dátum:
                    <input type="date" name="birthdate" value="<?= htmlspecialchars($editStudent['birthdate']) ?>" required>
                </label>
                
                <label>
                    Osztály:
                    <input type="text" name="class" value="<?= htmlspecialchars($editStudent['class']) ?>" required>
                </label>
                
                <label>
                    Fénykép:
                    <input type="file" name="photo" accept="image/jpeg, image/png">
                </label>
                
                <?php if (!empty($editStudent['photo'])): ?>
                    <div class="photo-preview">
                        <img src="uploads/<?= htmlspecialchars($editStudent['photo']) ?>" alt="Fénykép" class="student-photo-edit">
                        <label class="delete-photo-label">
                            <input type="checkbox" name="delete_photo"> Kép törlése
                        </label>
                    </div>
                <?php endif; ?>
                
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Mentés</button>
                    <a href="index.php?page=students" class="btn btn-secondary">Mégse</a>
                </div>
            </form>
        </section>
    <?php else: ?>
        <section class="student-form-section">
            <h2>Új tanuló hozzáadása</h2>
            <form method="post" class="student-form">
                <label>
                    OM azonosító:
                    <input type="text" name="om_azonosito" required maxlength="11">
                </label>
                
                <label>
                    Vezetéknév:
                    <input type="text" name="lastname" required>
                </label>
                
                <label>
                    Keresztnév:
                    <input type="text" name="firstname" required>
                </label>
                
                <label>
                    Születési dátum:
                    <input type="date" name="birthdate" required>
                </label>
                
                <label>
                    Osztály:
                    <input type="text" name="class" required>
                </label>
                
                <button type="submit" class="btn btn-primary">Hozzáadás</button>
            </form>
        </section>
    <?php endif; ?>

    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Fénykép</th>
                    <th>OM azon.</th>
                    <th>Vezetéknév</th>
                    <th>Keresztnév</th>
                    <th>Születési dátum</th>
                    <th>Osztály</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td>
                        <?php if (!empty($student['photo'])): ?>
                            <img src="uploads/<?= htmlspecialchars($student['photo']) ?>" alt="Fénykép" class="student-photo">
                        <?php else: ?>
                            <span class="no-photo">–</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($student['om_azonosito']) ?></td>
                    <td><?= htmlspecialchars($student['lastname']) ?></td>
                    <td><?= htmlspecialchars($student['firstname']) ?></td>
                    <td><?= htmlspecialchars($student['birthdate']) ?></td>
                    <td><?= htmlspecialchars($student['class']) ?></td>
                    <td>
                        <a href="index.php?page=students&edit=<?= $student['id'] ?>" class="btn btn-edit">Szerkesztés</a>
                        <a href="index.php?page=students&delete=<?= $student['id'] ?>" class="btn btn-delete" onclick="return confirm('Biztos vagy benne?')">Törlés</a>
                        <a href="index.php?page=documents&student_id=<?= $student['id'] ?>" class="btn btn-docs">Dokumentumok</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>