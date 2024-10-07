<?php
class Comptable {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM comptable");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>