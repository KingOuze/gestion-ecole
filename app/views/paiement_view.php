<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gestion-ecole/public/css/style.css">
    <title>Liste des Paiements</title>
</head>
<body>

<div class="sidebar">
    <div class="logo">
    <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo" class="logo">
    </div>
    <ul>
        <li><a href="#">Accueil</a></li>
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
            <input type="text" name="search" placeholder="Rechercher par matricule..." value="<?php echo htmlspecialchars($search); ?>" />
            <input type="submit" value="Rechercher" />
        </form>
    </div>

    <table>
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
                            <form method="POST" action="index.php">
                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($paiement['matricule']); ?>">
                                <input type="hidden" name="mois" value="<?php echo htmlspecialchars($paiement['mois']); ?>">
                                <button type="submit" name="payer">Payer</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="index.php">
                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($paiement['matricule']); ?>">
                                <input type="hidden" name="mois" value="<?php echo htmlspecialchars($paiement['mois']); ?>">
                                <button type="submit" name="annuler">Annuler paiement</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
