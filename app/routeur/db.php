<?php
// config/database.php

$host = 'localhost';
$db   = 'gestion-ecole';
$user = 'root'; // Remplace par ton nom d'utilisateur
$pass = '';     // Remplace par ton mot de passe

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
