<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once __DIR__ . '/controllers/EleveMensualiteController.php';


// Création d'une instance du contrôleur d'élève
$controller = new EleveController();
$controller->handleRequest();

