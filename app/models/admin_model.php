<?php

require_once '../../config/db.php'; // Inclure votre fichier de connexion à la base de données

class AdminModel {
    private $conn;

    public function __construct() {
        $this->conn = $GLOBALS['conn']; // Supposons que votre connexion est stockée dans une variable globale
    }

    // Générer un matricule unique
    private function generateMatricule() {
        return uniqid('MATRICULE_'); // Exemple de matricule
    }

    // Créer un nouvel administrateur
    public function createAdmin($nom, $prenom, $email, $telephone, $mot_de_passe, $role) {
        $matricule = $this->generateMatricule(); // Génération du matricule
        $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT); // Hachage du mot de passe

        $stmt = $this->conn->prepare("INSERT INTO administrateur (matricule, nom, prenom, email, telephone, mot_de_passe, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $matricule, $nom, $prenom, $email, $telephone, $hashedPassword, $role);
        return $stmt->execute();
    }
}