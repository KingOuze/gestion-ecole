<?php
class Professeur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM professeur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>