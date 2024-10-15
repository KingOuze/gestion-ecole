<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Admin {
    private $conn;

    // Propriétés de l'administrateur
    public $id_admin;
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $matricule;
    public $mot_de_passe;
    public $role;
    public $date_creation;
    public $date_modification;
    public $archivage;

    // Constructeur pour établir la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour créer un nouvel administrateur
    public function create() {
        $query = "INSERT INTO administrateur (nom, prenom, email, telephone, matricule, mot_de_passe, role, date_creation, archivage)
                  VALUES (:nom, :prenom, :email, :telephone, :matricule, :mot_de_passe, :role, NOW(), :archivage)";

        $stmt = $this->conn->prepare($query);
        
        // Liage des paramètres
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':matricule', $this->matricule);
        $stmt->bindParam(':mot_de_passe', password_hash($this->mot_de_passe, PASSWORD_DEFAULT));
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':archivage', $this->archivage);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour lire tous les administrateurs non archivés
    public function read() {
        $query = "SELECT * FROM administrateur WHERE archivage = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function count() {
        $query = "SELECT COUNT(*) FROM administrateur WHERE archivage = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    // Méthode pour lire tous les administrateurs archivés
    public function readArchived() {
        $query = "SELECT * FROM administrateur WHERE archivage = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Méthode pour lire un administrateur par ID
    public function readOne() {
        $query = "SELECT * FROM administrateur WHERE id_admin = :id_admin";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_admin', $this->id_admin);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Assigner les valeurs aux propriétés
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->email = $data['email'];
        $this->telephone = $data['telephone'];
        $this->matricule = $data['matricule'];
        $this->mot_de_passe = $data['mot_de_passe'];
        $this->role = $data['role'];
        $this->date_creation = $data['date_creation'];
        $this->date_modification = $data['date_modification'];
        $this->archivage = $data['archivage'];
    }

    // Méthode pour mettre à jour un administrateur
    public function update() {
        $query = "UPDATE administrateur SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, 
                  matricule = :matricule, mot_de_passe = :mot_de_passe, role = :role, 
                  date_modification = NOW(), archivage = :archivage 
                  WHERE id_admin = :id_admin";

        $stmt = $this->conn->prepare($query);

        // Liage des paramètres
        $stmt->bindParam(':id_admin', $this->id_admin);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':matricule', $this->matricule);
        $stmt->bindParam(':mot_de_passe', password_hash($this->mot_de_passe, PASSWORD_DEFAULT));
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':archivage', $this->archivage);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour archiver un administrateur
    public function archive($id_admin) {
        $stmt = $this->conn->prepare("UPDATE administrateur SET archivage = 1 WHERE id_admin = :id_admin");
        $stmt->bindParam(':id_admin', $id_admin); // Lier l'ID administrateur
        return $stmt->execute(); // Retourne le résultat de l'exécution
    }
    

    // Méthode pour restaurer un administrateur
    public function restore() {
        $query = "UPDATE administrateur SET archivage = 0 WHERE id_admin = :id_admin";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_admin', $this->id_admin);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour supprimer un administrateur (physiquement si nécessaire)
    public function delete() {
        $query = "DELETE FROM administrateur WHERE id_admin = :id_admin";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_admin', $this->id_admin);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
