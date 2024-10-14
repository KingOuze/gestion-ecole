<?php
class SuiviPaiementController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getAllPaiements() {
        $stmt = $this->model->query("SELECT nom, prenom, matricule, mois_payer, etat_paiement FROM suivit_de_paiement");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}