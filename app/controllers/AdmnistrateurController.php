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
            $adresse = htmlspecialchars(trim($_POST['adresse']));


            $matricule = generateMatricule();

            $transaction = $this->model->create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role, $adresse);

            if ($transaction) {
                header("Location: /gestion-ecole/public/index.php?action=liste&role=administrateur");
                exit;
            } else {
                echo "Erreur lors de l'enregistrement.";
            }
        }
    }
    public function update($id_admin) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération et nettoyage des données d'entrée
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            
            // Vérification de l'ancien mot de passe
            if (!empty($_POST['ancienMotDePasse'])) {
                $ancienMotDePasse = htmlspecialchars(trim($_POST['ancienMotDePasse']));
                // Vérifiez si l'ancien mot de passe est correct
                if ($this->model->verifyPassword($id_admin, $ancienMotDePasse)) {
                    // Mise à jour du mot de passe
                    if (!empty($_POST['nouveauMotDePasse']) && $_POST['nouveauMotDePasse'] === $_POST['confirmerMotDePasse']) {
                        // Mise à jour dans la base de données
                        if ($this->model->updatePassword($id_admin, htmlspecialchars(trim($_POST['nouveauMotDePasse'])))) {
                            echo "Mot de passe mis à jour avec succès.";
                        } else {
                            echo "Erreur lors de la mise à jour du mot de passe.";
                        }
                    } else {
                        echo "Les nouveaux mots de passe ne correspondent pas.";
                        return; // Sortir si les mots de passe ne correspondent pas
                    }
                } else {
                    echo "Ancien mot de passe incorrect.";
                    return; // Sortir si l'ancien mot de passe est incorrect
                }
            }
    
            // Mise à jour des autres informations (uniquement si le mot de passe a été mis à jour ou si l'utilisateur ne souhaite pas changer le mot de passe)
            if ($this->model->update($id_admin, $nom, $prenom, $email, $telephone, $adresse)) {
                header("Location: /gestion-ecole/public/index.php?action=liste&role=administrateur");
                exit; 
            } else {
                echo "Erreur lors de la mise à jour des informations.";
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
        $administrateurs = $this->model->getById($id);
        if ($administrateurs != NULL) {
            return $administrateurs;
        } else {
            echo "Sélection vide.";
        }
    }

    public function index() {
        $administrateurs = $this->model->getAll();
        
        if ($administrateurs != NULL) {
            return $administrateurs;
        } else {
           return NULL;
        }
    }

    public function count() {
        // Récupérer les statistiques du modèle
        $data = $this->model->getCount();
        // Inclure la vue du tableau de bord
        return $data;
    }

    public function archive($id) {
        if ($this->model->archive($id)) { // Appel de la méthode avec l'ID
            // Redirection correcte avec "Location:"
            header("Location: /gestion-ecole/public/index.php?action=liste&role=administrateur");
            exit; // Assurez-vous d'appeler exit après la redirection
        } else {
            // Gérer le cas où l'archivage a échoué
            // Par exemple, redirection vers une page d'erreur ou affichage d'un message
            header("Location: /gestion-ecole/public/index.php?action=erreur");
            exit;
        }
    }


      
}


function generateMatricule($prefix = 'ER_su-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}