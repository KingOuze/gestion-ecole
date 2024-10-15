<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des employés</title>
    <link rel="stylesheet" href="/public/css/Gestion_paiement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Pour les icônes -->
    <link rel="stylesheet" href="/public/css/modifier.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../views/paiement_header.php'; ?> <!-- Assurez-vous d'ajuster le chemin -->

    <div class="content">
        <header>
            <h1>Gestion de paiements des employés</h1>
            <div class="header-actions">
                <a href="/logout" class="logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </header>

        <div class="year">
            <a href="/home" class="home"><i class="fas fa-home"></i> Accueil</a>
            <p>Année scolaire 2024-2025</p>
        </div>
        <hr class="divider">
        <div class="info">
            <div class="box">
                <a href="" class="btn-secondary">Professeur</a>
            </div>
            <div class="box">
                <a href="/app/views/paiement/suivit_paiement.php" class="btn-secondary">Suivi Paiement</a>
            </div>
            <div class="box">
                <a href="/app/views/paiement_autre.php" class="btn-secondary">Autres</a>
            </div>
        </div>

        <section class="image-section">
            <img src="/public/images/paiement.png" alt="">
        </section>
    </div>
</body>
</html>