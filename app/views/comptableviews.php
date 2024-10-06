<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface de Paiement</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/public/css/comptable.css">
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
                <li><a href="#"><i class="fas fa-user-graduate"></i> Paiements Élèves</a></li>
                <li><a href="#"><i class="fas fa-user-tie"></i> Paiements Employés</a></li>
                <li><a href="#"><i class="fas fa-chalkboard-teacher"></i> Paiements Professeurs</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Paramètres</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="main-content">
        <header>
            <h1>Bienvenue</h1>
            <div class="search-bar">
                <input type="text" placeholder="Recherche par matricule">
                <button><img src="search-icon.png" alt="Search"></button>
            </div>
            <a href="#" class="logout">Déconnexion</a>
        </header>
        
        <div class="payment-options">
            <div class="option">
                <h2>Paiement Élèves</h2>
                <p>Montants totaux payés et restants pour les frais de scolarité.</p>
                <button>Voir</button>
            </div>
            <div class="option">
                <h2>Paiement employés</h2>
                <p>Liste des paiements effectués aux employés (dates, montants, employés concernés).</p>
                <button>Voir</button>
            </div>
            <div class="option">
                <h2>Paiement Professeur</h2>
                <p>Liste des paiements effectués des professeurs.</p>
                <button>Voir</button>
            </div>
        </div>
    </div>
</body>
</html>
