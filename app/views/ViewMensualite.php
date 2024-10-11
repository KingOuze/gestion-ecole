<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Paiements des Élèves</title>
    <link rel="stylesheet" href="/gestion-ecole/app/views/paiement/mensualite.css">
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <img src="/gestion-ecole/app/views/paiement/Badge_Education_Badge_Logo.png" alt="Logo">
            <h2 class="school-name">Ecole de la réussite</h2>
        </div>
        <ul>
            <li><a href="#">Tableau de Bord</a></li>
            <li><a href="#">Gestion Finance</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            <p class="centered-paragraph">Gestion du paiement des élèves</p>
            <a href="#" class="deconnexion-link">
                <span>Déconnexion</span>
                <img src="/gestion-ecole/app/views/paiement/iconeDeconnexion.png" alt="Déconnexion" class="deconnexion-icon">
            </a>
        </div>
        <div class="statistic-container">
            <div class="stat">
                <h2><?= $totalEleves ?></h2>
                <p>Total Élève</p>
            </div>
            <div class="divider"></div>
            <div class="stat">
                <h2>1,893</h2>
                <p>Total Élève Payé</p>
            </div>
            <div class="divider"></div>
            <div class="stat">
                <h2>189</h2>
                <p>Total Élève Non Payé</p>
            </div>
        </div>

        <div class="search">
            <input type="text" placeholder="Recherche par matricule">
            <a href="lister_eleve.php">
                <button class="search-button">
                    <span class="icon">🔍</span>
                </button>
            </a>
        </div>
        <div class="image-container">
            <img src="/gestion-ecole/app/views/paiement/imagePaiement.png" alt="Illustration" style="max-width: 100%; height: auto;">
        </div>
        
    </div>

</body>
</html>