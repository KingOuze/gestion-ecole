<?php


class Classe {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($niveau, $nom_classe) {
        
        // Démarrer la transaction
        $this->db->beginTransaction();
        
        try {
            // Insérer dans la table administrateur
            $stmt = $this->db->prepare("INSERT INTO classe (niveau, nom_classe) VALUES (?, ?)");

            return $stmt->execute([$niveau, $nom_classe]);
            
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollBack();
            echo "Erreur : " . $e->getMessage();
            return false; // Indiquer un échec
        }
    }

    public function update($id, $niveau, $nom_classe) {
        $stmt = $this->db->prepare("UPDATE classe SET niveau = ?, nom_classe = ? WHERE id_classe = ?");
        
        return $stmt->execute([$niveau, $nom_classe, $id]);
    }

    public function delete($id) {
        /*$stmt2 = $this->database->prepare("DELETE FROM administrateur WHERE id_admin = ?");
        $stmt2->bindParam(':id_admin', $id_admin);
        $stmt2->execute();*/
        $stmt = $this->db->prepare("DELETE FROM classe WHERE id_classe = ?");
        return $stmt->execute([$id]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM classe ");
        $stmt->execute(); // Passer un tableau ici
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM classe WHERE id_classe = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}