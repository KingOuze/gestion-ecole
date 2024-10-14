<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../config/db.php'; 
require_once '../../app/models/paiement_autre_model.php';

class PaiementAutreController {
    private $model;

    public function __construct($db) {
        $this->model = new PaiementAutreModel($db);
    }

    public function handleRequest() {
        $matricule = '';
        $eleveInfo = [];
        $showTable = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['matricule'])) {
                $matricule = trim($_POST['matricule']);
                $eleveInfo = $this->model->getEleveInfo($matricule);
                $showTable = !empty($eleveInfo);
            }

            if (isset($_POST['enregistrer'])) {
                $this->enregistrerPaiement($matricule);
            }
        }

        include '../../app/views/paiement_autre.php';
    }

    private function enregistrerPaiement($matricule) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $montant = $_POST['montant'];
        $mois = $_POST['mois'];

        $paiementExistant = $this->model->checkExistingPayment($matricule, $mois);

        if ($paiementExistant) {
            echo json_encode(['status' => 'error', 'message' => 'Ce paiement a déjà été effectué pour le mois sélectionné.']);
            exit;
        }

        $this->model->enregistrerPaiement($matricule, $nom, $prenom, $montant, $mois);
        echo json_encode(['status' => 'success', 'message' => 'Paiement enregistré avec succès.']);
        exit;
    }
}
