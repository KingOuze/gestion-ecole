<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    private $db;
    private $admin;

    public function __construct($database) {
        $this->db = $database;
        $this->admin = new Admin($this->db);
    }

    public function totalAdmins() {
        return $this->admin->count(); // Appelle la méthode count() de la classe Admin
    }

    // Méthode pour créer un nouvel administrateur
    public function createAdmin($data) {
        try {
            $this->admin->nom = $data['nom'];
            $this->admin->prenom = $data['prenom'];
            $this->admin->email = $data['email'];
            $this->admin->telephone = $data['telephone'];
            $this->admin->matricule = $data['matricule'];
            $this->admin->mot_de_passe = $data['mot_de_passe'];
            $this->admin->role = $data['role'];
            $this->admin->archivage = 0; // Par défaut, nouvel administrateur n'est pas archivé

            if ($this->admin->create()) {
                return "Administrateur créé avec succès.";
            } else {
                return "Échec de la création de l'administrateur.";
            }
        } catch (Exception $e) {
            return "Erreur lors de la création de l'administrateur : " . $e->getMessage();
        }
    }
 // Méthode pour lire tous les administrateurs non archivés
 public function read() {
    $query = "SELECT * FROM administrateur WHERE archivage = 0";
    $stmt = $this->db->prepare($query);
    
    // Essayer d'exécuter la requête
    if (!$stmt->execute()) {
        // Retourner une chaîne d'erreur si l'exécution échoue
        return "Erreur d'exécution de la requête.";
    }
    
    // Retourner l'objet PDOStatement
    return $stmt;
}
    
    public function readAdmins() {
        try {
            // Appeler la méthode read() sur l'objet Admin
            $stmt = $this->admin->read();
            
            // Vérifiez si le résultat est un objet PDOStatement
            if ($stmt instanceof PDOStatement) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Si ce n'est pas un objet PDOStatement, c'est une erreur
                return $stmt; // Cela contiendra votre message d'erreur
            }
        } catch (Exception $e) {
            return "Erreur lors de la lecture des administrateurs : " . $e->getMessage();
        }
    }
    
    

    // Méthode pour lire tous les administrateurs archivés
    public function readArchivedAdmins() {
        try {
            $stmt = $this->admin->readArchived();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return "Erreur lors de la lecture des administrateurs archivés : " . $e->getMessage();
        }
    }

    // Méthode pour lire un administrateur par ID
    public function readAdmin($id) {
        try {
            $this->admin->id_admin = $id;
            $this->admin->readOne();
            return [
                'id_admin' => $this->admin->id_admin,
                'nom' => $this->admin->nom,
                'prenom' => $this->admin->prenom,
                'email' => $this->admin->email,
                'telephone' => $this->admin->telephone,
                'matricule' => $this->admin->matricule,
                'role' => $this->admin->role,
                'date_creation' => $this->admin->date_creation,
                'date_modification' => $this->admin->date_modification,
                'archivage' => $this->admin->archivage
            ];
        } catch (Exception $e) {
            return "Erreur lors de la lecture de l'administrateur : " . $e->getMessage();
        }
    }

    // Méthode pour mettre à jour un administrateur
    public function updateAdmin($data) {
        try {
            $this->admin->id_admin = $data['id_admin'];
            $this->admin->nom = $data['nom'];
            $this->admin->prenom = $data['prenom'];
            $this->admin->email = $data['email'];
            $this->admin->telephone = $data['telephone'];
            $this->admin->mot_de_passe = $data['mot_de_passe']; // Assurez-vous de le hash
           

            if ($this->admin->update()) {
                return "Administrateur mis à jour avec succès.";
            } else {
                return "Échec de la mise à jour de l'administrateur.";
            }
        } catch (Exception $e) {
            return "Erreur lors de la mise à jour de l'administrateur : " . $e->getMessage();
        }
    }

    //  Méthode pour archiver un administrateur
   

    public function archiveAdmin($id) {
        try {
            if ($this->admin->archive($id)) { // Appel de la méthode avec l'ID
                header("Location: /gestion-ecole/app/views/admin/listAdmin.php?message=Administrateur archivé avec succès.");
                exit;
            } else {
                return "Échec de l'archivage de l'administrateur.";
            }
        } catch (Exception $e) {
            return "Erreur lors de l'archivage de l'administrateur : " . $e->getMessage();
        }
    }
    
    

    // Méthode pour restaurer un administrateur
    public function restoreAdmin($id) {
        try {
            $this->admin->id_admin = $id;
            if ($this->admin->restore()) {
                return "Administrateur restauré avec succès.";
            } else {
                return "Échec de la restauration de l'administrateur.";
            }
        } catch (Exception $e) {
            return "Erreur lors de la restauration de l'administrateur : " . $e->getMessage();
        }
    }

    // Méthode pour supprimer un administrateur
    public function deleteAdmin($id) {
        try {
            $this->admin->id_admin = $id;
            if ($this->admin->delete()) {
                return "Administrateur supprimé avec succès.";
            } else {
                return "Échec de la suppression de l'administrateur.";
            }
        } catch (Exception $e) {
            return "Erreur lors de la suppression de l'administrateur : " . $e->getMessage();
        }
    }
}
