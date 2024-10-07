<?php
class Enseignant {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM administrateur WHERE role='enseignant'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM administrateur WHERE id_admin = ? AND role='enseignant'");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($nom, $prenom, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO administrateur (nom, prenom, email, role) VALUES (?, ?, ?, 'enseignant')");
        return $stmt->execute([$nom, $prenom, $email]);
    }

    public function update($id, $nom, $prenom, $email) {
        $stmt = $this->pdo->prepare("UPDATE administrateur SET nom = ?, prenom = ?, email = ? WHERE id_admin = ? AND role='enseignant'");
        return $stmt->execute([$nom, $prenom, $email, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM administrateur WHERE id_admin = ? AND role='enseignant'");
        return $stmt->execute([$id]);
    }
}
?>