<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/db.php';
require_once '../app/controllers/ComptableController.php';

$controller = new ComptableController($db);

// Récupérer l'action et l'ID depuis l'URL
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Routeur simple
switch ($action) {
    case 'create':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controller->add();
        } else {
            // Afficher le formulaire de création
            echo '../views/create.php'; // Formulaire HTML
        }
        break;

    case 'update':
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $id) {
            $controller->update($id);
        } else {
            // Afficher le formulaire de mise à jour
            $admin = $controller->model->getById($id);
            echo '../views/update.php'; // Formulaire HTML
        }
        break;
    case 'show':
            if ($id) {
                $controller->showOne($id);
            }
            break;
    case 'delete':
        if ($id) {
            $controller->destroy($id);
        }
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
