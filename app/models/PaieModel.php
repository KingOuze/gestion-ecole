<?php
class Paie {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function obtenirPaiements($search, $mois) {
        $sql = "SELECT a.prenom, a.nom, a.matricule, s.taux_horaire, 
                       SUM(s.heures_travaillees) AS heures_travaillees, 
                       SUM(s.total_salaire) AS total_salaire, s.mois, s.paiement_effectue
                FROM administrateur a
                JOIN salaire s ON a.id = s.id_admin
                WHERE 1=1"; 
    
        // Ajout des conditions de recherche
        if (!empty($search)) {
            $sql .= " AND a.matricule = :search";
        }
        if (!empty($mois)) {
            $sql .= " AND s.mois = :mois";
        }
    
        $sql .= " GROUP BY a.id, s.mois";  
    
        // Debugging: vérifier les valeurs des variables
        error_log("Requête SQL: " . $sql);
        error_log("Paramètre 'search': " . $search);
        error_log("Paramètre 'mois': " . $mois);
    
        $stmt = $this->db->prepare($sql);
    
        // Liaison des paramètres
        if (!empty($search)) {
            $stmt->bindParam(':search', $search);
        }
        if (!empty($mois)) {
            $stmt->bindParam(':mois', $mois);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Vérifier si un professeur a déjà été payé pour un mois donné
    public function verifierPaiement($id_admin, $mois) {
        $sql = "SELECT paiement_effectue FROM salaire WHERE id_admin = :id_admin AND mois = :mois";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_admin', $id_admin);
        $stmt->bindParam(':mois', $mois);
        $stmt->execute();
        
        return $stmt->fetchColumn() == 1; // Retourne vrai si déjà payé
    }

    // Mettre à jour le statut de paiement d'un professeur
    public function payerProfesseur($id_admin, $mois) {
        $sql = "UPDATE salaire SET paiement_effectue = 1 WHERE id_admin = :id_admin AND mois = :mois";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_admin', $id_admin);
        $stmt->bindParam(':mois', $mois);
        $stmt->execute();
    }

    // Méthode pour obtenir un paiement spécifique par matricule
    public function obtenirPaiementParMatricule($matricule) {
        $sql = "
        SELECT a.prenom, a.nom, a.matricule, s.taux_horaire, s.heures_travaillees, a.id as id_admin
        FROM administrateur a
        JOIN salaire s ON a.id = s.id_admin
        WHERE a.matricule = :matricule"; 

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Utiliser fetch pour un seul résultat
    }

    // Méthode pour annuler un paiement
    public function annulerPaiement($id_admin, $mois) {
        $sql = "UPDATE salaire SET paiement_effectue = 0 WHERE id_admin = :id_admin AND mois = :mois";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_admin', $id_admin);
        $stmt->bindParam(':mois', $mois);
        $stmt->execute();
    }
}
