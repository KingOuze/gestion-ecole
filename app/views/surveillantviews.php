<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Surveillant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/gestion-ecole/public/css/surveillant.css">
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
            <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo" class="logo">
            <h1>École de la réussite</h1>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="/gestion-ecole/public/index.php?action=acceuil"><i class="fas fa-tachometer-alt"></i> Tableau de Bord</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=administrateur"><i class="fas fa-users-cog"></i> Gestion Administrateurs</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=eleve"><i class="fas fa-user-graduate"></i> Gestion des Élèves</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=surveillant"><i class="fas fa-user-shield"></i> Gestion Surveillant</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=professeur"><i class="fas fa-chalkboard-teacher"></i> Gestion Professeur</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=enseignant"><i class="fas fa-book-open"></i> Gestion Enseignants</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=comptable"><i class="fas fa-money-bill-wave"></i> Gestion Comptables</a></li>
            </ul>
        </nav>
    </aside>
    
    <div class="main-content">
        <header>
            <h1>Bienvenue</h1>
            <div class="search-bar">
                <input type="text" placeholder="Recherche par matricule">
                <button><i class="fas fa-search search-icon"></i></button>
            </div>
            <div class="logout">
                <a href="/gestion-ecole/public/index.php?">Déconnexion <i class="fas fa-sign-out-alt"></i></a>
            </div>
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