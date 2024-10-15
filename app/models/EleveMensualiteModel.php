<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class EleveModel {
    private $conn;

    public function __construct($host, $db, $user, $pass) {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getEleveByMatricule($matricule) {
        $stmt = $this->conn->prepare("
            SELECT e.id, e.matricule, e.nom, e.prenom, c.nom_classe AS classe, pe.mensualite 
            FROM eleve e
            LEFT JOIN paiement_eleve pe ON e.id = pe.id_eleve
            LEFT JOIN classe c ON pe.id_classe = c.id
            WHERE e.matricule = :matricule
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPaiementsByEleveId($id_eleve) {
        $stmt = $this->conn->prepare("
            SELECT mois, etat 
            FROM Suivi_paiements 
            WHERE id_eleve = :id_eleve AND etat = 1
            GROUP BY mois
        ");
        $stmt->bindParam(':id_eleve', $id_eleve);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePayment($matricule, $month, $state) {
        try {
            // Étape 1 : Récupérer l'ID de l'élève
            $stmt = $this->conn->prepare("SELECT id FROM eleve WHERE matricule = :matricule");
            $stmt->bindParam(':matricule', $matricule);
            $stmt->execute();
        
            $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$eleve) {
                echo "L'élève avec le matricule $matricule n'existe pas.";
                return;
            }
        
            $id_eleve = $eleve['id'];
    
            // Étape 2 : Récupérer le dernier numéro de reçu pour le mois en cours
            $stmt = $this->conn->prepare("SELECT MAX(numero_recu) AS dernier_recu FROM Suivi_paiements WHERE id_eleve = :id_eleve AND mois = :mois");
            $stmt->bindParam(':id_eleve', $id_eleve);
            $stmt->bindParam(':mois', $month);
            $stmt->execute();
            // $dernier_recu = $stmt->fetchColumn();
            
            // Incrémenter le numéro de reçu
            // $nouveau_recu = $dernier_recu ? $dernier_recu + 1 : 1;
    
            // Étape 3 : Vérifier si le paiement pour le mois existe déjà
            $stmt = $this->conn->prepare("SELECT * FROM Suivi_paiements WHERE id_eleve = :id_eleve AND mois = :mois");
            $stmt->bindParam(':id_eleve', $id_eleve);
            $stmt->bindParam(':mois', $month);
            $stmt->execute();
        
            $existing_payment = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Étape 4 : Insérer ou mettre à jour le paiement
            if ($existing_payment) {
                // Si le paiement existe déjà, mettre à jour son état
                $stmt = $this->conn->prepare("UPDATE Suivi_paiements SET etat = :etat WHERE id_eleve = :id_eleve AND mois = :mois");
            } else {
                // Sinon, insérer un nouveau paiement
                $stmt = $this->conn->prepare("INSERT INTO Suivi_paiements (id_eleve, mois, etat) VALUES (:id_eleve, :mois, :etat)");
            }
        
            // Liez les paramètres
            $stmt->bindParam(':id_eleve', $id_eleve);
            $stmt->bindParam(':mois', $month);
            $stmt->bindParam(':etat', $state);
            // if (!empty($nouveau_recu)) {
            //     $stmt->bindParam(':numero_recu', $nouveau_recu);
            // }
    
            // Exécutez la requête
            if ($stmt->execute()) {
                echo "Paiement ajouté avec succès.";
            } else {
                echo "Erreur lors de l'insertion : " . implode(" ", $stmt->errorInfo());
            }
        
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
    

    public function closeConnection() {
        $this->conn = null;
    }
}