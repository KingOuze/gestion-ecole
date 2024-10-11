<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ModelMensualiteEleve.php

class Eleve {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function countTotalEleves(): mixed {
        // Exécute la requête et récupère le résultat
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM eleve");
        
        // Récupère le résultat sans vérifier l'exécution car elle est déjà effectuée
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie si le résultat existe et retourne le total
        return $result ? $result['total'] : 0; // Retourne 0 si aucun résultat
    }
}