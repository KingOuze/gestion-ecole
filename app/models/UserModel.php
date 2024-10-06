<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour récupérer l'utilisateur par email
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Retourne null si aucun utilisateur trouvé
    }

    // Méthode pour ajouter un nouvel utilisateur
    public function addUser($nom, $prenom, $email, $telephone, $matricule, $motDePasse, $role) {
        $stmt = $this->db->prepare("
            INSERT INTO administrateur (nom, prenom, email, telephone, matricule, mot_de_passe, role, archivage) 
            VALUES (:nom, :prenom, :email, :telephone, :matricule, :motDePasse, :role, false)
        ");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':motDePasse', password_hash($motDePasse, PASSWORD_BCRYPT));
        $stmt->bindParam(':role', $role);
        return $stmt->execute(); // Retourne true ou false selon le succès
    }

    // Méthode pour mettre à jour un utilisateur
    public function updateUser($id, $nom, $prenom, $email, $telephone, $matricule, $role, $archivage) {
        $stmt = $this->db->prepare("
            UPDATE administrateur 
            SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, matricule = :matricule, role = :role, archivage = :archivage
            WHERE id_admin = :id
        ");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':archivage', $archivage, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); // Retourne true ou false selon le succès
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM administrateur WHERE id_admin = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute(); // Retourne true ou false selon le succès
    }

    // Méthode pour récupérer tous les utilisateurs
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM administrateur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Retourne un tableau vide si aucun utilisateur trouvé
    }

    // Méthode pour récupérer un utilisateur par son ID
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM administrateur WHERE id_admin = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Retourne null si aucun utilisateur trouvé
    }
}
