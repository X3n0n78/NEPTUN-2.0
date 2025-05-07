<?php
// Csak bejelentkezett felhasználók férhetnek hozzá
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}
?>

<div class="messages-container">
    <h1>Beérkezett üzenetek</h1>
    
    <?php if (empty($messages)): ?>
        <div class="alert alert-info">Még nincsenek üzenetek.</div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Feladó</th>
                    <th>Email</th>
                    <th>Tárgy</th>
                    <th>Üzenet</th>
                    <th>Dátum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td><?= htmlspecialchars($msg['username'] ?? 'Vendég') ?></td>
                        <td><?= htmlspecialchars($msg['email']) ?></td>
                        <td><?= htmlspecialchars($msg['subject']) ?></td>
                        <td><?= htmlspecialchars($msg['message']) ?></td>
                        <td><?= date('Y.m.d. H:i', strtotime($msg['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
