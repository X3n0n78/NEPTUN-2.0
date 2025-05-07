<h1>Tantárgyak</h1>
<ul>
    <?php foreach ($subjects as $subject): ?>
        <li><?= htmlspecialchars($subject['name']) ?></li>
    <?php endforeach; ?>
</ul>

<h2>Új tantárgy hozzáadása</h2>
<form method="post">
    <label>Tantárgy neve: <input type="text" name="name" required></label>
    <button type="submit">Hozzáadás</button>
</form>
