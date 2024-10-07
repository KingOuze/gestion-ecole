<?php
class ElevesModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEleves() {
        $stmt = $this->pdo->query("SELECT * FROM eleve");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>