<?php
// Auteur: Dion Breur
// Functie: Admin login

include_once 'functions.php';

if (isAdminLoggedIn()) {
    redirect('admin.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (loginAdmin($username, $password)) {
        redirect('admin.php');
    }

    $error = 'Gebruikersnaam of wachtwoord is niet goed.';
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
    <link rel="icon" type="image/png" href="img/portfolio-web-logo.png?v=202605141451">
    <link rel="apple-touch-icon" href="img/portfolio-web-logo.png?v=202605141451">
    <link rel="stylesheet" href="scss/main.css">
</head>
<body>
    <header class="site-header">
        <h1>ADMIN LOGIN</h1>
        <nav>
            <ul>
                <li><a href="index.php">Portfolio</a></li>
            </ul>
        </nav>
    </header>

    <main class="admin-page">
        <section class="card admin-panel login-panel">
            <h2>Inloggen</h2>

            <?php if ($error): ?>
                <p class="message error"><?= e($error) ?></p>
            <?php endif; ?>

            <form method="post" class="admin-form">
                <label for="username">Gebruikersnaam</label>
                <input id="username" name="username" type="text" required>

                <label for="password">Wachtwoord</label>
                <input id="password" name="password" type="password" required>

                <button class="projects-btn" type="submit">Log in</button>
            </form>
        </section>
    </main>
</body>
</html>
