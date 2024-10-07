<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/ClasseModel.php'; 

class ClasseController {
    private $model;

    public function __construct($database) {
        $this->model = new Classe($database);
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom_classe = htmlspecialchars(trim($_POST['classe']));
            $niveau = htmlspecialchars(trim($_POST['niveau']));

            $transaction = $this->model->create($niveau, $nom_classe);

            if ($transaction) {
                echo "Classe enregistré avec succès! ID: $transaction";
            } else {
                echo "Erreur lors de l'enregistrement.";
            }
        }
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom_classe = htmlspecialchars(trim($_POST['classe']));
            $niveau = htmlspecialchars(trim($_POST['niveau']));

            if ($this->model->update($id, $niveau, $nom_classe)) {
                echo "Classe mis à jour avec succès!";
            } else {
                echo "Erreur lors de la mise à jour.";
            }
        }
    }

    public function destroy($id) {
        if ($this->model->delete($id)) {
            echo "Classe supprimé avec succès!";
        } else {
            echo "Erreur lors de la suppression.";
        }
    }

    public function showOne($id) {
        $Classe = $this->model->getById($id);
        
        if ($Classe != NULL) {
            echo "ID: {$Classe['id_classe']}, nom_classe: {$Classe['nom_classe']}<br>";

        } else {
            echo "Sélection vide.";
        }
    }

    public function index() {
        $Classes = $this->model->getAll();
        
        if ($Classes != NULL) {
            foreach ($Classes as $classe) {
                echo "ID: {$classe['id_classe']}, nom_classe: {$classe['nom_classe']}<br>";
            }
        } else {
            echo "Sélection vide.";
        }
    }
}