<?php


class Matiere {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($nom_matiere) {
        
        // Démarrer la transaction
        $this->db->beginTransaction();
        
        try {
            // Insérer dans la table administrateur
            $stmt = $this->db->prepare("INSERT INTO matiere (nom_matiere) VALUES (?)");

            return $stmt->execute([$nom_matiere]);
            
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollBack();
            echo "Erreur : " . $e->getMessage();
            return false; // Indiquer un échec
        }
    }

    public function update($id, $nom_matiere) {
        $stmt = $this->db->prepare("UPDATE matiere SET nom_matiere = ? WHERE id = ?");
        
        return $stmt->execute([$nom_matiere, $id]);
    }

    public function delete($id) {
        /*$stmt2 = $this->database->prepare("DELETE FROM administrateur WHERE id_admin = ?");
        $stmt2->bindParam(':id_admin', $id_admin);
        $stmt2->execute();*/
        $stmt = $this->db->prepare("DELETE FROM matiere WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM matiere ");
        $stmt->execute(); // Passer un tableau ici
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM matiere WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}