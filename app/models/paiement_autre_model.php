<?php
class PaiementModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer les informations de l'élève par matricule
    public function getEleveInfo($matricule) {
        $stmt = $this->conn->prepare("
            SELECT a.matricule, a.nom, a.prenom, t.montant 
            FROM administrateur a 
            INNER JOIN tarifs t ON a.role COLLATE utf8mb4_unicode_ci = t.role COLLATE utf8mb4_unicode_ci 
            WHERE a.archivage = FALSE AND a.matricule = :matricule
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Enregistrer le paiement
    public function enregistrerPaiement($matricule, $nom, $prenom, $mois, $montant) {
        $moisEnToutes = $this->convertirMoisEnTexte($mois);
    
        $insertStmt = $this->conn->prepare("
            INSERT INTO suivit_de_paiement (matricule, nom, prenom, mois_payer, montant, etat_paiement)
            VALUES (:matricule, :nom, :prenom, :mois, :montant, 'payé')
        ");
        $insertStmt->bindParam(':matricule', $matricule);
        $insertStmt->bindParam(':nom', $nom);
        $insertStmt->bindParam(':prenom', $prenom);
        $insertStmt->bindParam(':mois', $moisEnToutes);
        $insertStmt->bindParam(':montant', $montant);
        return $insertStmt->execute();
    }
    
    // Convertir le mois en texte
    private function convertirMoisEnTexte($mois) {
        $moisEnToutes = array(
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre'
        );
    
        return $moisEnToutes[$mois];
    }

    // Vérifier si un paiement existe déjà pour un mois donné
    public function paiementExiste($matricule, $mois) {
        $checkStmt = $this->conn->prepare("
            SELECT COUNT(*) FROM suivit_de_paiement 
            WHERE matricule = :matricule AND mois_payer = :mois
        ");
        $checkStmt->bindParam(':matricule', $matricule);
        $checkStmt->bindParam(':mois', $mois);
        $checkStmt->execute();
        return $checkStmt->fetchColumn() > 0;
    }

    // Récupérer le dernier numéro de reçu
    public function getDernierRecu() {
        $stmt = $this->conn->prepare("
            SELECT MAX(id) AS dernier_recu FROM suivit_de_paiement
        ");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>