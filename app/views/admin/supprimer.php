<?php
require_once('C:/xmp/htdocs/gestion-ecole/config/db.php'); // Assurez-vous que la connexion est établie

if (isset($_GET['matricule'])) {
    $matricule = htmlspecialchars($_GET['matricule']);

    // Récupérer les données de l'administrateur à archiver
    $select_stmt = $conn->prepare("SELECT * FROM administrateur WHERE matricule = ?");
    $select_stmt->execute([$matricule]);
    $admin = $select_stmt->fetch();

    if ($admin) {
        // Archiver l'administrateur
        $archive_stmt = $conn->prepare("INSERT INTO administrateur_archive (matricule, prenom, nom, telephone, email) VALUES (?, ?, ?, ?, ?)");
        if ($archive_stmt->execute([$admin['matricule'], $admin['prenom'], $admin['nom'], $admin['telephone'], $admin['email']])) {
            // Supprimer l'administrateur de la table principale
            $delete_stmt = $conn->prepare("DELETE FROM administrateur WHERE matricule = ?");
            $delete_stmt->execute([$matricule]);

            header('Location: soumission.php?message=Archivage réussi');
            exit();
        } else {
            echo "Erreur lors de l'archivage des informations.";
        }
    } else {
        echo "Administrateur non trouvé.";
    }
} else {
    echo "Matricule manquant.";
}
