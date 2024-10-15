<?php
$host = 'localhost'; // Adresse de l'hôte (généralement localhost)
$dbname = 'gestion-ecole'; // Nom de votre base de données
$user = 'root'; // Nom d'utilisateur de la base de données
$password = ''; // Mot de passe de la base de données

try {
    // Créer la connexion avec PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Définir le mode d'erreur de PDO sur Exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Vous pouvez ajouter d'autres attributs selon vos besoins
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}

class Database {
    private $host = 'localhost';
    private $db_name = 'gestion-ecole';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function __construct() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }
}


