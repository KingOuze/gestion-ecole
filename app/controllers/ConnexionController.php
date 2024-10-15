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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $user = $this->connexionModel->getUserByEmail($email);

            if ($user && is_array($user)) {
                if ($password === $user['mot_de_passe']) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user['id_admin'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] == 'administrateur') {
                        header('Location: /gestion-ecole/public/index.php?action=index&role=administrateur');
                        exit();
                    } elseif ($user['role'] == 'professeur' || $user['role'] == 'enseignant') {
                        header('Location: /gestion-ecole/public/index.php?action=index&role=enseignant');
                        exit();
                    } elseif ($user['role'] == 'comptable') {
                        header('Location: /gestion-ecole/public/index.php?action=index&role=comptable');
                        exit();
                    } elseif ($user['role'] == 'surveillant') {
                        header('Location: /gestion-ecole/public/index.php?action=index&role=surveillant');
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

        include __DIR__ . '/../views/connexion/connexion.php';
    }

}

// Initialiser le contrôleur et appeler la méthode login
$controller = new ConnexionController($db);
$controller->login();
?>