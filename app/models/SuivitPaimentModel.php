<?php
class SuiviPaiementModel {
    private $db;

    public function __construct($database) {
        $this->db = $database; // $database est l'instance PDO
    }

    public function getAllPaiements() {
        // Préparer la requête
        $stmt = $this->db->query("SELECT nom, prenom, matricule, mois_payer, etat_paiement FROM suivit_de_paiement");
        
        // Exécuter la requête et retourner les résultats
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>