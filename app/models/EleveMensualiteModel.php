<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class EleveModel {
    private $conn;

    public function __construct($host, $db, $user, $pass) {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getEleveInfo($matricule) {
        $stmt = $this->conn->prepare("
            SELECT e.matricule, e.nom, e.prenom, sp.mois, sp.etat, c.nom_classe AS classe, pe.mensualite 
            FROM eleve e
            LEFT JOIN Suivi_paiements sp ON e.id = sp.id_eleve
            LEFT JOIN paiement_eleve pe ON e.id = pe.id_eleve
            LEFT JOIN classe c ON pe.id_classe = c.id
            WHERE e.matricule = :matricule
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePaymentStatus($matricule, $month, $new_state) {
        $stmt = $this->conn->prepare("
            INSERT INTO Suivi_paiements (id_eleve, mois, etat)
            VALUES ((SELECT id FROM eleve WHERE matricule = :matricule), :mois, :etat)
            ON DUPLICATE KEY UPDATE etat = :etat
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':mois', $month);
        $stmt->bindParam(':etat', $new_state);
        $stmt->execute();
    }

    public function __destruct() {
        $this->conn = null; // Ferme la connexion
    }
}