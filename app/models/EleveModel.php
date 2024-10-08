<?php


class Eleve {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function create($nom, $prenom, $email, $telephone, $matricule, $date_nais, $addresse, $classe, $nom_tuteur) {
        
        // Démarrer la transaction
        $this->db->beginTransaction();
        
        try {
           // Insérer dans la table ELEVE
           if (empty($classe)) {
            echo "Erreur : id_classe ne peut pas être vide.";
            return; // Sortir de la fonction ou de l'exécution
         }
        
            // Conversion de la classe en entier
            $id_classe = (int)$classe;
            
            // Insérer dans la table ELEVE
            $stmt = $this->db->prepare("INSERT INTO eleve (matricule, nom, prenom, email, date_naissance, tuteur, telephone, adresse, date_inscription, id_classe) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $stmt->execute([$matricule, $nom, $prenom, $email, $date_nais, $nom_tuteur, $telephone, $addresse, $id_classe]);
                            // Valider la transaction
            
                return  $this->db->commit(); // Retourner l'ID de l'administrateur
                
            } catch (Exception $e) {
                // Annuler la transaction en cas d'erreur
                $this->db->rollBack();
                echo "Erreur : " . $e->getMessage();
                return false; // Indiquer un échec
            }
    }

    public function update($id_eleve, $nom, $prenom, $email, $telephone, $date_nais, $addresse, $classe, $nom_tuteur) {
        $stmt = $this->db->prepare("UPDATE eleve SET nom= ?,prenom= ?,email= ?,date_naissance= ?,tuteur= ?,telephone= ?,adresse= ?,date_inscription= ? ,id = ? WHERE id_eleve = ?");
        $stmt->execute([$nom, $prenom, $email, $date_nais, $addresse, $nom_tuteur, $telephone, $classe, $id_eleve ]);
        
    }

    
    public function delete($id_eleve) {
        $stmt = $this->db->prepare("DELETE FROM eleve WHERE id = ?");
        return $stmt->execute([$id_eleve]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM eleve WHERE archive = 0");
        $stmt->execute(); // Passer un tableau ici
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE id = :id");
        $stmt->execute(['id' => $id]); // Passer un tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM eleve WHERE archive = 0");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['count']; // Retourne le nombre d'enseignants
    }

    public function archive($id_admin) {
        $stmt = $this->db->prepare("UPDATE eleve SET archive = 1 WHERE id = :id_admin");
        $stmt->bindParam(':id_admin', $id_admin); // Lier l'ID administrateur
        return $stmt->execute(); // Retourne le résultat de l'exécution
    }
}