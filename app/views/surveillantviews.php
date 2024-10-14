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
    <aside class="sidebar">
        <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo" class="logo">
        <h1>École de la réussite</h1>
        <nav>
            <ul>
                <li><a href="/public/index.php?action=acceuil">Tableau de Bord</a></li>
                <li><a href="/public/index.php?action=liste&role=administrateur">Gestion Administrateurs</a></li>
                <li><a href="/public/index.php?action=liste&role=eleve">Gestion des Élèves</a></li>
                <li><a href="/public/index.php?action=liste&role=surveillant">Gestion Surveillant</a></li>
                <li><a href="/public/index.php?action=liste&role=professeur">Gestion Professeur</a></li>
                <li><a href="/public/index.php?action=liste&role=enseignant">Gestion Enseignants</a></li>
                <li><a href="/public/index.php?action=liste&role=comptable">Gestion Comptables</a></li>
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
            <button class="add-button" id="openModalBtn">
                <i class="fas fa-plus"></i> <a href="/public/index.php?">Ajouter un Surveillant</a>
            </button>
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
