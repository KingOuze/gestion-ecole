<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/EleveMensualiteModel.php';


class EleveController {
    private $model;

    public function __construct() {
        $host = 'localhost';
        $db   = 'gestion-ecole';
        $user = 'root'; // Remplace par ton nom d'utilisateur
        $pass = '';     // Remplace par ton mot de passe
        $this->model = new EleveModel($host, $db, $user, $pass);
    }

    public function handleRequest() {
        $matricule = '';
        $eleveInfo = [];
        $paiements = [];
        $error_message = '';
        $success_message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['matricule'])) {
                $matricule = $_POST['matricule'];
                 // Debugging
                //  var_dump($matricule);
                $eleveInfo = $this->model->getEleveByMatricule($matricule);
            }

            if (!empty($eleveInfo)) {
                $paiements = $this->model->getPaiementsByEleveId($eleveInfo['id']);
            }

            if (isset($_POST['update_payment'])) {
                $payment_month = $_POST['month'];
                $new_state = $_POST['payment_state'];

                try {
                    $this->model->updatePayment($matricule, $payment_month, $new_state);
                    $success_message = "L'état de paiement a été enregistré avec succès.";
                } catch (PDOException $e) {
                    $error_message = "Erreur lors de la mise à jour : " . $e->getMessage();
                }
            }
        }

        include __DIR__ . '/../views/EleveMensualiteView.php';

    }
}
