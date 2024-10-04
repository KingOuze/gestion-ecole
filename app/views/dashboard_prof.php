<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - École de la Réussite</title>
    <link rel="stylesheet" href="/public/css/dashboard_prof.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="/public/images/connexion_image/Badge_Education_Badge_Logo-removebg-preview.png" alt="École de la Réussite">
            <h2>École de la réussite</h2>
        </div>
        <ul>
            <li><i class="fas fa-home"></i> Accueil</li>
            <li><i class="fas fa-list-alt"></i> Listes des classes</li>
            <li><i class="fas fa-calendar-check"></i> Gestion des absences</li>
            <li><i class="fas fa-pencil-alt"></i> Saisie des évaluations</li>
            <li><i class="fas fa-book"></i> Notes composition</li>
            <li><i class="fas fa-sign-out-alt"></i> Déconnexion</li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Bienvenue</h1>
            <div class="search-bar">
                <input type="text" placeholder="Recherche de l'élève par matricule">
                <button><i class="fas fa-search"></i></button>
            </div>
        </div>

        <div class="grid-container">
            <div class="grid-item">
                <h3>Listes des classes</h3>
                <button class="btn">Voir</button>
            </div>
            <div class="grid-item">
                <h3>Gestion des absences et des retards</h3>
                <button class="btn">Voir</button>
            </div>
            <div class="grid-item">
                <h3>Saisie des évaluations</h3>
                <button class="btn">Voir</button>
            </div>
            <div class="grid-item">
                <h3>Notes composition</h3>
                <button class="btn">Voir</button>
            </div>
        </div>
    </div>
</body>
</html>
