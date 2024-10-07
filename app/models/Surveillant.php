<?php
class Surveillant {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM surveillant");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>