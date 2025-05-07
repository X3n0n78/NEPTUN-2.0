<?php
// PHP rész: Adatok előkészítése diagramokhoz

// 1. Tantárgyankénti átlagok
$subjectLabels = [];
$subjectAveragesData = [];
if (isset($subjectAverages)) {
    foreach ($subjectAverages as $row) {
        $subjectLabels[] = $row['subject'];
        $subjectAveragesData[] = round($row['average'], 2);
    }
}

// 2. Diákonkénti átlagok
$studentLabels = [];
$studentAveragesData = [];
if (isset($studentAverages)) {
    foreach ($studentAverages as $row) {
        $studentLabels[] = $row['name'];
        $studentAveragesData[] = round($row['average'], 2);
    }
}
?>

<h1>Statisztikai jelentések</h1>

<!-- Tanulói átlagok rész -->
<section>
    <h2>Tanulók átlagjegyei</h2>
    
    <!-- Táblázat -->
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

    <!-- Vonaldiagram -->
    <div class="chart-container">
        <canvas id="studentAvgChart"></canvas>
    </div>
</section>

<!-- Tantárgyi átlagok rész -->
<section>
    <h2>Tantárgyankénti átlagok</h2>
    
    <!-- Táblázat -->
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

    <!-- Oszlopdiagram -->
    <div class="chart-container">
        <canvas id="subjectAvgChart"></canvas>
    </div>
</section>

<!-- Chart.js script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Diákonkénti átlagok (vonaldiagram)
const studentCtx = document.getElementById('studentAvgChart').getContext('2d');
new Chart(studentCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($studentLabels) ?>,
        datasets: [{
            label: 'Tanulói átlagok',
            data: <?= json_encode($studentAveragesData) ?>,
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Tantárgyankénti átlagok (oszlopdiagram)
const subjectCtx = document.getElementById('subjectAvgChart').getContext('2d');
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
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<style>
.chart-container {
    margin: 40px 0;
    position: relative;
    height: 400px;
    width: 100%;
}

.responsive-table {
    margin-bottom: 40px;
}

section {
    margin-bottom: 60px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
