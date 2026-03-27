<?php require 'includes/header.php'; ?>
<?php require 'config/db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['categories_id'];

    $sql = "INSERT INTO prompts (title, content, categories_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $category_id]);

    echo "<p>Prompt ajouté avec succès !</p>";
}
?>

<h1>Ajouter un Prompt</h1>

<form method="POST">
    <label>Titre</label>
    <input type="text" name="title" required>

    <label>Contenu</label>
    <textarea name="content" required></textarea>

    <label>Catégorie</label>
    <select name="categories_id" required>
        <?php
        $cats = $pdo->query("SELECT * FROM categories")->fetchAll();
        foreach ($cats as $c):
        ?>
            <option value="<?= $c['id'] ?>">
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Créer</button>
</form>

<?php require 'includes/footer.php'; ?>