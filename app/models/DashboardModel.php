<?php
class DashboardModel {
  

    private $db;

    public function __construct() {
        require_once '/gestion-ecole/config/db.php';
        $this->db = $conn; // Utiliser la connexion PDO définie dans db.php
    }

    public function getCounts() {
        $data = [];

        // Compter le nombre d'élèves
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM eleve");
        $data['eleves'] = $stmt->fetchColumn();
        var_dump($data['eleves']); // Debug

        // Compter le nombre de professeurs
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='professeur'");
        $data['professeurs'] = $stmt->fetchColumn();

        // Compter le nombre d'enseignants
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='enseignant'");
        $data['enseignants'] = $stmt->fetchColumn();

        // Compter le nombre de comptables
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='comptable'");
        $data['comptables'] = $stmt->fetchColumn();

        // Compter le nombre de surveillants
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='surveillant'");
        $data['surveillants'] = $stmt->fetchColumn();

        // Compter le nombre d'administrateurs
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM administrateur");
        $data['administrateurs'] = $stmt->fetchColumn();

        return $data;
    }
}
