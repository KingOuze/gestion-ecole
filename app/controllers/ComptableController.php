<?php

// ComptableController
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/ComptableModel.php'; 

class ComptableController {
    private $model;

    public function __construct($database) {
        $this->model = new Comptable($database);
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

            $matricule = generateMatricule();
            // Appel à la méthode create du modèle
            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role, $adresse);

            if ($transaction) {
                echo "Comptable enregistré avec succès! ID: $transaction";
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

            if ($this->model->update($id_admin, $nom, $prenom, $email, $telephone, $adresse)) {
                header("Location: /gestion-ecole/public/index.php?action=liste&role=comptable");
                exit; 
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }

    public function destroy($id_admin) {

        // Supprimer l'administrateur
        if ($this->model->delete($id_admin)) {
            echo "Comptable et données associées supprimés avec succès!";
        } else {
            echo "Aucun Comptable trouvé avec cet ID.";
        }
    }

    public function showOne($id) {
        $comptable = $this->model->getById($id);
        
        if ($comptable != NULL) {
            return $comptable;
        } else {
            echo "Comptable non trouvé.";
        }
    }

    public function archive($id) {
        if ($this->model->archive($id)) { // Appel de la méthode avec l'ID
            // Redirection correcte avec "Location:"
            header("Location: /gestion-ecole/public/index.php?action=liste&role=comptable");
            exit; // Assurez-vous d'appeler exit après la redirection
        } else {
            // Gérer le cas où l'archivage a échoué
            // Par exemple, redirection vers une page d'erreur ou affichage d'un message
            header("Location: /gestion-ecole/public/index.php?action=erreur");
            exit;
        }
    }

    public function index() {
        $comptables = $this->model->getAll();
        if ($comptables != NULL) {
            return $comptables;
        } else {
            echo "Aucun Comptable trouvé.";
        }
    }

    public function count() {
        // Récupérer les statistiques du modèle
        $data = $this->model->getCount();
        // Inclure la vue du tableau de bord
        return $data;
    }
}

/*function generateMatricule($prefix = 'ER_cm-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}*/