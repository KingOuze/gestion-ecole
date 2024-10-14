<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure la connexion à la base de données
require_once __DIR__ . '/../../config/db.php'; // Chemin mis à jour basé sur la nouvelle structure
require_once __DIR__ . '/../models/ConnexionModel.php'; // Inclure le modèle

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

            //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Récupérer l'utilisateur par email
            $user = $this->connexionModel->getUserByEmail($email);

            // Vérifier si l'utilisateur existe
            if ($user) {
                // Comparer le mot de passe
                if ($password === $user['mot_de_passe']) {
                    // Enregistrer les informations de session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user['id_admin'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    // Redirection selon le rôle
                    if ($user['role'] == 'administrateur') {
                        header('Location: /public/index.php?action=index&role=administrateur');
                        exit();
                    } elseif ($user['role'] == 'prof' || $user['role'] == 'enseignant') {
                        header('Location: /public/index.php?action=index&role=enseignant');
                        exit();
                    } elseif ($user['role'] == 'comptable') {
                        header('Location: /public/index.php?action=index&role=comptable');
                        exit();
                    } elseif ($user['role'] == 'surveillant') {
                        header('Location: /public/index.php?action=index&role=surveillant');
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
$controller = new ConnexionController($db);
$controller->login();
?>
