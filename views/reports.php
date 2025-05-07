<h1>Statisztikai jelentések</h1>

<!-- Tanulói átlagok -->
<h2>Tanulók tantárgyankénti átlagai</h2>
<table class="responsive-table">
    <thead>
        <tr>
            <th>Tanuló</th>
            <th>Tantárgy</th>
            <th>Átlag</th>
            <th>Jegyek száma</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($studentAverages as $avg): ?>
        <tr>
            <td><?= htmlspecialchars($avg['name']) ?></td>
            <td><?= htmlspecialchars($avg['subject']) ?></td>
            <td><?= number_format($avg['average'], 2) ?></td>
            <td><?= $avg['grade_count'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Tantárgyi átlagok -->
<h2>Tantárgyankénti átlagok</h2>
<table class="responsive-table">
    <thead>
        <tr>
            <th>Tantárgy</th>
            <th>Átlag</th>
            <th>Összes jegy</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subjectAverages as $subject): ?>
        <tr>
            <td><?= htmlspecialchars($subject['subject']) ?></td>
            <td><?= number_format($subject['average'], 2) ?></td>
            <td><?= $subject['grade_count'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
