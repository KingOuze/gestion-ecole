<?php
require_once '../config/db.php';
require_once '../app/models/Administrateur.php';

class AdministrateurController {
    private $adminModel;

    public function __construct($pdo) {
        $this->adminModel = new Administrateur($pdo);
    }

    public function index() {
        $admins = $this->adminModel->getAll();
        include '../app/views/administrateur.php'; // Créez cette vue
    }
}
?>