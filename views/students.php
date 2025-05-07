<div class="table-container">
    <table class="responsive-table">
        <thead>
            <tr>
                <th>OM azon.</th>
                <th>Név</th>
                <th>Osztály</th>
                <th>Születési dátum</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $student): ?>
            <tr>
                <td data-label="OM azon."><?= htmlspecialchars($student['om_azonosito']) ?></td>
                <td data-label="Név"><?= htmlspecialchars($student['lastname']) ?> <?= htmlspecialchars($student['firstname']) ?></td>
                <td data-label="Osztály"><?= htmlspecialchars($student['class']) ?></td>
                <td data-label="Születési dátum"><?= date('Y.m.d', strtotime($student['birthdate'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
