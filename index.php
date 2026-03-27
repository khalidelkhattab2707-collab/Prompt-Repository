<?php require 'includes/header.php'; ?>
<?php require 'config/db.php'; ?>

<?php
// Filtre catégorie
$cat_id = $_GET['cat_id'] ?? null;

if ($cat_id) {
    $stmt = $pdo->prepare("
        SELECT p.*, u.username, c.name AS category
        FROM prompts p
        JOIN users u ON p.user_id = u.id
        JOIN categories c ON p.categories_id = c.id
        WHERE p.category_id = ?
    ");
    $stmt->execute([$cat_id]);
} else {
    $stmt = $pdo->query("
        SELECT p.*, u.username, c.name AS category
        FROM prompts p
        JOIN users u ON p.user_id = u.id
        JOIN categories c ON p.categories_id = c.id
    ");
}

$prompts = $stmt->fetchAll();
?>

<h1>Liste des Prompts</h1>

<form method="GET">
    <label>Catégorie :</label>
    <select name="cat_id">
        <option value="">Toutes</option>
        <?php
        $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
        foreach ($cats as $c):
        ?>
            <option value="<?= $c['id'] ?>">
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filtrer</button>
</form>

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Catégorie</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($prompts as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['title']) ?></td>
            <td><?= htmlspecialchars($p['username']) ?></td>
            <td><?= htmlspecialchars($p['category']) ?></td>
            <td><?= $p['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require 'includes/footer.php'; ?>