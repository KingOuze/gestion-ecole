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
            $date_nais = htmlspecialchars(trim($_POST['dateNaissance']));
            $addresse = htmlspecialchars(trim($_POST['adresse']));
            $classe = htmlspecialchars(trim($_POST['classeId']));
         


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
            $classe = htmlspecialchars(trim($_POST['classeEleve']));
            $date_nais = htmlspecialchars(trim($_POST['dateNaissance']));
            $addresse = htmlspecialchars(trim($_POST['adresse']));

            try {
                //code...
                if($this->model->update($id_eleve, $nom, $prenom, $email, $telephone, $date_nais, $addresse, $classe, $nom_tuteur)) {
                    header("Location: /gestion-ecole/public/index.php?action=liste&role=eleve");
                    exit; 
                }
            } catch (\Throwable $th) {
                //throw $th;
                echo 'erre'. $th->getMessage();
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
            return $eleve;
        } else {
            echo "Sélection vide.";
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
        $eleves = $this->model->getAll();
        
        if ($eleves != NULL) {
            return $eleves;
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

    public function getByMat($matricule) {
        $data = $this->model->seachByMat($matricule);
        if ($data != NULL) {
            return $data;
        }
    }
}

/*function generateMatricule($prefix = 'ER_su-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}*/