<?php
class DashboardModel {
    private $db;

    public function __construct() {
        require_once '../config/db.php';
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getCounts() {
        $data = [];

        // Compter le nombre d'élèves
        $result = $this->db->query("SELECT COUNT(*) as count FROM eleve");
        $data['eleves'] = $result->fetch_assoc()['count'];

        // Compter le nombre de professeurs
        $result = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='professeur'");
        $data['professeurs'] = $result->fetch_assoc()['count'];

        // Compter le nombre d'enseignants
        $result = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='enseignant'");
        $data['enseignants'] = $result->fetch_assoc()['count'];

        // Compter le nombre de comptables
        $result = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='comptable'");
        $data['comptables'] = $result->fetch_assoc()['count'];

        // Compter le nombre de surveillants
        $result = $this->db->query("SELECT COUNT(*) as count FROM administrateur WHERE role='surveillant'");
        $data['surveillants'] = $result->fetch_assoc()['count'];

        // Compter le nombre d'administrateurs
        $result = $this->db->query("SELECT COUNT(*) as count FROM administrateur");
        $data['administrateurs'] = $result->fetch_assoc()['count'];

        return $data;
    }
}
?>