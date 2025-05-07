<h1>Tanulók listája</h1>

<?php if (isset($editStudent)): ?>
    <!-- SZERKESZTÉSI ŰRLAP -->
    <h2>Tanuló szerkesztése</h2>
    <form method="post">
        <input type="hidden" name="update_id" value="<?= $editStudent['id'] ?>">
        <label>OM azonosító: 
            <input type="text" 
                   name="om_azonosito" 
                   value="<?= htmlspecialchars($editStudent['om_azonosito']) ?>" 
                   required 
                   maxlength="11">
        </label><br>
        <label>Vezetéknév: 
            <input type="text" 
                   name="lastname" 
                   value="<?= htmlspecialchars($editStudent['lastname']) ?>" 
                   required>
        </label><br>
        <label>Keresztnév: 
            <input type="text" 
                   name="firstname" 
                   value="<?= htmlspecialchars($editStudent['firstname']) ?>" 
                   required>
        </label><br>
        <label>Születési dátum: 
            <input type="date" 
                   name="birthdate" 
                   value="<?= htmlspecialchars($editStudent['birthdate']) ?>" 
                   required>
        </label><br>
        <label>Osztály: 
            <input type="text" 
                   name="class" 
                   value="<?= htmlspecialchars($editStudent['class']) ?>" 
                   required>
        </label><br>
        <button type="submit" class="button">Mentés</button>
        <a href="index.php?page=students" class="button">Mégse</a>
    </form>
<?php else: ?>
    <!-- ÚJ TANULÓ HOZZÁADÁSA -->
    <h2>Új tanuló hozzáadása</h2>
    <form method="post">
        <label>OM azonosító: 
            <input type="text" name="om_azonosito" required maxlength="11">
        </label><br>
        <label>Vezetéknév: 
            <input type="text" name="lastname" required>
        </label><br>
        <label>Keresztnév: 
            <input type="text" name="firstname" required>
        </label><br>
        <label>Születési dátum: 
            <input type="date" name="birthdate" required>
        </label><br>
        <label>Osztály: 
            <input type="text" name="class" required>
        </label><br>
        <button type="submit" class="button">Hozzáadás</button>
    </form>
<?php endif; ?>

<hr>

<!-- TANULÓK LISTÁJA -->
<table class="responsive-table">
    <thead>
        <tr>
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
            <td><?= htmlspecialchars($student['om_azonosito']) ?></td>
            <td><?= htmlspecialchars($student['lastname']) ?></td>
            <td><?= htmlspecialchars($student['firstname']) ?></td>
            <td><?= htmlspecialchars($student['birthdate']) ?></td>
            <td><?= htmlspecialchars($student['class']) ?></td>
            <td>
                <a href="index.php?page=students&edit=<?= $student['id'] ?>" 
                   class="button">Szerkesztés</a>
                <a href="index.php?page=students&delete=<?= $student['id'] ?>" 
                   class="button danger" 
                   onclick="return confirm('Biztos vagy benne?')">Törlés</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
