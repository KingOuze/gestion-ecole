<?php
require_once ('C:/xmp/htdocs/gestion-ecole/config/db.php');
require_once('C:/xmp/htdocs/gestion-ecole/app/controllers/ModifierEleveController.php');
require_once('C:/xmp/htdocs/gestion-ecole/app/views/admin/header.php');

// Créer une instance de la connexion à la base de données
$database = new Database();
$eleveController = new EleveController($database->conn);

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Récupérer tous les élèves
$eleves = $eleveController->readEleves();
$totalEleves = $eleveController->totalEleves(); // Récupère le total

if (is_array($eleves)) {
    if (count($eleves) > 0) {
        // Afficher les élèves
    } else {
        echo "Aucun élève trouvé.";
    }
} else {
    echo $eleves; // Affichez l'erreur
}

$total_pages = ceil($totalEleves / $limit);
$eleves = array_slice($eleves, $offset, $limit);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Élèves</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/modifier.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Liste des Élèves</h2>
        <div class="header mb-3">
            <div class="search-bar">
                <input type="text" placeholder="Rechercher" class="form-control">
                <i class="fas fa-search"></i>
            </div>
            <button class="add-button btn btn-dark" id="openModalBtn">
                <i class="fas fa-plus"></i> Ajouter un élève
            </button>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Naissance</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Date d'Inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($eleves)): ?>
                    <?php foreach($eleves as $row): ?>
                        <tr>
                            <td><?php echo $row['id_eleve']; ?></td>
                            <td><?php echo $row['matricule']; ?></td>
                            <td><?php echo $row['nom']; ?></td>
                            <td><?php echo $row['prenom']; ?></td>
                            <td><?php echo $row['date_naissance']; ?></td>
                            <td><?php echo $row['telephone']; ?></td>
                            <td><?php echo $row['adresse']; ?></td>
                            <td><?php echo $row['date_inscription']; ?></td>
                            <td>
                                <a href="editEleve.php?id=<?php echo $row['id_eleve']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                                <a href="/gestion-ecole/public/index.php?action=archiveEleve&id=<?php echo $row['id_eleve']; ?>" class="btn btn-warning btn-sm">Archiver</a>
                                <a href="/gestion-ecole/public/index.php?action=deleteEleve&id=<?php echo $row['id_eleve']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Aucun élève trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
