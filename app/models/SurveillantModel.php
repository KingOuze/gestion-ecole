<?php


class Surveillant {
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
            $stmt = $this->db->prepare("INSERT INTO administrateur (nom, prenom, email, telephone, matricule, mot_de_passe, role, adresse, date_creation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$nom, $prenom, $email, $telephone, $matricule, $hashed_password, $role, $adresse]);

            // Récupérer l'ID de l'administrateur inséré
            $id_admin = $this->db->lastInsertId();

            // Insérer dans la table enseignant
            $stmt2 = $this->db->prepare("INSERT INTO surveillant (id_admin) VALUES (?)");
            $stmt2->execute([$id_admin]);

            $id_surveillant = $this->db->lastInsertId();

            $stmtSurveillantClasse = $this->db->prepare("INSERT INTO surveillant_classe (id_Surveillant, id_classe) VALUES (?, ?)");
            if (is_array($classe)) {
                foreach ($classe as $id_classe) {
                    $stmtSurveillantClasse->execute([$id_surveillant, $id_classe]);
                }
            } else {
                # code...
                $stmtSurveillantClasse->execute([$id_surveillant, $classe]);
            }

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

    public function update($id_admin, $nom, $prenom, $email, $telephone, $adresse) {
        $stmt = $this->db->prepare("UPDATE administrateur SET nom = ?, prenom = ?, email = ?, telephone = ?, adresse = ? WHERE id = ?");
    
        return $stmt->execute([$nom, $prenom, $email, $telephone, $adresse, $id_admin]);
        
    }

    
    public function delete($id_admin) {
        $stmt = $this->db->prepare("DELETE FROM administrateur WHERE id = ?");
        return $stmt->execute([$id_admin]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE role = ? AND archive = 0");
        $stmt->execute(['surveillant']); // Passer un tableau ici
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE id = :id");
        $stmt->execute(['id' => $id]); // Passer un tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='surveillant' AND archive = 0");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['count']; // Retourne le nombre d'enseignants
    }

       //  Méthode pour archiver un administrateur
       public function archive($id_admin) {
        $stmt = $this->db->prepare("UPDATE administrateur SET archive = 1 WHERE id = :id_admin");
        $stmt->bindParam(':id_admin', $id_admin); // Lier l'ID administrateur
        return $stmt->execute(); // Retourne le résultat de l'exécution
    }

      
}