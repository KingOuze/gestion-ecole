<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/db.php'; // Connexion à la base de données
require_once ('../../controllers/SuivitPaiementController.php');

// Utiliser la connexion PDO existante
$SuiviPaiementController = new SuiviPaiementController($db);

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Récupérer tous les paiements
$paiements = $SuiviPaiementController->getAllPaiements();

if (is_array($paiements)) {
    if (count($paiements) > 0) {
        // Les paiements sont disponibles pour affichage
    } else {
        echo "Aucun paiement trouvé.";
    }
} else {
    echo $paiements; // Affichez l'erreur si ce n'est pas un tableau
}

// Effectuer la pagination
$paiements = array_slice($paiements, $offset, $limit);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Paiements</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/SuivitPaiement.css">
</head>
<body>
    <!-- Barre latérale -->
    <div class="d-flex">
        <div class="sidebar">
            <div class="logo text-center">
                <img src="Badge_Education_Badge_Logo.png" alt="Logo">
            </div>
            <nav class="nav flex-column">
                <h4>Ecole de la réussite</h4>
                <a class="nav-link active" href="#">Accueil</a>
                <a class="nav-link" href="#">Professeur</a>
                <a class="nav-link" href="#">Suivi Paiement</a>
                <a class="nav-link" href="#">Autres</a>
            </nav>
        </div>

        <!-- Contenu principal -->
        <div class="content flex-grow-1 p-4">
            <h1 class="mb-4">Suivi de Paiement</h1>

            <!-- Sélecteur de mois et barre de recherche -->
            <div class="form-group d-flex align-items-center mb-3">
                <label for="monthSelect" class="mr-3">Sélectionnez le Mois</label>
                <select class="form-control custom-select mr-3" id="monthSelect">
                    <option value="">--Selectionnez le mois--</option>
                    <option>Janvier</option>
                    <option>Février</option>
                    <option>Mars</option>
                    <option>Avril</option>
                    <option>Mai</option>
                    <option>Juin</option>
                    <option>Juillet</option>
                    <option>Août</option>
                    <option>Septembre</option>
                    <option>Octobre</option>
                    <option>Novembre</option>
                    <option>Décembre</option>
                </select>

                <div class="search-container">
                    <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Rechercher un employé par matricule...">
                    <span class="icon">🔍</span>
                </div>
            </div>

            <!-- Tableau des paiements -->
            <table class="table table-striped" id="tableau">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Matricule</th>
                        <th>Mois</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($paiements)): ?>
                    <?php foreach ($paiements as $paiement): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($paiement['nom']); ?></td>
                            <td><?php echo htmlspecialchars($paiement['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($paiement['matricule']); ?></td>
                            <td><?php echo htmlspecialchars($paiement['mois_payer']); ?></td>
                            <td>
                                <?php if ($paiement['etat_paiement'] === 'payé') : ?>
                                    <span style="color: green;"><?php echo htmlspecialchars($paiement['etat_paiement']); ?></span>
                                <?php else : ?>
                                    <span style="color: red;"><?php echo htmlspecialchars($paiement['etat_paiement']); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?> 
                    <tr>
                        <td colspan="5" class="text-center">Aucun paiement effectué.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/public/js/input.js"></script> <!-- Lien vers le fichier JS -->
</body>
</html>