<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../routeur/db.php';
require '/../models/EleveMensualiteModel.php';

$model = new EleveModel($host, $db, $user, $pass);

$matricule = '';
$eleveInfo = [];
$error_message = '';
$update_success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $matricule = $_POST['matricule'];
    $eleveInfo = $model->getEleveInfo($matricule);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_payment'])) {
    $month = $_POST['month'];
    $new_state = $_POST['payment_state'];

    try {
        $model->updatePaymentStatus($matricule, $month, $new_state);
        $update_success = ($new_state == '1');
    } catch (PDOException $e) {
        $error_message = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}

// Inclure la vue
include 'view.php';
