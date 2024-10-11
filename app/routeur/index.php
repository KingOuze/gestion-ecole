<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// index.php


require_once __DIR__ . '/../controllers/DashboardMensualiteController.php';

$controller = new DashboardMensualiteController($conn);
$controller->index();
