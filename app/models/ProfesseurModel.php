<?php

class Professeur {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($nom, $prenom, $email, $telephone, $matricule, $mot_de_passe, $role, $classe, $matiere) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        
        // Démarrer la transaction
        $this->db->beginTransaction();
        
        try {
            // Insérer dans la table administrateur
            $stmt = $this->db->prepare("INSERT INTO administrateur (nom, prenom, email, telephone, matricule, mot_de_passe, role, date_creation)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$nom, $prenom, $email, $telephone, $matricule, $hashed_password, $role]);

            // Récupérer l'ID de l'admin inséré
            $id_admin = $this->db->lastInsertId();

            // Insérer dans la table professeur
            $stmtProfesseur = $this->db->prepare("INSERT INTO professeur (id_admin) VALUES (?)");
            $stmtProfesseur->execute([$id_admin]);

            // Récupérer l'ID du professeur inséré
            $id_professeur = $this->db->lastInsertId();

            // Insérer les associations dans la table professeur_classe
            $stmtProfesseurClasse = $this->db->prepare("INSERT INTO professeur_classe (id_professeur, id_classe) VALUES (?, ?)");
            if (is_array($classe)) {
                foreach ($classe as $id_classe) {
                    $stmtProfesseurClasse->execute([$id_professeur, $id_classe]);
                }
            } else {
                # code...
                $stmtProfesseurClasse->execute([$id_professeur, $classe]);
            }
            // Insérer les associations dans la table professeur_matiere
            $stmtProfesseurMatiere = $this->db->prepare("INSERT INTO professeur_matiere (id_professeur, id_matiere) VALUES (?, ?)");

            if (is_array($matiere)){
                foreach ($matiere as $id_matiere) {
                    $stmtProfesseurMatiere->execute([$id_professeur, $id_matiere]);
                }
            } else {
                # code...
                $stmtProfesseurMatiere->execute([$id_professeur, $matiere]);
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

    public function update($id_admin, $nom, $prenom, $email, $telephone, $role, $classe, $matiere ) {
        $stmt = $this->db->prepare("UPDATE administrateur SET nom = ?, prenom = ?, email = ?, telephone = ?, role = ? WHERE id_admin = ?");
        $stmt->execute([$nom, $prenom, $email, $telephone, $role, $id_admin]);

        $stmt1 = $this->db->prepare("UPDATE professeur_classe SET id_classe = ? WHERE id_professeur = (SELECT id_professeur FROM professeur WHERE id_admin = ?)");
        if (is_array($classe)) {
            foreach ($classe as $id_classe) {
                $stmt1->execute([$classe, $id_admin]);
            }
        } else {
            $stmt1->execute([$classe, $id_admin]);
        }

        $stmt2 = $this->db->prepare("UPDATE professeur_matiere SET id_matiere = ? WHERE id_professeur = (SELECT id_professeur FROM professeur WHERE id_admin = ?)");
        if (is_array($matiere)){
            return $stmt2->execute([$matiere, $id_admin]);
        }else {
            $stmt2->execute([$matiere, $id_admin]);
        }

        return true; // Indiquer un succès
    }

    public function deleteAssociations($id_professeur) {
        // Supprimer les associations dans professeur_classe
        $stmt1 = $this->db->prepare("DELETE FROM professeur_classe WHERE id_professeur = ?");
        $stmt1->execute([$id_professeur]);
    
        // Supprimer les associations dans professeur_matiere
        $stmt2 = $this->db->prepare("DELETE FROM professeur_matiere WHERE id_professeur = ?");
        $stmt2->execute([$id_professeur]);
    }
    
    public function deleteProfesseur($id_professeur) {
        // Supprimer le professeur
        $stmt = $this->db->prepare("DELETE FROM professeur WHERE id_professeur = ?");
        return $stmt->execute([$id_professeur]);
    }

    public function delete($id_admin) {
        $stmt = $this->db->prepare("DELETE FROM administrateur WHERE id_admin = ?");
        return $stmt->execute([$id_admin]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE role = ?");
        $stmt->execute(['professeur']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id_admin) {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE id_admin = ?");
        $stmt->execute([$id_admin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByIdProf($id_admin){
        $stmt = $this->db->prepare("SELECT * FROM professeur WHERE id_admin = ?");
        $stmt->execute([$id_admin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}