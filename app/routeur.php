<?php
require_once '../app/config/db.php';
require_once '../app/controllers/DashboardController.php';
require_once '../app/controllers/ElevesController.php';

$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

$controller = 'DashboardController';
$action = 'index';

switch ($request) {
    case '/':
        $controller = 'DashboardController';
        $action = 'index';
        break;
    case '/eleves':
        $controller = 'ElevesController';
        $action = 'index';
        break;
    case '/enseignants':
        $controller = 'EnseignantsController';
        $action = 'index';
        break;
    case '/surveillants':
        $controller = 'SurveillantsController';
        $action = 'index';
        break;
    case '/finance':
        $controller = 'FinanceController';
        $action = 'index';
        break;
    // Ajoute d'autres routes ici
}
?>