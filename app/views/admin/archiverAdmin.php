<?php
require('C:/xmp/htdocs/gestion-ecole/config/db.php');
require('C:/xmp/htdocs/gestion-ecole/app/controllers/AdminController.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'Archivage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Confirmation d'Archivage</h2>
        <p>Êtes-vous sûr de vouloir archiver cet administrateur ?</p>
        <form action="/gestion-ecole/public/index.php?action=archiveAdmin" method="POST">
    <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($row['id_admin']) ?>">
    <button type="submit" class="btn btn-danger">Oui, archiver</button>
    <a href="listAdmin.php" class="btn btn-secondary">Non, retourner</a>
</form>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>