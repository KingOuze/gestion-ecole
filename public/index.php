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
require_once '../app/controllers/EleveController.php';

$admin = new AdministrateurController($db);
$surveil = new SurveillantController($db);
$prof = new ProfesseurController($db);
$compta = new ComptableController($db);
$enseign = new EnseignantController($db);
$eleve = new EleveController($db);
$classe = new ClasseController($db);
$matiere = new MatiereController($db);




try {

    // Récupérer l'action et l'ID depuis l'URL
    $action = $_GET['action'] ?? null;
    $id = $_GET['id'] ?? null;
    $role = $_GET['role'] ?? null;
    

    switch ($action) {

        case 'create':
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $role = htmlspecialchars(trim($_POST['role']));
                switch ($role) {
                    case 'administrateur':
                        $admin->add();
                        break;
                    case 'surveillant':
                        $surveil->add();
                        break;
                    case 'professeur':
                        $prof->add();
                        break;
                    case 'comptable':
                        $compta->add();
                        break;
                    case 'enseignant':
                        $enseign->add();
                        break;
                    case 'eleve':
                        $eleve->add();
                        break;
                    default:
                        echo "Role Inconnu";
                            break;
                    }
            }
            break;

        case 'update':
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                $role = htmlspecialchars(trim($_GET["role"]));
                
                switch ($role) {
                    case 'administrateur':
                        $admin->update($id);
                        break;
                    case 'surveillant':
                        $surveil->update($id);
                        break;
                    case 'professeur':
                        $prof->update($id);
                        break;
                    case 'comptable':
                        $compta->update($id);
                        break;
                    case 'enseignant':
                        $enseign->update($id);
                        break;
                    case 'eleve':
                        $eleve->update($id);
                        break;
                    default:
                        echo "Role Inconnu";
                            break;
                    }
            }
            break;
        case 'liste':
            switch ($role) {
                case 'administrateur':
                    
                    $users = $admin->index();
                    include '../app/views/admin/soumission.php';
                    break;
                case 'surveillant':
                    $users = $surveil->index();
                    include '../app/views/admin/soumission.php';
                    break;
                case 'professeur':
                    $users = $prof->index();
                    include '../app/views/admin/soumission.php';
                    break;
                case 'comptable':
                    $users = $compta->index();
                    include '../app/views/admin/soumission.php';
                    break;
                case 'enseignant':
                    $users = $enseign->index();
                    include '../app/views/admin/soumission.php';
                    break;
                case 'eleve':
                    $users = $eleve->index();
                    include '../app/views/admin/soumission.php';
                    break;
                default:
                    echo "Role Inconnu";
                        break;
                }
            break;          
        case 'ajouter':
            $allClass = $classe->index();
            $primaires = $classe->getByNiveau('primaire');
            $secondaires = $classe->getByNiveau('secondaire');
            $matieres = $matiere->index();
            include '../app/views/admin/ajouter.php';
            break;
            
            
        case 'index':
            switch ($role) {
                case 'administrateur':
                    $nbAdmin = $admin->count();
                    $nbSurvei = $surveil->count();
                    $nbEleve = $eleve->count();
                    $nbComp= $compta->count();
                    $nbenseignant = $enseign->count();
                    $nbprofesseur = $prof->count();
                    include '../app/views/dashboard.php';
                    break;
                    
                case 'comptable':
                    include '../app/views/comptableviews.php';
                    break;

                case 'professeur':
                    include '../app/views/dashboard_prof.php';
                    break;

                case 'surveillant':
                    include '../app/views/surveillantviews.php';
                    break;

                case 'enseignant':
                    include '../app/views/enseignantviews.php';
                    break;

                case 'eleve':
                    include '../app/views/enseignantviews.php';
                    break;

                default:
                    # code...
                    break;
            }
            break;

        case 'edite':
            switch ($role) {
                case 'administrateur':
                    
                    $users = $admin->showOne($id);                     
                    include '../app/views/admin/edite.php';
                    break;
                    
                case 'comptable':
                    
                    $users = $compta->showOne($id);                     
                    include '../app/views/admin/edite.php';
                    break;

                case 'professeur':

                    $secondaires = $classe->getByNiveau('secondaire');
                    $matieres = $matiere->index(); 
                    $users = $prof->showOne($id);                     
                    include '../app/views/admin/edite.php';
                    break;

                case 'surveillant':
                    
                    $secondaires = $classe->getByNiveau('secondaire');
                    $users = $surveil->showOne($id);                     
                    include '../app/views/admin/edite.php';
                    break;

                case 'enseignant':
                   
                    $primaires = $classe->getByNiveau('primaire');
                    $users = $enseign->showOne($id);                     
                    include '../app/views/admin/edite.php';
                    break;

                case 'eleve':
                    $allClass = $classe->index();
                    $users = $eleve->showOne($id); 
                    $role1 = 'eleve';
                    include '../app/views/admin/edite.php';
                    break;
            }  
            break;    
        case 'archive':
            switch ($role) {
                case 'administrateur':
                    $admin->archive($id);
                    break;
                    
                case 'comptable':
                        
                    $compta->archive($id);                              
                    break;

                case 'professeur':
                    $prof->archive($id);             
                    break;

                case 'surveillant':
                        
                    $surveil->archive($id) ;         
                    break;

                case 'enseignant':
                        
                    $enseign->archive($id);          
                    break;

                case 'eleve':
                        
                    $eleve->archive($id);        
                    break;

                    default:
                        echo "erreur du role";
                        break;
                }
                break;
        case "inscription":

            if (isset($_POST["matricule"])) {
                $matricule = htmlspecialchars($_POST['matricule']);
        
                // Check if the id is set to process payment
                if (isset($_POST["id"])) {
                    $id = htmlspecialchars($_POST['id']);
                    $result = $eleve->processPayment( $id);
                    echo json_encode(['success' => $result]);
                } else {
                    // If id is not set, retrieve student data
                    $student = $eleve->getJoinMat($matricule);
                    include '../app/views/paiement/inscriptionEleve.php';
                }
            } else {
                // If matricule is not set, initialize student to NULL
                $student = NULL;
                include '../app/views/paiement/inscriptionEleve.php';
            }
            break;
        default:
            include '../app/views/connexion/connexion.php';
            break;
        
    }
        

} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
