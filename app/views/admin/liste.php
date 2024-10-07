<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure les fichiers nécessaires
include $_SERVER['DOCUMENT_ROOT'] . '/gestion-ecole/config/db.php';
include '../header.php'; // Inclusion du header

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
    <a href="logout.php" class="btn btn-deconnexion">Déconnexion</a>
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
            case 'tableau_de_bord':
                include 'dashboard.php';
                break;

            case 'administrateurs':
                echo '<h2>Gestion des Administrateurs</h2>';
                echo '<a href="add_admin.php" class="btn btn-primary mb-3">Ajouter un Administrateur</a>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>ID</th><th>Nom</th><th>Prenom</th><th>Email</th><th>Actions</th></tr></thead><tbody>';
                $stmt = $pdo->query("SELECT * FROM administrateur");
                if ($stmt === false) {
                    echo "Erreur dans la requête : " . implode(", ", $pdo->errorInfo());
                } else {
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['id_admin']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['prenom']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                           
                            // Remplacer le texte par des icônes
                            echo '<td>
                                    <a href="edit_admin.php?id=' . $row['id_admin'] . '" class="btn btn-warning btn-sm" title="Éditer">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="delete_admin.php?id=' . $row['id_admin'] . '" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm(\'Êtes-vous sûr ?\');">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='5'>Aucun administrateur trouvé.</td></tr>";
                    }
                }
                echo '</tbody></table>';
                break;

            case 'eleves':
                echo '<h2>Gestion des Élèves</h2>';
                echo '<a href="add_eleve.php" class="btn btn-primary mb-3">Ajouter un Élève</a>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>ID</th><th>Nom</th><th>matricule</th><th>Date_naissance</th><th>Actions</th></tr></thead><tbody>';
                $stmt = $pdo->query("SELECT * FROM eleve");
                if ($stmt === false) {
                    echo "Erreur dans la requête : " . implode(", ", $pdo->errorInfo());
                } else {
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['id_eleve']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['matricule']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['date_naissance']) . '</td>';
                            // Remplacer le texte par des icônes
                            echo '<td>
                                    <a href="edit_eleve.php?id=' . $row['id_eleve'] . '" class="btn btn-warning btn-sm" title="Éditer">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="delete_eleve.php?id=' . $row['id_eleve'] . '" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm(\'Êtes-vous sûr ?\');">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='5'>Aucun élève trouvé.</td></tr>";
                    }
                }
                echo '</tbody></table>';
                break;

            case 'finance':
                echo '<h2>Gestion Finance</h2>';
                echo '<a href="add_eleve.php" class="btn btn-primary mb-3">Ajouter un Comptable</a>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>ID</th><th>Description</th><th>Montant</th><th>Date</th><th>Actions</th></tr></thead><tbody>';
                $stmt = $pdo->query("SELECT * FROM administrateur WHERE role='comptable'");
                if ($stmt === false) {
                    echo "Erreur dans la requête : " . implode(", ", $pdo->errorInfo());
                } else {
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['id_admin']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['prenom']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            // Remplacer le texte par des icônes
                            echo '<td>
                                    <a href="edit_finance.php?id=' . $row['id_admin'] . '" class="btn btn-warning btn-sm" title="Éditer">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="delete_finance.php?id=' . $row['id_admin'] . '" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm(\'Êtes-vous sûr ?\');">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='5'>Aucune entrée financière trouvée.</td></tr>";
                    }
                }
                echo '</tbody></table>';
                break;

            case 'surveillants':
                echo '<h2>Gestion des Surveillants</h2>';
                echo '<a href="add_eleve.php" class="btn btn-primary mb-3">Ajouter un surveillant</a>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Actions</th></tr></thead><tbody>';
                $stmt = $pdo->query("SELECT * FROM administrateur WHERE role='surveillant'");
                if ($stmt === false) {
                    echo "Erreur dans la requête : " . implode(", ", $pdo->errorInfo());
                } else {
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['matricule']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            // Remplacer le texte par des icônes
                            echo '<td>
                                    <a href="edit_surveillant.php?id=' . $row['id_admin'] . '" class="btn btn-warning btn-sm" title="Éditer">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="delete_surveillant.php?id=' . $row['id_admin'] . '" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm(\'Êtes-vous sûr ?\');">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='4'>Aucun surveillant trouvé.</td></tr>";
                    }
                }
                echo '</tbody></table>';
                break;

            // Ajoute d'autres cas ici pour les autres sections (enseignants, etc.)
            case 'enseignants':
                echo '<h2>Gestion des enseignants</h2>';
                echo '<a href="add_enseignant.php" class="btn btn-primary mb-3">Ajouter un enseignant</a>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Actions</th></tr></thead><tbody>';
                $stmt = $pdo->query("SELECT * FROM administrateur WHERE role='enseignant'");
                if ($stmt === false) {
                    echo "Erreur dans la requête : " . implode(", ", $pdo->errorInfo());
                } else {
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['matricule']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            // Remplacer le texte par des icônes
                            echo '<td>
                                    <a href="edit_enseignant.php?id=' . $row['id_admin'] . '" class="btn btn-warning btn-sm" title="Éditer">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="delete_enseignant.php?id=' . $row['id_admin'] . '" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm(\'Êtes-vous sûr ?\');">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='4'>Aucun enseignant trouvé.</td></tr>";
                    }
                }
                echo '</tbody></table>';
                break;

            default:
                echo '<h2>Bienvenue sur le tableau de bord</h2>';
                break;
        }
        ?>
        
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../../../public/css/dashboard.css">
</body>
</html>