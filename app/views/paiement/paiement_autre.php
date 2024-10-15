<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation des variables
$matricule = '';
$eleveInfo = [];
$showTable = false;

// Connexion à la base de données avec PDO
try {
    $conn = new PDO("mysql:host=localhost;dbname=gestion-ecole;charset=utf8", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Traiter la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matricule'])) {
    $matricule = trim($_POST['matricule']);
    $stmt = $conn->prepare("
        SELECT a.matricule, a.nom, a.prenom, t.montant 
        FROM administrateur a 
        INNER JOIN tarifs t ON a.role COLLATE utf8mb4_unicode_ci = t.role COLLATE utf8mb4_unicode_ci 
        WHERE a.archive = FALSE AND a.matricule = :matricule
    ");
    $stmt->bindParam(':matricule', $matricule);
    $stmt->execute();
    $eleveInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $showTable = !empty($eleveInfo);
}

// Enregistrement du paiement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enregistrer'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $montant = $_POST['montant'];
    $mois = $_POST['mois'];

    // Vérifier si un paiement existe déjà pour ce mois
    $checkStmt = $conn->prepare("
        SELECT COUNT(*) FROM suivit_de_paiement 
        WHERE matricule = :matricule AND mois_payer = :mois
    ");
    $checkStmt->bindParam(':matricule', $matricule);
    $checkStmt->bindParam(':mois', $mois);
    $checkStmt->execute();
    $paiementExistant = $checkStmt->fetchColumn() > 0;

    if ($paiementExistant) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ce paiement a déjà été effectué pour le mois sélectionné.'
        ]);
        exit;
    }

    // Enregistrement du paiement
    $insertStmt = $conn->prepare("
        INSERT INTO suivit_de_paiement (matricule, nom, prenom, mois_payer, montant, etat_paiement)
        VALUES (:matricule, :nom, :prenom, :mois, :montant, 'payé')
    ");
    $insertStmt->bindParam(':matricule', $matricule);
    $insertStmt->bindParam(':nom', $nom);
    $insertStmt->bindParam(':prenom', $prenom);
    $insertStmt->bindParam(':mois', $mois);
    $insertStmt->bindParam(':montant', $montant);
    $insertStmt->execute();

    echo json_encode([
        'status' => 'success',
        'message' => 'Paiement enregistré avec succès.'
    ]);
    exit;
}

