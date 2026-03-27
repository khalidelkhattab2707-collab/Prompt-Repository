<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prompt Repo</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<header>
    <nav>
        <a href="/projet/index.php">Prompts</a>
        <a href="/projet/create.php">Ajouter un prompt</a>

        <?php session_start(); ?>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="/auth/logout.php">Déconnexion</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="/admin/index.php">Admin</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="/auth/login.php">Connexion</a>
            <a href="/auth/register.php">Inscription</a>
        <?php endif; ?>
    </nav>
</header>

<main>