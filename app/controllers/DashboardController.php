<?php
// DashboardController.php
require_once '../models/UserModel.php';
require_once '../models/StatModel.php';

class DashboardController {
    private $userModel;
    private $statModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
        $this->statModel = new StatModel($db);
    }

    public function displayDashboard() {
        // Démarrer la session
        session_start();
        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['email'])) {
            // Rediriger vers la page de connexion si non connecté
            header("Location: ../views/login.php");
            exit();
        }

        // Récupérer l'email depuis la session
        $email = $_SESSION['email'];

        // Récupérer les informations de l'utilisateur
        $user = $this->userModel->getUserByEmail($email);
        if (!$user) {
            // Si l'utilisateur n'existe pas, déconnecter et rediriger
            session_destroy();
            header("Location: ../views/login.php");
            exit();
        }
// Initialisez la variable $user (peut-être récupérée à partir d'une session ou d'une base de données)
$user = isset($_SESSION['user']) ? $_SESSION['user'] : ['prenom' => 'Invité', 'nom' => '', 'role' => ''];

// Initialisez les autres variables
$totalElevesPrimaire = 0; // ou une valeur récupérée de votre base de données
$totalElevesSecondaire = 0; // ou une valeur récupérée de votre base de données
$totalProfesseurs = 0; // ou une valeur récupérée de votre base de données
$totalEmployes = 0; // ou une valeur récupérée de votre base de données
$totalAdmins = 0; // ou une valeur récupérée de votre base de données
$totalComptables = 0; // ou une valeur récupérée de votre base de données
$totalSurveillants = 0; // ou une valeur récupérée de votre base de données
$pourcentageCFEE = 0; // ou une valeur récupérée de votre base de données
$pourcentageBFEM = 0; // ou une valeur récupérée de votre base de données
$pourcentageBAC = 0; // ou une valeur récupérée de votre base de données

        // Charger la vue du tableau de bord et passer les données nécessaires
        require '../views/dashboard.php';
    }
}
