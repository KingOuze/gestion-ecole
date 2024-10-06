<?php
try {
    $host = 'localhost';
    $dbname = 'gestion-ecole';
    $username = 'root';
    $password = '';

    // Établir la connexion
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
