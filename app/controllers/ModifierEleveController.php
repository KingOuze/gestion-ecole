<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/Eleve.php';

class EleveController {
    private $db;
    private $eleve;

    public function __construct($database) {
        $this->db = $database;
        $this->eleve = new Eleve($this->db);
    }

    public function totalEleves() {
        return $this->eleve->count(); // Appelle la méthode count() de la classe Eleve
    }

    // Méthode pour créer un nouvel élève
    public function createEleve($data) {
        try {
            $this->eleve->matricule = $data['matricule'];
            $this->eleve->nom = $data['nom'];
            $this->eleve->prenom = $data['prenom'];
            $this->eleve->date_naissance = $data['date_naissance'];
            $this->eleve->telephone = $data['telephone'];
            $this->eleve->adresse = $data['adresse'];
            $this->eleve->date_inscription = $data['date_inscription'];
            $this->eleve->id_classe = $data['id_classe'];

            if ($this->eleve->create()) {
                return "Élève créé avec succès.";
            } else {
                return "Échec de la création de l'élève.";
            }
        } catch (Exception $e) {
            return "Erreur lors de la création de l'élève : " . $e->getMessage();
        }
    }

    // Méthode pour lire tous les élèves
    public function readEleves() {
        try {
            $stmt = $this->eleve->read();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return "Erreur lors de la lecture des élèves : " . $e->getMessage();
        }
    }

    // Méthode pour lire un élève par ID
    public function readEleve($id) {
        try {
            $this->eleve->id_eleve = $id;
            $this->eleve->readOne();
            return [
                'id_eleve' => $this->eleve->id_eleve,
                'matricule' => $this->eleve->matricule,
                'nom' => $this->eleve->nom,
                'prenom' => $this->eleve->prenom,
                'date_naissance' => $this->eleve->date_naissance,
                'telephone' => $this->eleve->telephone,
                'adresse' => $this->eleve->adresse,
                'date_inscription' => $this->eleve->date_inscription,
                'id_classe' => $this->eleve->id_classe
            ];
        } catch (Exception $e) {
            return "Erreur lors de la lecture de l'élève : " . $e->getMessage();
        }
    }

    // Méthode pour mettre à jour un élève
    public function updateEleve($data) {
        try {
            $this->eleve->id_eleve = $data['id_eleve'];
            $this->eleve->matricule = $data['matricule'];
            $this->eleve->nom = $data['nom'];
            $this->eleve->prenom = $data['prenom'];
            $this->eleve->date_naissance = $data['date_naissance'];
            $this->eleve->telephone = $data['telephone'];
            $this->eleve->adresse = $data['adresse'];
            $this->eleve->date_inscription = $data['date_inscription'];
            $this->eleve->id_classe = $data['id_classe'];

            if ($this->eleve->update()) {
                return "Élève mis à jour avec succès.";
            } else {
                return "Échec de la mise à jour de l'élève.";
            }
        } catch (Exception $e) {
            return "Erreur lors de la mise à jour de l'élève : " . $e->getMessage();
        }
    }
    public function archiveEleve($id) {
        try {
            if ($this->eleve->archive($id)) { // Appel de la méthode avec l'ID
                header("Location: /gestion-ecole/app/views/admin/listAdmin.php?message=Administrateur archivé avec succès.");
                exit;
            } else {
                return "Échec de l'archivage de l'administrateur.";
            }
        } catch (Exception $e) {
            return "Erreur lors de l'archivage de l'administrateur : " . $e->getMessage();
        }
    }
    

    // Méthode pour supprimer un élève
    public function deleteEleve($id) {
        try {
            $this->eleve->id_eleve = $id;
            if ($this->eleve->delete()) {
                return "Élève supprimé avec succès.";
            } else {
                return "Échec de la suppression de l'élève.";
            }
        } catch (Exception $e) {
            return "Erreur lors de la suppression de l'élève : " . $e->getMessage();
        }
    }
}
