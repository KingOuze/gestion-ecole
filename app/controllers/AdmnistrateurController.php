<?php

// AdministrateurController
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/AdministrateurModel.php'; 

class AdministrateurController {
    private $model;

    public function __construct($database) {
        $this->model = new Administrateur($database);
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

            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role);

            if ($transaction) {
                echo "Administrateur enregistré avec succès! ID: $transaction";
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
                echo "Administrateur mis à jour avec succès!";
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }

    public function destroy($id_admin) {
        if ($this->model->delete($id_admin)) {
            echo "Administrateur supprimé avec succès!";
        } else {
            echo "Erreur lors de la suppression.";
        }
    }

    public function showOne($id) {
        $administrateur = $this->model->getById($id);
        
        if ($administrateur != NULL) {
            echo "ID: {$administrateur['id_admin']}, Nom: {$administrateur['nom']}, Email: {$administrateur['email']}, Telephone: {$administrateur['telephone']}, Matricule: {$administrateur['matricule']}<br>";

        } else {
            echo "Sélection vide.";
        }
    }

    public function index() {
        $administrateurs = $this->model->getAll();
        
        if ($administrateurs != NULL) {
            foreach ($administrateurs as $administrateur) {
                echo "ID: {$administrateur['id_admin']}, Nom: {$administrateur['nom']}, Email: {$administrateur['email']}, Telephone: {$administrateur['telephone']}, Matricule: {$administrateur['matricule']}<br>";
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