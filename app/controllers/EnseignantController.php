<?php

// EnseignantController
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/EnseignantModel.php'; 

class EnseignantController {
    private $model;

    public function __construct($database) {
        $this->model = new Enseignant($database);
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
            $classe = htmlspecialchars(trim($_POST['classe']));


            $matricule = generateMatricule();

            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role, $adresse, $classe);

            if ($transaction) {
                echo "Enseignant enregistré avec succès! ID: $transaction";
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
            $classe = htmlspecialchars(trim($_POST['classe']));

            if ($this->model->update($id_admin, $nom, $prenom, $email, $telephone,  $adresse,  $classe)) {
                header("Location: /gestion-ecole/public/index.php?action=liste&role=enseignant");
                exit; 
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }

    }

    public function showOne($id) {
        $enseignant = $this->model->getById($id);
        
        if ($enseignant != NULL) {
            return $enseignant;
        } else {
            echo "enseignant non trouvé.";
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
        $enseignants = $this->model->getAll();
        
        if ($enseignants != NULL) {
            return $enseignants;
        } else {
            echo "Sélection vide.";
        }
    }

    public function count() {
        // Récupérer les statistiques du modèle
        $data = $this->model->getCount();
        // Inclure la vue du tableau de bord
        return $data;
    }
}
/*
function generateMatricule($prefix = 'ER_en-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}*/