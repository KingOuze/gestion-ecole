<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('C:/xmp/htdocs/gestion-ecole/config/db.php'); // Assurez-vous d'utiliser require_once
require_once('C:/xmp/htdocs/gestion-ecole/app/controllers/AdminController.php'); // Idem
require_once('C:/xmp/htdocs/gestion-ecole/app/models/Admin.php'); // Idem

// Création de la connexion à la base de données
$database = new Database();
$conn = $database->conn;

// Initialisation du contrôleur
$controller = new AdminController($conn);

// Vérification des actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'update':
            // Assurez-vous de récupérer les données à partir de $_POST
            $data = $_POST; // Cela doit être ajusté selon vos besoins
            $controller->updateAdmin($data);
            header("Location: http://localhost/gestion-ecole/app/views/admin/listAdmin.php?message=Administrateur archivé avec succès.");
            exit;
        

        case 'archiveAdmin':
           $id_admin = $_GET ['id'];
           if($controller->archiveAdmin($id_admin)) {
                header("Location: http://localhost/gestion-ecole/app/views/admin/listAdmin.php?message=Administrateur archivé avec succès.");
                exit;
           }
            
            break;


        default:
            // Rediriger ou afficher une page d'erreur
            header("Location: http://localhost/gestion-ecole/app/views/error.php");
            exit;
    }
} else {
    // Afficher la liste des administrateurs ou une page d'accueil par défaut
    header("Location: http://localhost/gestion-ecole/app/views/admin/listAdmin.php");
    exit;
}
