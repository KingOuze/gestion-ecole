<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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
            $stmt = $this->db->prepare("INSERT INTO eleve (matricule, nom, prenom, email, date_naissance, tuteur, telephone, adresse, date_inscription, id_classe, archive) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)");
            $archive = 0;
            $stmt->execute([$matricule, $nom, $prenom, $email, $date_nais, $nom_tuteur, $telephone, $addresse, $id_classe,$archive]);
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
        $stmt = $this->db->prepare("UPDATE eleve SET nom= ?,prenom= ?,email= ?,date_naissance= ?,tuteur= ?,telephone= ?, adresse= ?, id_classe = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $date_nais, $nom_tuteur, $telephone,  $addresse, $classe, $id_eleve ]);
        return true;
        
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
        $stmt = $this->db->prepare("SELECT eleve. *, classe.nom_classe AS nom_classe 
            FROM eleve 
            INNER JOIN classe ON eleve.id_classe = classe.id 
            WHERE eleve.id = :id
        ");
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

   /* public function seachByMat($matricule) {
        $stmt = $this->db->prepare('SELECT * FROM eleve WHERE matricule = :matricule');
        $stmt->bindParam(':matricule', $matricule);
        return $stmt->execute();
    }*/

    public function getJoinMat($matricule) {
        try {
            //code...
            $stmt = $this->db->prepare("SELECT eleve.*, 
                classe.nom_classe AS nom_classe, 
                classe.niveau AS niveau_classe,
                paiement_eleve.annee AS annee,
                paiement.id AS id,
                paiement.status AS status,
                paiement_eleve.frais_inscription AS montant_tarif FROM eleve 
                INNER JOIN classe ON eleve.id_classe = classe.id 
                INNER JOIN paiement_eleve ON classe.id = paiement_eleve.id_classe 
                INNER JOIN paiement ON paiement.id_eleve = eleve.id
                WHERE eleve.matricule = :matricule");

            $stmt->execute(['matricule' => $matricule]);
            $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
            return $eleve;

        } catch (\Throwable $th) {
            return 'Erreur'.$th;
        }
        
    }

    function processPayment($id) {
       
        $stmt = $this->db->prepare("UPDATE paiement SET status = 1 WHERE id = :id");
        $stmt->bindParam(':id' ,$id);
        
        if ($stmt->execute()) {
            $rowsAffected = $stmt->rowCount(); // Nombre de lignes affectées
            if ($rowsAffected > 0) {
                return true; // Mise à jour réussie
            } else {
                echo "Aucune ligne mise à jour. Vérifiez le matricule.";
                return false; // Aucune ligne mise à jour
            }
        } else {
            return false; // Échec de la mise à jour
        }
        
    
        /* $sql = "UPDATE paiement
                SET id = :id
                WHERE id IN (
                    SELECT e.id
                    FROM eleve e
                    WHERE e.matricule = :matricule
                )";

        $stmt = $this->db->prepare($sql);
        
        // Liez les paramètres
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':matricule', $matricule);

        if ($stmt->execute()) {
            return true; // Paiement enregistré avec succès
        } else {
            return false; // Échec de l'enregistrement
        }*/
    } 


}