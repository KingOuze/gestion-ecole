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
    <title>Dashboard du Personnel, des Étudiants et des Administrateurs</title>
    <link rel="stylesheet" href="/public/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
       <aside class="sidebar">
            <img src="/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo" class="logo">
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
        <main class="dashboard">
            <header class="dashboard-header">
                <div class="search-container">
                    <input type="text" placeholder="Recherche..." class="search-bar" aria-label="Recherche">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <button class="logout-button">
                    <a href="/public/index.php?" class="logout-link">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </button>
            </header>

            <div class="cards-container">
                <div class="card">
                    <i class="icon students fas fa-user-graduate"></i>
                    <h2>Élèves</h2>
                    <p><?php echo htmlspecialchars($nbEleve); ?></p>
                </div>
                <div class="card">
                    <i class="icon professors fas fa-chalkboard-teacher"></i>
                    <h2>Professeurs</h2>
                    <p><?php echo htmlspecialchars($nbprofesseur); ?></p>
                </div>
                <div class="card">
                    <i class="icon teachers fas fa-book"></i>
                    <h2>Enseignants</h2>
                    <p><?php echo htmlspecialchars($nbenseignant); ?></p>
                </div>
                <div class="card">
                    <i class="icon accountants fas fa-calculator"></i>
                    <h2>Comptables</h2>
                    <p><?php echo htmlspecialchars($nbComp); ?></p>
                </div>
                <div class="card">
                    <i class="icon supervisors fas fa-user-check"></i>
                    <h2>Surveillants</h2>
                    <p><?php echo htmlspecialchars($nbSurvei); ?></p>
                </div>
                <div class="card">
                    <i class="icon administrators fas fa-user-tie"></i>
                    <h2>Administrateurs</h2>
                    <p><?php echo htmlspecialchars($nbAdmin); ?></p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>