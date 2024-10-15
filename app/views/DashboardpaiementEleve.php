<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de l'École</title>
    <link rel="stylesheet" href="/gestion-ecole/public/css/paiement.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="/gestion-ecole/public/images/Badge_Education_Badge_Logo.png" alt="Logo">
            <h2 class="school-name">Ecole de la réussite</h2>
        </div>
        <ul>
            <li><a href="#">Tableau de Bord</a></li>
            <li><a href="#">Gestion Finance</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center py-3">
                <h1>Gestion du paiement des élèves</h1>
                <a href="#" class="deconnexion-link">
                    <span>Déconnexion</span>
                    <img src="/gestion-ecole/public/images/iconeDeconnexion.png" alt="Déconnexion" class="deconnexion-icon">
                </a>
            </div>

            <div class="header">
                <div class="header-content">
                    <div class="header-left">
                        <img src="/gestion-ecole/public/images/iconeMaison.png" alt="Accueil" class="home-icon"> <!-- Remplacez par le chemin de votre icône -->
                        <span>Accueil</span>
                    </div>
                    <div class="header-right">
                        <span>Année scolaire 2024-2025</span>
                    </div>
                </div>
                <div class="divider"></div>
            </div>

            <div class="flex-blocks">
                <div class="block">Inscription</div>
                <div class="block">
                    <a href="/gestion-ecole/app/hawa.php" style="text-decoration: none; color: inherit;">Mensualité</a>
                </div>
            </div>
        </div>
        <div class="image-container">
            <img src="/gestion-ecole/public/images/imagePaiement.png" alt="Image de Paiement" class="image-paiement">
        </div>
    </div>
</body>
</html>