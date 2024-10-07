<?php


class Surveillant {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        
        // Démarrer la transaction
        $this->db->beginTransaction();
        
        try {
            // Insérer dans la table administrateur
            $stmt = $this->db->prepare("INSERT INTO administrateur (nom, prenom, email, telephone, matricule, mot_de_passe, role, date_creation)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$nom, $prenom, $email, $telephone, $matricule, $hashed_password, $role]);

            // Récupérer l'ID de l'administrateur inséré
            $id_admin = $this->db->lastInsertId();

            // Insérer dans la table enseignant
            $stmt2 = $this->db->prepare("INSERT INTO surveillant (id_admin) VALUES (?)");
            $stmt2->execute([$id_admin]);

            // Valider la transaction
            $this->db->commit();
            return $id_admin; // Retourner l'ID de l'administrateur
            
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollBack();
            echo "Erreur : " . $e->getMessage();
            return false; // Indiquer un échec
        }
    }

    public function update($id_admin, $nom, $prenom, $email, $telephone, $role) {
        $stmt = $this->db->prepare("UPDATE administrateur SET nom = ?, prenom = ?, email = ?, telephone = ?, role = ? WHERE id_admin = ?");
    
        return $stmt->execute([$nom, $prenom, $email, $telephone, $role, $id_admin]);
        
    }

    
    public function delete($id_admin) {
        $stmt = $this->db->prepare("DELETE FROM administrateur WHERE id_admin = ?");
        return $stmt->execute([$id_admin]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE role = ?");
        $stmt->execute(['comptable']); // Passer un tableau ici
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id_admin) {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE id_admin = ?");
        $stmt->execute([$id_admin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}