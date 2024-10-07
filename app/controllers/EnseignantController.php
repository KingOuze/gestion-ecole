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
            $mot_de_passe = htmlspecialchars(trim($_POST['mot_de_passe']));
            $role = htmlspecialchars(trim($_POST['role']));
            $classe = htmlspecialchars(trim($_POST['classe']));


            $matricule = generateMatricule();

            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role, $classe);

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
            $role = htmlspecialchars(trim($_POST['role']));
            $classe = htmlspecialchars(trim($_POST['classe']));

            if ($this->model->update($id_admin, $nom, $prenom, $email, $telephone, $role, $classe)) {
                echo "Enseignant mis à jour avec succès!";
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }

    public function destroy($id_admin) {
        if ($this->model->delete($id_admin)) {
            echo "Enseignant supprimé avec succès!";
        } else {
            echo "Erreur lors de la suppression.";
        }
    }

    public function showOne($id) {
        $enseignant = $this->model->getById($id);
        
        if ($enseignant != NULL) {
            echo "Sélection vide.";
        }
    }

    public function index() {
        $enseignants = $this->model->getAll();
        
        if ($enseignants != NULL) {
            foreach ($enseignants as $enseign) {
                echo "ID: {$enseign['id_admin']}, Nom: {$enseign['nom']}, Email: {$enseign['email']}, Telephone: {$enseign['telephone']}, Matricule: {$enseign['matricule']}<br>";
            }
        } else {
            echo "Sélection vide.";
        }
    }
}
/*
function generateMatricule($prefix = 'ER_en-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}*/