<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/MatiereModel.php'; 

class MatiereController {
    private $model;

    public function __construct($database) {
        $this->model = new Matiere($database);
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom_matiere = htmlspecialchars(trim($_POST['matiere']));

            $transaction = $this->model->create($niveau, $nom_matiere);

            if ($transaction) {
                echo "Matiere enregistré avec succès! ID: $transaction";
            } else {
                echo "Erreur lors de l'enregistrement.";
            }
        }
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom_matiere = htmlspecialchars(trim($_POST['matiere']));
            $niveau = htmlspecialchars(trim($_POST['niveau']));

            if ($this->model->update($id, $niveau, $nom_matiere)) {
                echo "matiere mis à jour avec succès!";
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }

    public function destroy($id) {
        if ($this->model->delete($id)) {
            echo "matiere supprimé avec succès!";
        } else {
            echo "Erreur lors de la suppression.";
        }
    }

    public function showOne($id) {
        $matiere = $this->model->getById($id);
        
        if ($matiere != NULL) {
            echo "ID: {$matiere['id_matiere']}, nom_matiere: {$matiere['nom_matiere']}<br>";

        } else {
            echo "Sélection vide.";
        }
    }

    public function index() {
        $matieres = $this->model->getAll();
        
        if ($matieres != NULL) {
            return $matieres;
        } else {
            return "Sélection vide.";
        }
    }
}