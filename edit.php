<?php require 'includes/header.php'; ?>
<?php require 'config/db.php'; ?>

<?php
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID manquant");
}

// Récupérer le prompt
$stmt = $pdo->prepare("SELECT * FROM prompts WHERE id = ?");
$stmt->execute([$id]);
$prompt = $stmt->fetch();

if (!$prompt) {
    die("Prompt introuvable");
}

// UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $categories_id = $_POST['categories_id'];

    $sql = "UPDATE prompts SET title=?, content=?, categories_id=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $categories_id, $id]);

    echo "<p>Prompt modifié avec succès</p>";
}
?>

<h1>Modifier un Prompt</h1>

<form method="POST">
    <input type="text" name="title" value="<?= htmlspecialchars($prompt['title']) ?>" required>

    <textarea name="content" required><?= htmlspecialchars($prompt['content']) ?></textarea>

    <select name="categories_id">
        <?php
        $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
        foreach ($cats as $c):
        ?>
            <option value="<?= $c['id'] ?>"
                <?= ($c['id'] == $prompt['categories_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Modifier</button>
</form>

<?php require 'includes/footer.php'; ?>