<?php
class StatModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour récupérer le total des élèves du primaire
    public function getTotalElevesPrimaire() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM eleve WHERE id_classe IN (SELECT id_classe FROM classe WHERE niveau = 'primaire')");
        return $stmt->fetchColumn() ?? 0;
    }

    // Méthode pour récupérer le total des élèves du secondaire
    public function getTotalElevesSecondaire() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM eleve WHERE id_classe IN (SELECT id_classe FROM classe WHERE niveau = 'secondaire')");
        return $stmt->fetchColumn() ?? 0;
    }

    // Méthode pour récupérer le total des professeurs
    public function getTotalProfesseurs() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM administrateur WHERE role = 'professeur'");
        return $stmt->fetchColumn() ?? 0;
    }

    // Méthode pour récupérer le total des employés
    public function getTotalEmployes() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM administrateur WHERE role IN ('admin', 'professeur', 'comptable', 'surveillant', 'enseignant')");
        return $stmt->fetchColumn() ?? 0;
    }

    // Méthode pour récupérer le total des administrateurs
    public function getTotalAdmins() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM administrateur WHERE role = 'admin'");
        return $stmt->fetchColumn() ?? 0;
    }

    // Méthode pour récupérer le total des comptables
    public function getTotalComptables() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM administrateur WHERE role = 'comptable'");
        return $stmt->fetchColumn() ?? 0;
    }

    // Méthode pour récupérer le total des surveillants
    public function getTotalSurveillants() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM administrateur WHERE role = 'surveillant'");
        return $stmt->fetchColumn() ?? 0;
    }

    // Méthodes pour récupérer les pourcentages de réussite des examens
    public function getPourcentageCFEE() {
        $stmt = $this->db->query("SELECT (COUNT(CASE WHEN result = 'admis' THEN 1 END) / COUNT(*)) * 100 AS pourcentage FROM examens WHERE type = 'CFEE'");
        return $stmt->fetchColumn() ?? 0;
    }

    public function getPourcentageBFEM() {
        $stmt = $this->db->query("SELECT (COUNT(CASE WHEN result = 'admis' THEN 1 END) / COUNT(*)) * 100 AS pourcentage FROM examens WHERE type = 'BFEM'");
        return $stmt->fetchColumn() ?? 0;
    }

    public function getPourcentageBAC() {
        $stmt = $this->db->query("SELECT (COUNT(CASE WHEN result = 'admis' THEN 1 END) / COUNT(*)) * 100 AS pourcentage FROM examens WHERE type = 'BAC'");
        return $stmt->fetchColumn() ?? 0;
    }
}
