<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Paiements des Élèves</title>
    <link rel="stylesheet" href="lister.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="Badge_Education_Badge_Logo.png" alt="Logo">
            <h2 class="school-name">Ecole de la réussite</h2>
        </div>
        <ul>
            <li><a href="#">Tableau de Bord</a></li>
            <li><a href="#">Gestion Finance</a></li>
        </ul>
    </div>

    <div class="listecontainer">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <p class="centered-paragraph">Paiement Mensualité</p>
                <form method="post" class="search">
                    <input type="text" name="matricule" placeholder="Recherche par matricule" required value="<?php echo htmlspecialchars($matricule); ?>">
                    <button type="submit" name="search" class="search-button1">
                        <span class="icon">🔍</span>
                    </button>
                </form>
                <a href="#" class="deconnexion-link">
                    <span>Déconnexion</span>
                    <img src="iconeDeconnexion.png" alt="Déconnexion" class="deconnexion-icon">
                </a>
            </div>
        </div>

        <div class="container1">
            <p id="special-paragraph">Informations de l'élève</p>
            <?php if (!empty($eleveInfo)): ?>
                <table border="1" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Mois</th>
                            <th>Mensualité</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($eleveInfo['matricule']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['nom']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['classe']); ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <select name="month" required>
                                        <!-- Options for months -->
                                    </select>
                            </td>
                            <td><?php echo htmlspecialchars($eleveInfo['mensualite']); ?> CFA</td>
                            <td>
                                <select name="payment_state" required>
                                    <!-- Options for payment state -->
                                </select>
                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($matricule); ?>">
                                <button type="submit" name="update_payment" class="btn-submit">Mettre à jour</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun élève trouvé avec ce matricule.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>