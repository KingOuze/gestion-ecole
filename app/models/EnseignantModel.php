<?php


class Enseignant {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role, $adresse, $classe) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        
        // Démarrer la transaction
        $this->db->beginTransaction();
        
        try {
            // Insérer dans la table administrateur
            $stmt = $this->db->prepare("INSERT INTO administrateur (nom, prenom, email, telephone, matricule, mot_de_passe, role, date_creation, archive)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $archive = 0;
            $stmt->execute([$nom, $prenom, $email, $telephone, $matricule, $hashed_password, $role, $adresse, $archive]);

            // Récupérer l'ID de l'administrateur inséré
            $id_admin = $this->db->lastInsertId();

            // Insérer dans la table enseignant
            $stmt2 = $this->db->prepare("INSERT INTO enseignant (id_admin, id_classe) VALUES (?, ?)");
            $stmt2->execute([$id_admin, $classe]);

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

    public function update($id_admin, $nom, $prenom, $email, $telephone, $adresse, $classe) {
        $stmt = $this->db->prepare("UPDATE administrateur SET nom = ?, prenom = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $telephone, $adresse, $id_admin]);

        $stmt2 = $this->db->prepare("UPDATE enseignant SET id_classe = ? WHERE id = ?");
        
        return $stmt2->execute([$classe, $id_admin]);
    }

    
    public function delete($id_admin) {
        $stmt = $this->db->prepare("DELETE FROM administrateur WHERE id = ?");
        return $stmt->execute([$id_admin]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE role = ? AND archive = 0");
        $stmt->execute(['enseignant']); // Passer un tableau ici
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id_admin) {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE id = ?");
        $stmt->execute([$id_admin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='enseignant' AND archive = 0");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['count']; // Retourne le nombre d'enseignants
    }

    public function archive($id_admin) {
        $stmt = $this->db->prepare("UPDATE administrateur SET archive = 1 WHERE id = :id_admin");
        $stmt->bindParam(':id_admin', $id_admin); // Lier l'ID administrateur
        return $stmt->execute(); // Retourne le résultat de l'exécution
    }
}