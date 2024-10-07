<?php
// dashboard.php

// Activer l'affichage des erreurs (optionnel, à utiliser seulement en développement)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Récupération des statistiques
$eleves_secondaire = $pdo->query("SELECT COUNT(*) FROM eleve")->fetchColumn();
$professeurs = $pdo->query("SELECT COUNT(*) FROM administrateur WHERE role='professeur'")->fetchColumn();
$enseignants = $pdo->query("SELECT COUNT(*) FROM administrateur WHERE role='enseignant'")->fetchColumn();
$surveillants = $pdo->query("SELECT COUNT(*) FROM administrateur WHERE role='surveillant'")->fetchColumn();
$administrateurs = $pdo->query("SELECT COUNT(*) FROM administrateur")->fetchColumn();

// Affichage
ob_start(); // Démarre la mise en mémoire tampon de sortie
?>
<h2>Bienvenue sur le tableau de bord</h2>
<div class="dashboard-container">
    <div class="dashboard-card card-eleves"><h5><i class="bi bi-person-fill"></i> Élèves</h5><p><?php echo htmlspecialchars($eleves_secondaire); ?></p></div>
    <div class="dashboard-card card-professeurs"><h5><i class="bi bi-person-check-fill"></i> Professeurs</h5><p><?php echo htmlspecialchars($professeurs); ?></p></div>
    <div class="dashboard-card card-enseignants"><h5><i class="bi bi-person-badge-fill"></i> Enseignants</h5><p><?php echo htmlspecialchars($enseignants); ?></p></div>
    <div class="dashboard-card card-surveillants"><h5><i class="bi bi-person-fill"></i> Surveillants</h5><p><?php echo htmlspecialchars($surveillants); ?></p></div>
    <div class="dashboard-card card-administrateurs"><h5><i class="bi bi-person-lines-fill"></i> Administrateurs</h5><p><?php echo htmlspecialchars($administrateurs); ?></p></div>
</div>
<?php
$content = ob_get_clean(); // Récupère le contenu mis en mémoire tampon
echo $content; // Affiche le contenu
?>