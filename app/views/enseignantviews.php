<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Enseignant</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1pFkw/hD3f9lg3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/gestion-ecole/public/css/enseignant.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo-removebg-preview.png" alt="Logo de l'école">
        </div>
        <h2>Ecole de la reussite</h2>
        <nav class="menu">
            <ul>
                <li><a href="/app/views/dashboard.php"><i class="fas fa-home"></i> Tableau de bord</a></li>
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
                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>

            </div>
            <a href="#" class="logout">Déconnexion</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93JVdK3C8BFqnS81KUJ3R5tpYp6wzp6qfFPk8txJqxBcnfA/tudsZiPoFUdC/f" crossorigin="anonymous"></script>

</body>
</html>