// Vérifier les paiements pour chaque élève
foreach ($eleveInfo as &$row) {
    $mois = $_POST['mois'] ?? date('m'); // Utiliser le mois sélectionné
    $stmt = $conn->prepare("SELECT COUNT(*) FROM suivit_de_paiement WHERE matricule = :matricule AND mois_payer = :mois");
    $stmt->bindParam(':matricule', $row['matricule']);
    $stmt->bindParam(':mois', $mois);
    $stmt->execute();
    
    $row['paiement_existe'] = $stmt->fetchColumn() > 0; // Vérifier si un paiement existe
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/gestion-ecole/public/css/paiement_autre.css">
    <style>
        .image-section {
    display: flex; /* Utilise le flexbox pour centrer l'image */
    justify-content: center; /* Centre horizontalement */
    align-items: center; /* Centre verticalement */
    margin-top: 0; /* Enlève la marge supérieure */
    height: 110vh; /* Prend toute la hauteur de la fenêtre */
    overflow: hidden; /* Cache tout débordement */
}

.responsive-image {
    width: 100%; /* L'image prend toute la largeur de son conteneur */
    height: 100%; /* L'image prend toute la hauteur de son conteneur */
    object-fit: cover; /* Couvre complètement le conteneur tout en gardant les proportions */
}
    </style>
</head>
<body>
    <div class="dashboard-container">
        <nav class="sidebar">
            <ul>
                <div class="logo">
                    <img src="../../../public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo" class="logo">
                </div>
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Tableau de bord</a></li>
                <li><a href="admin.php"><i class="fas fa-user-shield"></i> Gestion des administrateurs</a></li>
                <li><a href="eleve.html"><i class="fas fa-users"></i> Gestion des élèves</a></li>
                <li><a href="employer.html"><i class="fas fa-briefcase"></i> Gestion des employés</a></li>
                <li><a href="comptabilite.html"><i class="fas fa-calculator"></i> Comptabilité</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <header class="header d-flex justify-content-between align-items-center">
                <h1>Gestion Paiements des autres employés</h1>
                <div class="search-container">
                    <form method="post">
                        <input type="text" class="form-control" name="matricule" placeholder="Rechercher par matricule" required value="<?php echo htmlspecialchars($matricule); ?>">
                        <button type="submit" name="search" class="search-button"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="logout">
                    <a href="connexion.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </div>
            </header>

            <div id="image-section" class="image-section" style="display: <?php echo $showTable ? 'none' : 'block'; ?>;">
                <img src="../../../public/images/Capture d'écran 2024-10-08 124031.png" alt="Image d'information" class="responsive-image">
            </div>

            <div class="results-container">
                <?php if ($showTable): ?>
                <table class="table table-striped" id="results-table">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Mois</th>
                            <th>Montant</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($eleveInfo)): ?>
                            <?php foreach ($eleveInfo as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['matricule']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                                <td>
                                    <select class="form-control month-select">
                                        <?php 
                                        $months = [
                                            "01" => "Janvier", "02" => "Février", "03" => "Mars", "04" => "Avril",
                                            "05" => "Mai", "06" => "Juin", "07" => "Juillet", "08" => "Août",
                                            "09" => "Septembre", "10" => "Octobre", "11" => "Novembre", "12" => "Décembre"
                                        ];
                                        foreach ($months as $num => $name): ?>
                                            <option value="<?php echo $num; ?>"><?php echo $name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><?php echo htmlspecialchars($row['montant']); ?></td>
                                <td>
                                    <select class="form-control payment-status" data-matricule="<?php echo htmlspecialchars($row['matricule']); ?>" data-nom="<?php echo htmlspecialchars($row['nom']); ?>" data-prenom="<?php echo htmlspecialchars($row['prenom']); ?>" data-montant="<?php echo htmlspecialchars($row['montant']); ?>">
                                        <option value="non-paye">Non payé</option>
                                        <option value="payer">Payer</option>
                                        <option value="deja-paye" <?php echo $row['paiement_existe'] ? 'selected' : ''; ?>>Déjà payé</option>
                                    </select>
                                    <button class="btn btn-secondary btn-receipt" style="display: none;">Générer un reçu</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Aucun résultat trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de paiement -->
    <div class="modal fade" id="paymentConfirmationModal" tabindex="-1" aria-labelledby="paymentConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentConfirmationModalLabel">Confirmation de Paiement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez-vous enregistrer le paiement ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="confirmPaymentButton">Oui</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'avertissement de paiement existant -->
    <div class="modal fade" id="paymentAlreadyExistsModal" tabindex="-1" aria-labelledby="paymentAlreadyExistsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentAlreadyExistsModalLabel">Avertissement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="existingPaymentMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de reçu -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Reçu de Paiement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="bulletin-container">
                        <div class="header">
                            <img src="../../../public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo de l'école">
                            <div class="title">Bulletin de salaire</div>
                            <div class="date-reçu">
                                <div>Date : <span id="modal-date"></span></div>
                                <div>Reçu : N-0001</div>
                            </div>
                        </div>

                        <div class="info-section">
                            <div class="info">
                                <label>Matricule :</label>
                                <span id="modal-matricule"></span>
                            </div>
                            <div class="info">
                                <label>Nom et Prénom :</label>
                                <span id="modal-nom"></span>
                            </div>
                            <div class="info">
                                <label>Montant :</label>
                                <span id="modal-montant"></span>
                            </div>
                            <div class="info">
                                <label>Mois :</label>
                                <span id="modal-mois"></span>
                            </div>
                        </div>

                        <div class="footer">
                            <div class="signature">LE DIRECTEUR</div>
                            <img src="../../../public/images/logo_directeur.png" alt="Logo de signature" class="signature-logo">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-outline-primary" id="printReceiptButton"><i class="fas fa-print"></i> Imprimer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-receipt').on('click', function() {
        // Récupérer les données nécessaires pour le reçu
        var matricule = $(this).closest('tr').find('.payment-status').data('matricule');
        var nom = $(this).closest('tr').find('.payment-status').data('nom');
        var prenom = $(this).closest('tr').find('.payment-status').data('prenom');
        var montant = $(this).closest('tr').find('.payment-status').data('montant');
        var mois = $(this).closest('tr').find('.month-select').val();
        var date = new Date().toLocaleDateString(); // Date actuelle pour le reçu
        var numeroRecu = 'N-0001'; // Exemple de numéro de reçu, vous pouvez le générer dynamiquement si nécessaire

        // Remplir les données du reçu dans le modal
        $('#receiptModal .modal-body .bulletin-container #modal-matricule').text(matricule);
        $('#receiptModal .modal-body .bulletin-container #modal-nom').text(nom + ' ' + prenom);
        $('#receiptModal .modal-body .bulletin-container #modal-montant').text(montant + ' FCFA');
        $('#receiptModal .modal-body .bulletin-container #modal-mois').text(mois);
        $('#receiptModal .modal-body .bulletin-container .date-reçu div:first-child span').text(date);
        $('#receiptModal .modal-body .bulletin-container .date-reçu div:last-child').text('Reçu : ' + numeroRecu);

        // Afficher le modal
        $('#receiptModal').modal('show');
    });
});
</script>


    
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    let currentRow;

    // Gérer l'affichage de la section d'image et du tableau
    function toggleImageAndTable() {
        const imageSection = document.getElementById('image-section');
        const resultsTable = document.getElementById('results-table');

        // Si le tableau existe et qu'il a des lignes, on masque l'image
        if (resultsTable && resultsTable.style.display !== 'none') {
            imageSection.style.display = 'none'; // Masquer l'image si le tableau est visible
        } else {
            imageSection.style.display = 'block'; // Afficher l'image si le tableau est masqué
        }
    }

    // Appel initial pour définir l'affichage
    toggleImageAndTable();

    // Événement pour le champ matricule
    const matriculeInput = document.querySelector('input[name="matricule"]');
    matriculeInput.addEventListener('input', function() {
        if (!this.value.trim()) { // Si le champ est vide
            toggleImageAndTable(); // Met à jour l'affichage
        }
    });

    // Événement pour le bouton de recherche
    document.querySelector('form').addEventListener('submit', function() {
        toggleImageAndTable(); // Met à jour l'affichage lors de la soumission
    });

    document.querySelectorAll('.payment-status').forEach(select => {
        select.addEventListener('change', function() {
            const selectedValue = this.value;
            currentRow = this.closest('tr');

            if (selectedValue === 'payer') {
                $('#paymentConfirmationModal').modal('show');
            } else if (selectedValue === 'deja-paye') {
                const receiptButton = currentRow.querySelector('.btn-receipt');
                receiptButton.style.display = 'inline-block';
            } else {
                const receiptButton = currentRow.querySelector('.btn-receipt');
                receiptButton.style.display = 'none';
            }
        });
    });

    document.getElementById('confirmPaymentButton').addEventListener('click', function() {
        const matricule = currentRow.querySelector('.payment-status').dataset.matricule;
        const nom = currentRow.querySelector('.payment-status').dataset.nom;
        const prenom = currentRow.querySelector('.payment-status').dataset.prenom;
        const montant = currentRow.querySelector('.payment-status').dataset.montant;
        const mois = currentRow.querySelector('.month-select').value;

        const form = new FormData();
        form.append('matricule', matricule);
        form.append('nom', nom);
        form.append('prenom', prenom);
        form.append('montant', montant);
        form.append('mois', mois);
        form.append('enregistrer', true);

        fetch(window.location.href, {
            method: 'POST',
            body: form
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                $('#paymentConfirmationModal').modal('hide');

                const paymentStatusSelect = currentRow.querySelector('.payment-status');
                paymentStatusSelect.value = 'deja-paye'; // Mettre à jour le sélecteur
                const receiptButton = currentRow.querySelector('.btn-receipt');
                receiptButton.style.display = 'inline-block'; // Afficher le bouton "Générer un reçu"
            } else {
                $('#paymentAlreadyExistsModal').modal('show');
                document.getElementById('existingPaymentMessage').textContent = data.message;
            }
        });
    });

    document.getElementById('printReceiptButton').addEventListener('click', function() {
        window.print();
    });
});
    </script>
</body>
</html>

<?php
$conn = null; // Ferme la connexion
?>