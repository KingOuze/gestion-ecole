<?php


class Administrateur {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role, $adresse) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        
        // Démarrer la transaction
        $this->db->beginTransaction();
        
        try {
            // Insérer dans la table administrateur
            $stmt = $this->db->prepare("INSERT INTO administrateur (nom, prenom, email, telephone, matricule, mot_de_passe, role, adresse, date_creation, archive)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $archive = 0;
            $stmt->execute([$nom, $prenom, $email, $telephone, $matricule, $hashed_password, $role, $adresse, $archive]);

            
            return $this->db->commit(); // Retourner l'ID de l'administrateur
            
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollBack();
            echo "Erreur : " . $e->getMessage();
            return false; // Indiquer un échec
        }
    }

    public function update($id_admin, $nom, $prenom, $email, $telephone,$adresse) {
        $stmt = $this->db->prepare("UPDATE administrateur SET nom = ?, prenom = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?");
    
        return $stmt->execute([$nom, $prenom, $email, $telephone, $adresse, $id_admin]);
        
    }

    
    public function delete($id_admin) {
        $stmt = $this->db->prepare("DELETE FROM administrateur WHERE id = ?");
        return $stmt->execute([$id_admin]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE role = ? AND archive = 0");
        $stmt->execute(['administrateur']); // Passer un tableau ici
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE id = :id");
        $stmt->execute(['id' => $id]); // Passer un tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getCount() {
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='administrateur' AND archive = 0");
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data['count']; // Retourne le nombre d'enseignants
        }

       // Méthode pour archiver un administrateur
    public function archive($id_admin) {
        $stmt = $this->db->prepare("UPDATE administrateur SET archive = 1 WHERE id = :id_admin");
        $stmt->bindParam(':id_admin', $id_admin); // Lier l'ID administrateur
        return $stmt->execute(); // Retourne le résultat de l'exécution
    }
}