<?php
require '../config/db.php';
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1 Récupération des données
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 2 Validation
    if ($email === '' || $password === '') {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    }

    // 3 Vérifier si l'utilisateur existe
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            $errors[] = "Aucun compte trouvé avec cet email.";
        }
    }

    // 4 Vérifier le mot de passe
    if (empty($errors)) {
        if (!password_verify($password, $user['password'])) {
            $errors[] = "Mot de passe incorrect.";
        }
    }

    // 5 Si Connexion OK → création de la session
    if (empty($errors)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location:../index.php");
        exit;
    }
}
?>

<?php require '../includes/header.php'; ?>

<h1>Connexion</h1>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $e): ?>
            <p><?= htmlspecialchars($e) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Mot de passe</label>
    <input type="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>

<?php require '../includes/footer.php'; ?>