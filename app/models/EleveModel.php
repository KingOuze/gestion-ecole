<?php


class Eleve {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($nom, $prenom, $email, $telephone, $matricule, $date_nais, $addresse, $classe, $nom_tuteur) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        
        // Démarrer la transaction
        $this->db->beginTransaction();
        
        try {
            // Insérer dans la table administrateur
            $stmt = $this->db->prepare("INSERT INTO eleve (matricule , nom, prenom, email, date_naissance, tuteur, telephone, adresse, date_inscription, id_classe) 
            S (?, ?, ?, ?, ?, ?, ?,?, NOW(),?)");
            $stmt->execute([$matricule, $nom, $prenom, $email, $date_nais, $addresse, $nom_tuteur, $telephone, $classe ]);


            // Valider la transaction
           
            return  $this->db->commit(); // Retourner l'ID de l'administrateur
            
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollBack();
            echo "Erreur : " . $e->getMessage();
            return false; // Indiquer un échec
        }
    }

    public function update($id, $nom, $prenom, $email, $telephone, $date_nais, $addresse, $classe, $nom_tuteur) {
        $stmt = $this->db->prepare("UPDATE eleve SET nom= ?,prenom= ?,email= ?,date_naissance= ?,tuteur= ?,telephone= ?,adresse= ?,date_inscription= ? ,id_classe= ? WHERE id_eleve = ?");
        $stmt->execute([$nom, $prenom, $email, $date_nais, $addresse, $nom_tuteur, $telephone, $classe, $id_eleve ]);
        
    }

    
    public function delete($id_eleve) {
        $stmt = $this->db->prepare("DELETE FROM eleve WHERE id_eleve = ?");
        return $stmt->execute([$id_eleve]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM eleve");
        $stmt->execute(); // Passer un tableau ici
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id_eleve) {
        $stmt = $this->db->prepare("SELECT * FROM eleve WHERE id_eleve = ?");
        $stmt->execute([$id_eleve]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}