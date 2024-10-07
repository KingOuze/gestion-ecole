<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure les fichiers nécessaires
?>

<main class="flex-grow-1 p-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand">Bienvenue</span>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <div class="ml-auto">
                <a href="logout.php" class="btn btn-outline-danger">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="mt-4">

        <?php
        // Vérifiez quelle section est demandée
        $section = $_GET['section'] ?? '';

        // Debug: Afficher la section demandée
        echo '<p>Section demandée : ' . htmlspecialchars($section) . '</p>';

        switch ($section) {
            case 'administrateurs':
                echo '<h2>Gestion des Administrateurs</h2>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Actions</th></tr></thead><tbody>';
                $stmt = $pdo->query("SELECT * FROM administrateur");
                if ($stmt === false) {
                    echo "Erreur dans la requête : " . implode(", ", $pdo->errorInfo());
                } else {
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['id_admin']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            echo '<td>
                                    <a href="edit_admin.php?id=' . $row['id_admin'] . '" class="btn btn-warning btn-sm">Éditer</a>
                                    <a href="delete_admin.php?id=' . $row['id_admin'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr ?\');">Supprimer</a>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='4'>Aucun administrateur trouvé.</td></tr>";
                    }
                }
                echo '</tbody></table>';
                break;

            // Autres cas...
            default:
                echo '<h2>Bienvenue sur le tableau de bord</h2>';
                break;
        }
        ?>
        
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>