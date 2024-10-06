<?php
$host = 'localhost'; // Adresse de l'hôte (généralement localhost)
$dbname = 'gestion-ecole'; // Nom de votre base de données
$user = 'niassy'; // Nom d'utilisateur de la base de données
$password = '1903'; // Mot de passe de la base de données

try {
    // Créer la connexion avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Définir le mode d'erreur de PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Vous pouvez ajouter d'autres attributs selon vos besoins
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}
?>
