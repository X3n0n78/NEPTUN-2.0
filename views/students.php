<h1>Tanulók listája</h1>
<table class="responsive-table">
    <thead>
        <tr>
            <th>OM azonosító</th>
            <th>Vezetéknév</th>
            <th>Keresztnév</th>
            <th>Születési dátum</th>
            <th>Osztály</th>
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
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Új tanuló hozzáadása</h2>
<form method="post">
    <label>OM azonosító: <input type="text" name="om_azonosito" required maxlength="11"></label><br>
    <label>Vezetéknév: <input type="text" name="lastname" required></label><br>
    <label>Keresztnév: <input type="text" name="firstname" required></label><br>
    <label>Születési dátum: <input type="date" name="birthdate" required></label><br>
    <label>Osztály: <input type="text" name="class" required></label><br>
    <button type="submit">Hozzáadás</button>
</form>
