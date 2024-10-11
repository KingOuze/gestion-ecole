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
    }public function update($id_admin) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération et nettoyage des données d'entrée
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
                
        // Vérification de l'email et du téléphone
        if ($this->model->checkEmailExists($email, $id_admin)) {
            echo "L'email existe déjà.";
            return; // Sortir si l'email existe
        }
        
        if ($this->model->checkPhoneExists($telephone, $id_admin)) {
            echo "Le numéro de téléphone existe déjà.";
            return; // Sortir si le téléphone existe
        }
    
            // Vérification de l'ancien mot de passe
            if (!empty($_POST['ancienMotDePasse'])) {
                $ancienMotDePasse = htmlspecialchars(trim($_POST['ancienMotDePasse']));
                
                // Vérifiez si l'ancien mot de passe est correct (sans hachage)
                if ($this->model->verifyPassword($id_admin, $ancienMotDePasse)) {
                    // Mise à jour du mot de passe
                    if (!empty($_POST['nouveauMotDePasse']) && $_POST['nouveauMotDePasse'] === $_POST['confirmerMotDePasse']) {
                        // Hachage du nouveau mot de passe avant de l'enregistrer
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
                    echo " mot de passe incorrect.";                                                              
                    return; // Sortir si l'ancien mot de passe est incorrect
                }
            }
    
            // Mise à jour des autres informations
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
        // Vérifiez que c'est une requête POST pour les requêtes AJAX
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model->archive($id)) { // Appel de la méthode avec l'ID
                // Réponse pour une requête AJAX réussie
                http_response_code(200); // Code de réponse OK
                echo json_encode(['status' => 'success']); // Réponse JSON pour indiquer le succès
            } else {
                // Réponse pour une requête AJAX échouée
                http_response_code(500); // Code d'erreur interne du serveur
                echo json_encode(['status' => 'error', 'message' => 'Échec de l\'archivage.']); // Réponse JSON pour indiquer une erreur
            }
        } else {
            // Si ce n'est pas une requête POST, redirigez normalement
            if ($this->model->archive($id)) {
                header("Location: /gestion-ecole/public/index.php?action=liste&role=administrateur");
                exit;
            } else {
                header("Location: /gestion-ecole/public/index.php?action=erreur");
                exit;
            }
        }
    }
          
}


function generateMatricule($prefix = 'ER_su-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}