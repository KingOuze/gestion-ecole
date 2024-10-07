<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../'); // Chemin absolu de ton application
}

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'gestion-ecole'); // Remplace par le nom de ta base de données
}

if (!defined('DB_USER')) {
    define('DB_USER', 'root'); // Remplace par ton utilisateur
}

if (!defined('DB_PASS')) {
    define('DB_PASS', ''); // Remplace par ton mot de passe
}

try {
    // Établir la connexion à la base de données
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Fonction pour récupérer les données du tableau de bord
if (!function_exists('getDashboardData')) {
    function getDashboardData() {
        global $pdo; // Utiliser la variable globale $pdo

        $elevesCount = $pdo->query("SELECT COUNT(*) FROM eleve")->fetchColumn();
        $administrateursCount = $pdo->query("SELECT COUNT(*) FROM administrateur")->fetchColumn();
        $surveillantsCount = $pdo->query("SELECT COUNT(*) FROM surveillant")->fetchColumn();
        $enseignantsCount = $pdo->query("SELECT COUNT(*) FROM enseignant")->fetchColumn();
        $professeursCount = $pdo->query("SELECT COUNT(*) FROM professeur")->fetchColumn();
        $comptablesCount = $pdo->query("SELECT COUNT(*) FROM comptable")->fetchColumn();

        return [
            'eleve' => $elevesCount,
            'administrateur' => $administrateursCount,
            'surveillant' => $surveillantsCount,
            'enseignant' => $enseignantsCount,
            'professeur' => $professeursCount,
            'comptable' => $comptablesCount,
        ];
    }
}
?>