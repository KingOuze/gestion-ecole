<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// controllers/DashboardController.php

require_once __DIR__ . '/../routeur/db.php';
require_once __DIR__ . '/../models/ModelMensualiteEleve.php';

class DashboardMensualiteController {
    private $eleveModel;

    public function __construct($pdo) {
        $this->eleveModel = new Eleve($pdo);
    }

    public function index() {
        $totalEleves = $this->eleveModel->countTotalEleves();
        include '../views/ViewMensualite.php';
    }
}
