<?php
require_once __DIR__ . '/../../../config/db.php';
require_once ('C:/xmp/htdocs/gestion-ecole/app/controllers/AdminController.php');
require_once('C:/xmp/htdocs/gestion-ecole/app/views/admin/header.php');
    
// Créer une instance de la connexion à la base de données
$database = new Database();
$adminController = new AdminController($database->conn);

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Récupérer tous les administrateurs non archivés
$admins = $adminController->readAdmins();
$totalAdmins = $adminController->totalAdmins(); // Récupère le total

if (is_array($admins)) {
    if (count($admins) > 0) {
        // Afficher les administrateurs
    } else {
        echo "Aucun administrateur trouvé.";
    }
} else {
    echo $admins; // Affichez l'erreur
}

$total_pages = ceil($totalAdmins / $limit);
$admins = array_slice($admins, $offset, $limit);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Administrateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/modifier.css">
    
</head>
<body>
    <div class="container">
    <h2 class="text-center"></h2>
      <!-- Main content -->
      <div class="main-content">
        <div class="header">
            <div class="search-bar">
                <input type="text" placeholder="Rechercher">
                <i class="fas fa-search"></i>
            </div>
            <button class="add-button" id="openModalBtn">
                <i class="fas fa-plus"></i> Ajouter un administrateur
            </button>
        </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($admins)): ?>
                <?php foreach($admins as $row): ?>
                    <tr>
                        <td><?php echo $row['id_admin']; ?></td>
                        <td><?php echo $row['nom']; ?></td>
                        <td><?php echo $row['prenom']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['telephone']; ?></td>
                        
                       
                        <td>
                              <a href="editAdmin.php?id=<?php echo $row['id_admin']; ?>" class="btn btn-primary btn-sm">Modifier</a>

                              <a href="/gestion-ecole/public/index.php?action=archiveAdmin&id=<?php echo $row['id_admin']; ?>" class="btn btn-warning btn-sm">Archiver</a>
                        
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">Aucun administrateur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
