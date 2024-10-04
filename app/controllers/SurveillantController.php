<?php

// SurveillantController
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/SurveillantModel.php'; 

class SurveillantController {
    private $model;

    public function __construct($database) {
        $this->model = new Surveillant($database);
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

            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role);

            if ($transaction) {
                echo "Surveillant enregistré avec succès! ID: $transaction";
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
                echo "Surveillant mis à jour avec succès!";
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }

    public function destroy($id_admin) {
        if ($this->model->delete($id_admin)) {
            echo "Surveillant supprimé avec succès!";
        } else {
            echo "Erreur lors de la suppression.";
        }
    }

    public function showOne($id) {
        $surveillant = $this->model->getById($id);
        
        if ($surveillant != NULL) {
            echo "ID: {$surveillant['id_admin']}, Nom: {$surveillant['nom']}, Email: {$surveillant['email']}, Telephone: {$surveillant['telephone']}, Matricule: {$surveillant['matricule']}<br>";

        } else {
            echo "Sélection vide.";
        }
    }

    public function index() {
        $surveillants = $this->model->getAll();
        
        if ($surveillants != NULL) {
            foreach ($surveillants as $Surveillant) {
                echo "ID: {$Surveillant['id_admin']}, Nom: {$Surveillant['nom']}, Email: {$Surveillant['email']}, Telephone: {$Surveillant['telephone']}, Matricule: {$Surveillant['matricule']}<br>";
            }
        } else {
            echo "Sélection vide.";
        }
    }
}

function generateMatricule($prefix = 'ER_su-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}