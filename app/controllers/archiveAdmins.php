<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/AdminController.php';

$database = new Database();
$adminController = new AdminController($database->conn);

if (isset($_GET['id_admin'])) {
    $id = $_GET['id_admin'];
    $result = $adminController->archiveAdmin($id);

    // Redirection après l'archivage
    header("Location: /views/admin/listAdmin.php?message=" . urlencode($result));
    exit();
}

