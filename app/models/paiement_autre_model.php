<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PaiementAutreModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getEleveInfo($matricule) {
        $stmt = $this->db->prepare("
            SELECT a.matricule, a.nom, a.prenom, t.montant 
            FROM administrateur a 
            INNER JOIN tarifs t ON a.role COLLATE utf8mb4_unicode_ci = t.role COLLATE utf8mb4_unicode_ci 
            WHERE a.archive = FALSE AND a.matricule = :matricule
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enregistrerPaiement($matricule, $nom, $prenom, $montant, $mois) {
        $stmt = $this->db->prepare("
            INSERT INTO suivit_de_paiement (matricule, nom, prenom, mois_payer, montant, etat_paiement)
            VALUES (:matricule, :nom, :prenom, :mois, :montant, 'payé')
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':mois', $mois);
        $stmt->bindParam(':montant', $montant);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function getPaiementInfo($id) {
        $stmt = $this->db->prepare("
            SELECT matricule, nom, prenom, mois_payer, montant, date_paiement
            FROM suivit_de_paiement
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkExistingPayment($matricule, $mois) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM suivit_de_paiement 
            WHERE matricule = :matricule AND mois_payer = :mois
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':mois', $mois);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?>