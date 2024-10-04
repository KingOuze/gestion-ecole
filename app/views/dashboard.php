<!-- views/dashboard.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Bootstrap CSS pour l'embellissement -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- FullCalendar pour le calendrier -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>

    <!-- Votre CSS personnalisé -->
    <link rel="stylesheet" href="/public/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <nav class="sidebar">
            <ul>
            <div class="logo">
                    <img src="/public/images/connexion_image/Badge_Education_Badge_Logo-removebg-preview.png" alt="Logo" style="width: 250px; height: auto;">
                </div>
                <li><a href="/app/views/dashboard.php"><i class="fas fa-home"></i> Tableau de bord</a></li>
                <li><a href="/app/views/soumission.php"><i class="fas fa-user-shield"></i> Gestion des administrateurs</a></li>
                <li><a href="/app/views/dashboard_prof.php"><i class="fas fa-users"></i> Gestion des élèves</a></li>
                <li><a href="employer.html"><i class="fas fa-briefcase"></i> Gestion des employés</a></li>
                <li><a href="comptabilite.html"><i class="fas fa-calculator"></i> Comptabilité</a></li>
                <li><a href="emplois.html"><i class="fas fa-calendar-alt"></i> Gestion des emplois du temps</a></li>
                <li><a href="examens.html"><i class="fas fa-pencil-alt"></i> Gestion des examens et devoirs</a></li>
            
            </ul>
        </nav>

        <div class="main-content">
            <header class="header d-flex justify-content-between align-items-center">
            <div class="admin-info d-flex align-items-center">
                    <i class="fas fa-user-circle fa-2x"></i>
                    <span class="ml-2"><?= $user['prenom'] . ' ' . $user['nom'] ?></span>
                    <span class="ml-2"><?= $user['role'] ?></span>
                </div>
                <div class="search-container">
                    <input type="text" class="form-control" placeholder="Rechercher">
                    <button class="search-button"><i class="fas fa-search"></i></button>
                </div>
                <div class="logout">
                    <a href="/app/views/connexion/connexion.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </div>
            </header>

            <!-- Section des statistiques -->
            <section class="stats d-flex justify-content-between flex-wrap">
                <div class="stat-card">
                    <i class="fas fa-school"></i>
                    <p>Total Élèves Primaire</p>
                    <h2><?= $totalElevesPrimaire ?></h2>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-graduate"></i>
                    <p>Total Élèves Secondaire</p>
                    <h2><?= $totalElevesSecondaire ?></h2>
                </div>
                <div class="stat-card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <p>Professeurs</p>
                    <h2><?= $totalProfesseurs ?></h2>
                </div>
                <div class="stat-card">
                    <i class="fas fa-briefcase"></i>
                    <p>Employés</p>
                    <h2><?= $totalEmployes ?></h2>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-tie"></i>
                    <p>Administrateurs</p>
                    <h2><?= $totalAdmins ?></h2>
                </div>
                <div class="stat-card">
                    <i class="fas fa-calculator"></i>
                    <p>Comptables</p>
                    <h2><?= $totalComptables ?></h2>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-check"></i>
                    <p>Surveillants</p>
                    <h2><?= $totalSurveillants ?></h2>
                </div>
            </section>

            <!-- Section du calendrier -->
            <section class="calendar-exams mt-4">
                <h2>Calendrier des examens</h2>
                <div id="calendar"></div>
            </section>

           
        </div>
    </div>
    <script src="/public/js/dashboard.js"></script>
</body>
</html>
