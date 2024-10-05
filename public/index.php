<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../config/db.php';
require_once '../app/controllers/ComptableController.php';
require_once '../app/controllers/SurveillantController.php';
require_once '../app/controllers/ProfesseurController.php';
require_once '../app/controllers/AdmnistrateurController.php';
require_once '../app/controllers/EnseignantController.php';
require_once '../app/controllers/MatiereController.php';
require_once '../app/controllers/ClasseController.php';


$compt = new ComptableController($db);
$surveil = new SurveillantController($db);
$profes = new ProfesseurController($db);
$admin = new AdministrateurController($db);
$enseign = new EnseignantController($db);
$classe = new ClasseController($db);
$matiere = new MatiereController($db);


try {
    // Récupérer l'action et l'ID depuis l'URL
    $action = $_GET['action'] ?? 'index';
    $id = $_GET['id'] ?? null;

    // Routeur simple
    switch ($action) {
        case 'create':
            echo "Création d'un nouvel utilisateur<br>";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $role = htmlspecialchars(trim($_POST['role']));
                echo "Rôle: " . $role . "<br>";
                switch ($role) {
                    case 'administrateur':
                        $admin->add();
                        break;
                    case 'surveillant':

                        $surveil->add(); // Appel à la méthode add pour créer un surveillant
                        
                        break;
                        
                    case 'professeur':
                        
                        $profes->add(); // Appel à la méthode add pour créer un professeur
                        
                        break;
                        
                    case 'comptable':
                        
                        $compt->add(); // Appel à la méthode add pour créer un comptable
                        
                        break;
                        
                    case 'enseignant':
                        
                        $enseign->add(); // Appel à la méthode add pour créer un enseignant
                        
                        break;
                    default:
                        echo "Rôle inconnu: " . $role;
                        break;
                    
                }
            } else {
                echo "Méthode non POST.";
            }
            break;

        case 'update':
            if ($_SERVER["REQUEST_METHOD"] == "POST" && $id) {
                $controller = $admin; // Assurez-vous d'utiliser le bon contrôleur ici
                $controller->update($id);
            } else {
                // Afficher le formulaire de mise à jour
                $controller = $admin; // Assurez-vous d'utiliser le bon contrôleur ici
                $data = $controller->model->getById($id);
                include '../views/update.php'; // Formulaire HTML
            }
            break;

        case 'show':
            
            break;

        case 'delete':
            if ($id) {
                $controller = $admin; // Assurez-vous d'utiliser le bon contrôleur ici
                $controller->destroy($id);
            }
            break;

        case 'index':
            default:
                echo "Affichage de l'index<br>";
                $primaires = $classe->getByNiveau('primaire');
                $secondaires = $classe->getByNiveau('secondaire');
                $matieres = $matiere->index();
                include '../app/views/admin/ajouter.php';
                break;
    }
    
}catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}