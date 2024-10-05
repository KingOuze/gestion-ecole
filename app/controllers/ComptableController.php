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

            $matricule = generateMatricule();
            // Appel à la méthode create du modèle
            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role);

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
            $role = htmlspecialchars(trim($_POST['role']));

            if ($this->model->update($id_admin, $nom, $prenom, $email, $telephone, $role)) {
                echo "Coptable mis à jour avec succès!";
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
            echo "ID: {$comptable['id_admin']}, Nom: {$comptable['nom']}, Email: {$comptable['email']}, Telephone: {$comptable['telephone']}, Matricule: {$comptable['matricule']}<br>";
        } else {
            echo "Comptable non trouvé.";
        }
    }

    public function index() {
        $comptables = $this->model->getAll();
        if ($comptables != NULL) {
            foreach ($comptables as $comptable) { // Correction ici
                echo "ID: {$comptable['id_admin']}, Nom: {$comptable['nom']}, Email: {$comptable['email']}, Telephone: {$comptable['telephone']}, Matricule: {$comptable['matricule']}<br>";
            }
        } else {
            echo "Aucun Comptable trouvé.";
        }
    }
}

/*function generateMatricule($prefix = 'ER_cm-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}*/