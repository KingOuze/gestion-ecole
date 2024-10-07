<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Surveillant</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/public/css/surveillant.css">
</head>
<body>
<div class="sidebar">
        <div class="logo">
            <img src="logo.png" alt="Logo de l'école">
        </div>
        <h2>Ecole de la reussite</h2>
        <nav class="menu">
            <ul>
                <li><a href="/app/views/dashboard.php"><i class="fas fa-home"></i> Tableau de bord</a></li>
                <li><a href="#"><i class="fas fa-user-graduate"></i>Gestions des absences et retards</a></li>
                <li><a href="#"><i class="fas fa-user-clock"></i>Liste des professeurs</a></li>
                <li><a href="#"><i class="fas fa-clipboard-check"></i>Listes des élèves</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    </div>
    
    <div class="main-content">
        <header>
            <h1>Bienvenue</h1>
            <div class="search-bar">
                <input type="text" placeholder="Recherche par matricule">
                <button><img src="search-icon.png" alt="Recherche"></button>
            </div>
            <a href="#" class="logout">Déconnexion <i class="fas fa-sign-out-alt"></i></a>
        </header>
        
        <div class="grid-options">
            <div class="option">
                <h2>Gestion des absences et retards</h2>
                <button>Voir</button>
            </div>
            <div class="option">
                <h2>Liste des professeurs</h2>
                <button>Voir</button>
            </div>
            <div class="option">
                <h2>Liste des élèves</h2>
                <button>Voir</button>
            </div>
        </div>
    </div>
</body>
</html>
