<?php
// Feltételezzük, hogy $studentAverages és $subjectAverages már elérhető

// Tantárgyankénti átlagok adatok
$subjectLabels = [];
$subjectAveragesData = [];
foreach ($subjectAverages as $row) {
    $subjectLabels[] = $row['subject'];
    $subjectAveragesData[] = round($row['average'], 2);
}

// Diákonkénti átlagok adatok
$studentLabels = [];
$studentAveragesData = [];
foreach ($studentAverages as $row) {
    $studentLabels[] = $row['name']; // 'student' helyett 'name'
    $studentAveragesData[] = round($row['average'], 2);
}
?>

<div class="reports-container">
    <h1 class="reports-title">Statisztikai jelentések</h1>

    <div class="report-card">
        <h2>Tanulók átlagjegyei</h2>
        <div class="report-table-container">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Tanuló</th>
                        <th>Tantárgy</th>
                        <th>Átlag</th>
                        <th>Jegyek száma</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentAverages as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td> <!-- 'student' helyett 'name' -->
                            <td><?= htmlspecialchars($row['subject']) ?></td>
                            <td><?= number_format($row['average'], 2) ?></td>
                            <td><?= (int)$row['grade_count'] ?></td> <!-- 'count' helyett 'grade_count' -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="chart-container">
            <canvas id="studentAveragesChart" height="180"></canvas>
        </div>
    </div>

    <div class="report-card">
        <h2>Tantárgyankénti átlagok</h2>
        <div class="report-table-container">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Tantárgy</th>
                        <th>Átlag</th>
                        <th>Összes jegy</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjectAverages as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['subject']) ?></td>
                            <td><?= number_format($row['average'], 2) ?></td>
                            <td><?= (int)$row['grade_count'] ?></td> <!-- 'count' helyett 'grade_count' -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="chart-container">
            <canvas id="subjectAveragesChart" height="180"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const studentCtx = document.getElementById('studentAveragesChart').getContext('2d');
const subjectCtx = document.getElementById('subjectAveragesChart').getContext('2d');

new Chart(studentCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($studentLabels) ?>,
        datasets: [{
            label: 'Tanulói átlagok',
            data: <?= json_encode($studentAveragesData) ?>,
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

new Chart(subjectCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($subjectLabels) ?>,
        datasets: [{
            label: 'Tantárgyi átlagok',
            data: <?= json_encode($subjectAveragesData) ?>,
            backgroundColor: '#2196F3',
            borderColor: '#0D47A1',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
