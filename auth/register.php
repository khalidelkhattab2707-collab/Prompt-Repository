<?php
require '../config/db.php';
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Récupération des données
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // 2. Validation basique
    if ($username === '' || $email === '' || $password === '') {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    }

    // 3. Vérifier si l’email existe déjà
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $errors[] = "Cet email est déjà utilisé.";
        }
    }

    // 4. Si tout est OK → insertion
    if (empty($errors)) {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)
        ");

        $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'password' => $hashed
        ]);

        // 5. Connexion automatique après inscription
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';

        header("Location: /prompts/index.php");
        exit;
    }
}
?>

<?php require '../includes/header.php'; ?>

<h1>Inscription</h1>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $e): ?>
            <p><?= htmlspecialchars($e) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <label>Nom d'utilisateur</label>
    <input type="text" name="username" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Mot de passe</label>
    <input type="password" name="password" required>

    <button type="submit">Créer un compte</button>
</form>

<?php require '../includes/footer.php'; ?>