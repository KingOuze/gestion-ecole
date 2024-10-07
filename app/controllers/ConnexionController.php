<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure la connexion à la base de données
require_once ('/opt/lampp/htdocs/gestion-ecole/config/db.php'); // Chemin mis à jour basé sur la nouvelle structure
require_once ('/opt/lampp/htdocs/gestion-ecole/app//models/ConnexionModel.php'); // Inclure le modèle

session_start();

class ConnexionController {
    private $connexionModel;

    public function __construct($db) {
        $this->connexionModel = new ConnexionModel($db);
    }

    public function login() {
        $errorMessage = "";

        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer et nettoyer les données du formulaire
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            // Récupérer l'utilisateur par email
            $user = $this->connexionModel->getUserByEmail($email);

            // Vérifier si l'utilisateur existe
            if ($user) {
                // Comparer le mot de passe
                if ($password === $user['mot_de_passe']) {
                    // Enregistrer les informations de session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    // Redirection selon le rôle
                    if ($user['role'] == 'admin') {
                        header('Location: ../views/dashboard.php');
                        exit();
                    } elseif ($user['role'] == 'prof' || $user['role'] == 'enseignant') {
                        header('Location: ../views/enseignantviews.php');
                        exit();
                    } elseif ($user['role'] == 'comptable') {
                        header('Location: ../views/comptabilite.html');
                        exit();
                    } elseif ($user['role'] == 'surveillant') {
                        header('Location: ../views/surveillant.html');
                        exit();
                    } else {
                        $errorMessage = "Rôle inconnu.";
                    }
                } else {
                    $errorMessage = "Mot de passe incorrect.";
                }
            } else {
                $errorMessage = "Email non trouvé.";
            }
        }

        // Inclure la vue pour afficher le formulaire de connexion
        include __DIR__ . '/../views/connexion/connexion.php';
    }
}

// Initialiser le contrôleur et appeler la méthode login
$controller = new ConnexionController($conn);
$controller->login();

