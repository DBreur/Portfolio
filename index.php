<?php
// Auteur: Dion Breur
// Functie: Portfolio beheren

// Initialisatie
include_once 'functions.php';

// Main
$skills = getSkills();
$projects = getProjects();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <link rel="icon" type="image/png" href="img/portfolio-web-logo.png?v=202605141451">
    <link rel="apple-touch-icon" href="img/portfolio-web-logo.png?v=202605141451">
    <link rel="stylesheet" href="scss/main.css">
</head>
<body>
    <a class="skip-link" href="#main-content">Ga naar hoofdinhoud</a>
    <header class="site-header">
        <h1>MY POoRTFOLIO</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="<?= isAdminLoggedIn() ? 'admin.php' : 'login.php' ?>"><?= isAdminLoggedIn() ? 'Admin' : 'Login' ?></a></li>
            </ul>
        </nav>
    </header>

    <main id="main-content">
        <section id="home" class="home">
            <section class="card short-intro">
                <article>
                    <p>Dion - Front-end</p>
                    <p>Developer</p>
                    <p>"Ik bouw strakke websites"</p>
                    <a class="projects-btn" href="#projects">Bekijk mijn werk</a>
                </article>
            </section>

            <section class="card more-about">
                <article>
                    <h2>Wat meer over mij</h2>
                    <p>De opleiding die ik volg is Software Developer. Ik heb een krantenwijk gehad en werk nu bij de scapino.</p>
                </article>
            </section>

            <img class="dev-picto" src="img/dev-picto.png" alt="Developer illustration">
        </section>

        <section id="skills" class="section-title">
            <h2>MY SKILLS</h2>
        </section>

        <section class="skills-grid">
            <img class="avatar" src="img/avatar.png" alt="Avatar">

            <?php if (count($skills) > 0): ?>
                <?php foreach ($skills as $skill): ?>
                    <article class="card skill-card">
                        <h3><?= e($skill['title']) ?></h3>
                        <p><?= e($skill['description']) ?></p>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <article class="card skill-card">
                    <h3>Geen skills gevonden</h3>
                    <p>Importeer eerst database.sql of voeg skills toe via de adminpagina.</p>
                </article>
            <?php endif; ?>
        </section>

        <section id="projects" class="section-title">
            <h2>MY PROJECTS</h2>
        </section>

        <section class="projects-grid">
            <?php if (count($projects) > 0): ?>
                <?php foreach ($projects as $project): ?>
                    <a class="card project-card" href="<?= e($project['project_url']) ?>" target="_blank" rel="noopener">
                        <img src="<?= e($project['image_path']) ?>" alt="<?= e($project['image_alt']) ?>">
                        <span><?= e($project['title']) ?></span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <article class="card project-card empty-card">
                    <span>Geen projecten gevonden</span>
                </article>
            <?php endif; ?>
        </section>
    </main>

    <footer class="site-footer">
        <p>Tel: 06 13962774</p>
        <p>E-mail: d.breur010@gmail.com</p>
        <p>Github link: https://github.com/DBreur/Project</p>
    </footer>
</body>
</html>
