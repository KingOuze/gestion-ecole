<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gestion-ecole/public/css/paieprof.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Liste des Paiements</title>
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo" class="logo">
    </div>
    <ul>
        <li><a href="/gestion-ecole/app/views/Gestion_paiement.php">Accueil</a></li>
        <li><a href="#">Professeurs</a></li>
        <li><a href="#">Paiements</a></li>
        <li><a href="#">Rapports</a></li>
        <li><a href="#">Déconnexion</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="search-container">
        <h1>Paiements des professeurs</h1>
        
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Rechercher par matricule..." value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>" />
            <input type="text" name="mois" placeholder="Rechercher par mois (ex: 2024-10)..." value="<?php echo isset($mois) ? htmlspecialchars($mois) : ''; ?>" />
            <input type="submit" value="Rechercher" />
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Matricule</th>
                <th>Taux Horaire</th>
                <th>Heures Travaillées</th>
                <th>Total Salaire</th>
                <th>Mois</th>
                <th>Statut de Paiement</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($paiements)): ?>
                <tr>
                    <td colspan="9" style="text-align: center;">Aucun paiement trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($paiements as $paiement): ?>
                <tr>
                    <td><?php echo htmlspecialchars($paiement['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['nom']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['matricule']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['taux_horaire']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['heures_travaillees']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['total_salaire']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['mois']); ?></td>
                    <td><?php echo $paiement['paiement_effectue'] ? 'Payé' : 'Non payé'; ?></td>
                    <td>
                        <?php if (!$paiement['paiement_effectue']): ?>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($paiement['matricule']); ?>">
                                <input type="hidden" name="mois" value="<?php echo htmlspecialchars($paiement['mois']); ?>">
                                <button type="submit" name="payer" class="btn btn-success">Payer</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($paiement['matricule']); ?>">
                                <input type="hidden" name="mois" value="<?php echo htmlspecialchars($paiement['mois']); ?>">
                                <button type="submit" name="annuler" class="btn btn-danger">Annuler paiement</button>
                            </form>
                            <button class="btn btn-info btn-receipt" data-matricule="<?php echo htmlspecialchars($paiement['matricule']); ?>" 
                                    data-nom="<?php echo htmlspecialchars($paiement['prenom'] . ' ' . $paiement['nom']); ?>" 
                                    data-montant="<?php echo htmlspecialchars($paiement['total_salaire']); ?>" 
                                    data-mois="<?php echo htmlspecialchars($paiement['mois']); ?>" 
                                    data-toggle="modal" data-target="#receiptModal">Générer Reçu</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
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
                        <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo de l'école">
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
                        <img src="/gestion-ecole/public/images/logo_directeur.webp" alt="Logo de signature" class="signature-logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-receipt').on('click', function() {
            var matricule = $(this).data('matricule');
            var nom = $(this).data('nom');
            var montant = $(this).data('montant');
            var mois = $(this).data('mois');
            var date = new Date().toLocaleDateString(); // Format de la date

            $('#modal-matricule').text(matricule);
            $('#modal-nom').text(nom);
            $('#modal-montant').text(montant);
            $('#modal-mois').text(mois);
            $('#modal-date').text(date);
        });
    });
</script>

</body>
</html>
