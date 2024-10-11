<?php
class SuiviPaiementModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllPaiements() {
        $stmt = $this->db->query("SELECT nom, prenom, matricule, mois_payer, etat_paiement FROM suivit_de_paiement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
