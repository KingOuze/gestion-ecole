<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Enseignant</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/gestion-ecole/public/css/enseignant.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
        <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo" class="logo">
        </div>
        <h2>Ecole de la reussite</h2>
        <nav class="menu">
            <ul>
                <li><a href="/gestion-ecole/app/views/dashboard.php"><i class="fas fa-home"></i> Tableau de bord</a></li>
                <li><a href="#"><i class="fas fa-user-graduate"></i> Listes des classes</a></li>
                <li><a href="#"><i class="fas fa-user-clock"></i> Gestion des absences</a></li>
                <li><a href="#"><i class="fas fa-clipboard-check"></i> Saisie des évaluations</a></li>
                <li><a href="#"><i class="fas fa-book"></i> Notes composition</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="main-content">
        <header>
            <h1>Bienvenue</h1>
            <div class="search-bar">
                <input type="text" placeholder="Recherche de l'élève par matricule">
                <button><img src="search-icon.png" alt="Search"></button>
            </div>
            <a href="/gestion-ecole/public/index.php?" class="add-student-btn">Ajouter Élève</a>
        </header>
        
        <div class="grid-options">
            <div class="option">
                <h2>Listes des classes</h2>
                <button>Voir</button>
            </div>
            <div class="option">
                <h2>Gestion des absences et des retards</h2>
                <button>Voir</button>
            </div>
            <div class="option">
                <h2>Saisie des évaluations</h2>
                <button>Voir</button>
            </div>
            <div class="option">
                <h2>Notes composition</h2>
                <button>Voir</button>
            </div>
        </div>
    </div>
</body>
</html>
