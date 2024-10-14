<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure les fichiers nécessaires
require '../config/db.php';
require '../app/models/PaieModel.php';
require '../app/controllers/PaieProfController.php';

// Instanciation du contrôleur
$controller = new PaieProf($db);

// Vérification de la méthode de requête pour le paiement ou l'annulation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = $_POST['matricule'];
    $mois = $_POST['mois'];
    
    if (isset($_POST['payer'])) {
        $controller->payer($matricule, $mois);
    } elseif (isset($_POST['annuler'])) {
        $controller->annulerPaiement($matricule, $mois);
    }
}

// Recherche et affichage des paiements
$search = $_GET['search'] ?? '';
$paiements = $controller->obtenirPaiements($search, null);

// Inclure la vue
require '../app/views/paiement_view.php';
