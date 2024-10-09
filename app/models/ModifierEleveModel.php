<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Eleve {
    private $conn;

    // Propriétés de l'élève
    public $id_eleve;
    public $matricule;
    public $nom;
    public $prenom;
    public $date_naissance;
    public $telephone;
    public $adresse;
    public $date_inscription;
    public $id_classe;

    // Constructeur pour établir la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour créer un nouvel élève
    public function create() {
        $query = "INSERT INTO eleve (matricule, nom, prenom, date_naissance, telephone, adresse, date_inscription, id_classe)
                  VALUES (:matricule, :nom, :prenom, :date_naissance, :telephone, :adresse, :date_inscription, :id_classe)";

        $stmt = $this->conn->prepare($query);
        
        // Liage des paramètres
        $stmt->bindParam(':matricule', $this->matricule);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':date_naissance', $this->date_naissance);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':date_inscription', $this->date_inscription);
        $stmt->bindParam(':id_classe', $this->id_classe);

        return $stmt->execute();
    }

    // Méthode pour lire tous les élèves
    public function read() {
        $query = "SELECT * FROM eleve";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function count() {
        $query = "SELECT COUNT(*) FROM eleve";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Méthode pour lire un élève par ID
    public function readOne() {
        $query = "SELECT * FROM eleve WHERE id_eleve = :id_eleve";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_eleve', $this->id_eleve);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Assigner les valeurs aux propriétés
        $this->matricule = $data['matricule'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->date_naissance = $data['date_naissance'];
        $this->telephone = $data['telephone'];
        $this->adresse = $data['adresse'];
        $this->date_inscription = $data['date_inscription'];
        $this->id_classe = $data['id_classe'];
    }

    // Méthode pour mettre à jour un élève
    public function update() {
        $query = "UPDATE eleve SET matricule = :matricule, nom = :nom, prenom = :prenom, 
                  date_naissance = :date_naissance, telephone = :telephone, adresse = :adresse, 
                  date_inscription = :date_inscription, id_classe = :id_classe 
                  WHERE id_eleve = :id_eleve";

        $stmt = $this->conn->prepare($query);

        // Liage des paramètres
        $stmt->bindParam(':id_eleve', $this->id_eleve);
        $stmt->bindParam(':matricule', $this->matricule);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':date_naissance', $this->date_naissance);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':date_inscription', $this->date_inscription);
        $stmt->bindParam(':id_classe', $this->id_classe);

        return $stmt->execute();
   
        
}
public function archive($id_eleve) {
    $stmt = $this->conn->prepare("UPDATE eleve SET archivage = 1 WHERE id_admin = :id_admin");
    $stmt->bindParam(':id_admin', $id_eleve); // Lier l'ID administrateur
    return $stmt->execute(); // Retourne le résultat de l'exécution
}

 public function delete() {
    $query = "DELETE eleve SET matricule = :matricule, nom = :nom, prenom = :prenom, 
    date_naissance = :date_naissance, telephone = :telephone, adresse = :adresse, 
    date_inscription = :date_inscription, id_classe = :id_classe 
    WHERE id_eleve = :id_eleve";

    $stmt = $this->conn->prepare($query);

   // Liage des paramètres
    $stmt->bindParam(':id_eleve', $this->id_eleve);
    $stmt->bindParam(':matricule', $this->matricule);
    $stmt->bindParam(':nom', $this->nom);
    $stmt->bindParam(':prenom', $this->prenom);
    $stmt->bindParam(':date_naissance', $this->date_naissance);
    $stmt->bindParam(':telephone', $this->telephone);
    $stmt->bindParam(':adresse', $this->adresse);
    $stmt->bindParam(':date_inscription', $this->date_inscription);
    $stmt->bindParam(':id_classe', $this->id_classe);

return $stmt->execute();
}
}