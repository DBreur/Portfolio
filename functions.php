<?php
// Auteur: Dion Breur
// Functie: Functies declareren

// Initialisatie
include_once 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verbinding maken met de portfolio database server
function connectDb(){
    try{
        // Verbinding maken
        $conn = new PDO(
            "mysql:host=" . SERVERNAME . ";dbname=" . DATABASE . ";charset=utf8mb4",
            USERNAME,
            PASSWORD
        );

        // Error modus instellen
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        // Verbinding teruggeven
        return $conn;
    } catch(PDOException $e){
        return null;
    }
}

function getSkills(): array
{
    $conn = connectDb();

    if (!$conn) {
        return [];
    }

    $stmt = $conn->query("SELECT * FROM skills ORDER BY sort_order ASC, id ASC");
    return $stmt->fetchAll();
}

function getProjects(): array
{
    $conn = connectDb();

    if (!$conn) {
        return [];
    }

    $stmt = $conn->query("SELECT * FROM projects ORDER BY sort_order ASC, id ASC");
    return $stmt->fetchAll();
}

function loginAdmin(string $username, string $password): bool
{
    $conn = connectDb();

    if (!$conn) {
        return false;
    }

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        return true;
    }

    return false;
}

function isAdminLoggedIn(): bool
{
    return isset($_SESSION['admin_id']);
}

function requireAdmin(): void
{
    if (!isAdminLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function logoutAdmin(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}
?>
