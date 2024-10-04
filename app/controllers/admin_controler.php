<?php

require_once '../models/admin_model.php'; // Inclure le modèle

class AdminController {
    private $model;

    public function __construct() {
        $this->model = new AdminModel(); // Instanciation du modèle
    }

    // Gérer l'inscription d'un administrateur
    public function registerAdmin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $role = $_POST['role'];

            // Validation simple
            if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($mot_de_passe) || empty($role)) {
                echo "Tous les champs sont requis.";
                return;
            }

            // Appel du modèle pour créer l'administrateur
            if ($this->model->createAdmin($nom, $prenom, $email, $telephone, $mot_de_passe, $role)) {
                echo "Administrateur inscrit avec succès.";
            } else {
                echo "Erreur lors de l'inscription.";
            }
        }
    }
}