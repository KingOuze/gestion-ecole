<?php
require_once ('/gestion-ecole/config/db.php');; // Inclusion du fichier de connexion
require_once ('/gestion-ecole/app/models/paiement_autre_model.php');

class PaiementAutreController {
    private $model;

    public function __construct($db) {
        $this->model = new PaiementAutreModel($db);
    }

    public function handleRequest() {
        $matricule = '';
        $eleveInfo = [];
        $showTable = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matricule'])) {
            $matricule = trim($_POST['matricule']);
            $eleveInfo = $this->model->getEleveInfo($matricule);
            $showTable = !empty($eleveInfo);
        }

        include ('/gestion-ecole/app/views/paiement/paiement_autre.php');
        
    }

    public function enregistrerPaiement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enregistrer'])) {
            $matricule = $_POST['matricule'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $montant = $_POST['montant'];
            $mois = $_POST['mois'];

            // Enregistrer le paiement et récupérer l'ID
            $paiementId = $this->model->enregistrerPaiement($matricule, $nom, $prenom, $montant, $mois);

            if ($paiementId) {
                // Récupérer les informations du paiement pour le reçu
                $paiementInfo = $this->model->getPaiementInfo($paiementId);
                echo json_encode(['status' => 'success', 'paiementInfo' => $paiementInfo]); // Réponse à l'appel AJAX
            } else {
                echo json_encode(['status' => 'error']);
            }
        }
    }

    public function getReceipt() {
        if (isset($_GET['getReceiptId'])) {
            $id = $_GET['getReceiptId'];
            $paiementInfo = $this->model->getPaiementInfo($id);
            
            if ($paiementInfo) {
                echo json_encode(['status' => 'success', 'paiementInfo' => $paiementInfo]);
            } else {
                echo json_encode(['status' => 'error']);
            }
            exit; // Pour arrêter l'exécution
        }
    }
}
?>
