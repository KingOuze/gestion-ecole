<?php

// EleveController
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/EleveModel.php'; 

class EleveController {
    private $model;

    public function __construct($database) {
        $this->model = new Eleve($database);
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));
            $nom_tuteur = htmlspecialchars(trim($_POST['nomTuteur']));
            $classe = htmlspecialchars(trim($_POST['classe']));
            $date_nais = htmlspecialchars(trim($_POST['dateNaissance']));
            $addresse = htmlspecialchars(trim($_POST['addresse']));
        


            $matricule = generateMatricule();

            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $date_nais, $addresse, $classe, $nom_tuteur);

            if ($transaction) {
                echo "eleve enregistré avec succès! ID: $transaction";
            } else {
                echo "Erreur lors de l'enregistrement.";
            }
        }
    }

    public function update($id_eleve) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));
            $nom_tuteur = htmlspecialchars(trim($_POST['nomTuteur']));
            $classe = htmlspecialchars(trim($_POST['classe']));
            $date_nais = htmlspecialchars(trim($_POST['dateNaissance']));
            $addresse = htmlspecialchars(trim($_POST['addresse']));

            if ($this->model->update($id, $nom, $prenom, $email, $telephone, $date_nais, $addresse, $classe, $nom_tuteur)) {
                echo "eleve mis à jour avec succès!";
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }

    public function destroy($id_eleve) {
        if ($this->model->delete($id_eleve)) {
            echo "eleve supprimé avec succès!";
        } else {
            echo "Erreur lors de la suppression.";
        }
    }

    public function showOne($id) {
        $eleve = $this->model->getById($id);
        
        if ($eleve != NULL) {
            echo "ID: {$eleve['id_eleve']}, Nom: {$eleve['nom']}, Email: {$eleve['email']}, Telephone: {$eleve['telephone']}, Matricule: {$eleve['matricule']}<br>";

        } else {
            echo "Sélection vide.";
        }
    }

    public function index() {
        $eleves = $this->model->getAll();
        
        if ($eleves != NULL) {
            foreach ($eleves as $eleve) {
                echo "ID: {$eleve['id_eleve']}, Nom: {$eleve['nom']}, Email: {$eleve['email']}, Telephone: {$eleve['telephone']}, Matricule: {$eleve['matricule']}<br>";
            }
        } else {
            echo "Sélection vide.";
        }
    }
}

/*function generateMatricule($prefix = 'ER_su-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}*/