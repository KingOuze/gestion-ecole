<?php
require_once '../models/paiement_autre_model';

class PaiementController {
    private $model;

    public function __construct($db) {
        $this->model = new PaiementModel($db);
    }

    public function handleRequest() {
        // Initialisation des variables
        $matricule = '';
        $eleveInfo = [];
        $showTable = false;

        // Traiter la soumission du formulaire pour rechercher l'élève
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matricule'])) {
            $matricule = trim($_POST['matricule']);
            $eleveInfo = $this->model->getEleveInfo($matricule);
            $showTable = !empty($eleveInfo);
        }

        // Enregistrement du paiement
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enregistrer'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $montant = $_POST['montant'];
            $mois = $_POST['mois'];

            // Vérifier si un paiement existe déjà pour ce mois
            if ($this->model->paiementExiste($matricule, $mois)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Ce paiement a déjà été effectué pour le mois sélectionné.'
                ]);
                exit;
            }

            // Enregistrement du paiement
            if ($this->model->enregistrerPaiement($matricule, $nom, $prenom, $mois, $montant)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Paiement enregistré avec succès.'
                ]);
                exit;
            }
        }

        return [$matricule, $eleveInfo, $showTable];
    }
}
?>
