
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '/gestion-ecole/app/controllers/DashboardController.php';

$controller = new DashboardController();
$controller->index();

require_once '../config/db.php';
require_once '../app/controllers/ComptableController.php';
require_once '../app/controllers/SurveillantController.php';
require_once '../app/controllers/ProfesseurController.php';
require_once '../app/controllers/AdmnistrateurController.php';
require_once '../app/controllers/EnseignantController.php';
require_once '../app/controllers/MatiereController.php';
require_once '../app/controllers/ClasseController.php';
require_once '../app/controllers/EleveController.php';

$controllers = [
    'administrateur' => new AdministrateurController($db),
    'surveillant' => new SurveillantController($db),
    'professeur' => new ProfesseurController($db),
    'comptable' => new ComptableController($db),
    'enseignant' => new EnseignantController($db),
    'eleve' => new EleveController($db),
    'classe' => new ClasseController($db),
    'matiere' => new MatiereController($db),
];

try {
    // Récupérer l'action et l'ID depuis l'URL
    $action = $_GET['action'] ?? 'index';
    $id = $_GET['id'] ?? null;

    function handleRequest($role, $action, $id, $controllers) {
        if (!isset($controllers[$role])) {
            echo "Rôle inconnu: " . htmlspecialchars($role);
            return;
        }
        $controller = $controllers[$role];

        switch ($action) {
            case 'create':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $controller->add();
                } else {
                    echo "Méthode non POST.";
                }
                break;

            case 'update':
                if ($_SERVER["REQUEST_METHOD"] == "POST" && $id) {
                    $controller->update($id);
                } else {
                    echo "Méthode non POST ou ID manquant.";
                }
                break;

            case 'show':
                if ($id) {
                    $controller->showOne($id);
                } else {
                    echo "ID manquant.";
                }
                break;

            case 'delete':
                if ($id) {
                    $controller->destroy($id);
                } else {
                    echo "ID manquant.";
                }
                break;

            case 'index':
            default:
                echo "Affichage de l'index<br>";
                include '../app/views/admin/ajouter.php';
                break;
        }
    }

    // Vérifiez si une action spécifique est demandée
    if (isset($_POST['role'])) {
        $role = htmlspecialchars(trim($_POST['role']));
        handleRequest($role, $action, $id, $controllers);
    } else {
        //echo "Le rôle est requis.";
        $role = 'administrateur';
        handleRequest($role, $action, $id, $controllers);
    }

} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
