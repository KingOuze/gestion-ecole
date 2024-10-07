<?php
class Administrateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM administrateur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>