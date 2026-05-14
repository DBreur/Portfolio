<?php
// Auteur: Dion Breur
// Functie: Skills en projecten beheren

include_once 'functions.php';
requireAdmin();

$conn = connectDb();

if (!$conn) {
    die('Kan geen verbinding maken met de database. Controleer config.php en importeer database.sql.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_skill') {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ];

        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE skills SET title = :title, description = :description, sort_order = :sort_order WHERE id = :id");
            $data['id'] = $id;
            $stmt->execute($data);
        } else {
            $stmt = $conn->prepare("INSERT INTO skills (title, description, sort_order) VALUES (:title, :description, :sort_order)");
            $stmt->execute($data);
        }

        redirect('admin.php#skills-admin');
    }

    if ($action === 'delete_skill') {
        $stmt = $conn->prepare("DELETE FROM skills WHERE id = :id");
        $stmt->execute(['id' => (int) ($_POST['id'] ?? 0)]);
        redirect('admin.php#skills-admin');
    }

    if ($action === 'save_project') {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'project_url' => trim($_POST['project_url'] ?? ''),
            'image_path' => trim($_POST['image_path'] ?? ''),
            'image_alt' => trim($_POST['image_alt'] ?? ''),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ];

        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE projects SET title = :title, project_url = :project_url, image_path = :image_path, image_alt = :image_alt, sort_order = :sort_order WHERE id = :id");
            $data['id'] = $id;
            $stmt->execute($data);
        } else {
            $stmt = $conn->prepare("INSERT INTO projects (title, project_url, image_path, image_alt, sort_order) VALUES (:title, :project_url, :image_path, :image_alt, :sort_order)");
            $stmt->execute($data);
        }

        redirect('admin.php#projects-admin');
    }

    if ($action === 'delete_project') {
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = :id");
        $stmt->execute(['id' => (int) ($_POST['id'] ?? 0)]);
        redirect('admin.php#projects-admin');
    }
}

$skills = getSkills();
$projects = getProjects();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio admin</title>
    <link rel="stylesheet" href="scss/main.css">
</head>
<body>
    <header class="site-header">
        <h1>PORTFOLIO ADMIN</h1>
        <nav>
            <ul>
                <li><a href="index.php">Portfolio</a></li>
                <li><a href="logout.php">Uitloggen</a></li>
            </ul>
        </nav>
    </header>

    <main class="admin-page">
        <section id="skills-admin" class="card admin-panel">
            <h2>Skills beheren</h2>

            <form method="post" class="admin-form new-form">
                <input type="hidden" name="action" value="save_skill">
                <input type="hidden" name="id" value="0">

                <label>Titel
                    <input name="title" type="text" placeholder="Bijvoorbeeld: Web development" required>
                </label>

                <label>Beschrijving
                    <textarea name="description" rows="2" placeholder="HTML, CSS, JavaScript" required></textarea>
                </label>

                <label>Volgorde
                    <input name="sort_order" type="number" value="0" required>
                </label>

                <button class="projects-btn" type="submit">Skill toevoegen</button>
            </form>

            <div class="admin-list">
                <?php foreach ($skills as $skill): ?>
                    <form method="post" class="admin-form edit-row">
                        <input type="hidden" name="action" value="save_skill">
                        <input type="hidden" name="id" value="<?= (int) $skill['id'] ?>">

                        <label>Titel
                            <input name="title" type="text" value="<?= e($skill['title']) ?>" required>
                        </label>

                        <label>Beschrijving
                            <textarea name="description" rows="2" required><?= e($skill['description']) ?></textarea>
                        </label>

                        <label>Volgorde
                            <input name="sort_order" type="number" value="<?= (int) $skill['sort_order'] ?>" required>
                        </label>

                        <button class="projects-btn" type="submit">Opslaan</button>
                    </form>

                    <form method="post" class="delete-form">
                        <input type="hidden" name="action" value="delete_skill">
                        <input type="hidden" name="id" value="<?= (int) $skill['id'] ?>">
                        <button type="submit">Verwijderen</button>
                    </form>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="projects-admin" class="card admin-panel">
            <h2>Projecten beheren</h2>

            <form method="post" class="admin-form new-form">
                <input type="hidden" name="action" value="save_project">
                <input type="hidden" name="id" value="0">

                <label>Titel
                    <input name="title" type="text" placeholder="Bijvoorbeeld: Ouderavond" required>
                </label>

                <label>Project link
                    <input name="project_url" type="url" placeholder="https://github.com/..." required>
                </label>

                <label>Afbeelding pad
                    <input name="image_path" type="text" placeholder="img/Ouderavond.png" required>
                </label>

                <label>Alt tekst
                    <input name="image_alt" type="text" placeholder="Afbeelding van mijn project" required>
                </label>

                <label>Volgorde
                    <input name="sort_order" type="number" value="0" required>
                </label>

                <button class="projects-btn" type="submit">Project toevoegen</button>
            </form>

            <div class="admin-list">
                <?php foreach ($projects as $project): ?>
                    <form method="post" class="admin-form edit-row">
                        <input type="hidden" name="action" value="save_project">
                        <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">

                        <label>Titel
                            <input name="title" type="text" value="<?= e($project['title']) ?>" required>
                        </label>

                        <label>Project link
                            <input name="project_url" type="url" value="<?= e($project['project_url']) ?>" required>
                        </label>

                        <label>Afbeelding pad
                            <input name="image_path" type="text" value="<?= e($project['image_path']) ?>" required>
                        </label>

                        <label>Alt tekst
                            <input name="image_alt" type="text" value="<?= e($project['image_alt']) ?>" required>
                        </label>

                        <label>Volgorde
                            <input name="sort_order" type="number" value="<?= (int) $project['sort_order'] ?>" required>
                        </label>

                        <button class="projects-btn" type="submit">Opslaan</button>
                    </form>

                    <form method="post" class="delete-form">
                        <input type="hidden" name="action" value="delete_project">
                        <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">
                        <button type="submit">Verwijderen</button>
                    </form>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>
