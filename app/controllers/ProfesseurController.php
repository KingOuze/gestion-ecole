<?php

// ProfesseurController
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/ProfesseurModel.php'; 

class ProfesseurController {
    private $model;

    public function __construct($database) {
        $this->model = new Professeur($database);
    }

    
    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telephone = htmlspecialchars(trim($_POST['telephone'])); 
            $mot_de_passe = htmlspecialchars(trim($_POST['motDePasse']));
            $role = htmlspecialchars(trim($_POST['role']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $classe = isset($_POST['classesProfesseur[]']) ? $_POST['classesProfesseur[]'] : []; // Correction ici
            $matiere = isset($_POST['matieres[]']) ? $_POST['matieres[]'] : []; // Correction ici

            $matricule = generateMatricule();
            // Appel à la méthode create du modèle
            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role, $adresse, $classe, $matiere);

            if ($transaction) {
                header("Location: /gestion-ecole/public/index.php?action=liste&role=professeur");
                exit;
            } else {
                echo "Erreur lors de l'enregistrement.";
            }
        }
    }

    public function update($id_admin) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $classe = isset($_POST['classe']) ? $_POST['classe'] : null; // Correction ici
            $matiere = isset($_POST['matiere']) ? $_POST['matiere'] : null; // Correction ici

            if ($this->model->update($id_admin, $nom, $prenom, $email, $telephone,$adresse, $classe, $matiere)) {
                header("Location: /gestion-ecole/public/index.php?action=liste&role=professeur");
                exit;
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }

    public function destroy($id_admin) {
        // Récupérer l'ID du professeur associé à l'administrateur
        $professeur = $this->model->getByIdProf($id_admin);
        
        if ($professeur) {
            $id_professeur = $professeur['id_professeur']; // Assurez-vous que cette colonne existe dans votre table `professeur`
    
            // Supprimer les associations dans professeur_classe et professeur_matiere
            $this->model->deleteAssociations($id_professeur);
    
            // Supprimer le professeur
            $this->model->deleteProfesseur($id_professeur);
            
            // Supprimer l'administrateur
            if ($this->model->delete($id_admin)) {
                echo "Professeur et données associées supprimés avec succès!";
            } else {
                echo "Erreur lors de la suppression du Professeur.";
            }
        } else {
            echo "Aucun Professeur trouvé avec cet ID.";
        }
    }

    public function showOne($id) {
        $professeur = $this->model->getById($id);
        
        if ($professeur != NULL) {
            return $professeur;
        } else {
            echo "Professeur non trouvé.";
        }
    }

    public function archive($id) {
        if ($this->model->archive($id)) { // Appel de la méthode avec l'ID
            http_response_code(200); // Code de réponse OK
            echo json_encode(['status' => 'success']); // Réponse JSON pour indiquer le succès
        } else {
            http_response_code(500); // Code d'erreur interne du serveur
            echo json_encode(['status' => 'error', 'message' => 'Échec de l\'archivage.']); // Réponse JSON pour indiquer une erreur
        }
    }

    public function index() {
        $professeurs = $this->model->getAll();
        
        if ($professeurs != NULL) {
            return $professeurs;
        } else {
            echo "Aucun professeur trouvé.";
        }
    }

    public function count() {
        // Récupérer les statistiques du modèle
        $data = $this->model->getCount();
        // Inclure la vue du tableau de bord
        return $data;
    }
}

/*function generateMatricule($prefix = 'ER_pr-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}*/