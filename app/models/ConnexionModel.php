<?php
class ConnexionModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Vérifier si l'utilisateur existe par email
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM administrateur WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>