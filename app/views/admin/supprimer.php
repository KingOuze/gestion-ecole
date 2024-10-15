<?php
require_once('C:/xmp/htdocs/gestion-ecole/config/db.php'); // Assurez-vous que la connexion est établie

if (isset($_GET['id_admin'])) {
    $id_admin = htmlspecialchars($_GET['id_admin']);

    // Récupérer les données de l'administrateur à archiver
    $select_stmt = $conn->prepare("SELECT * FROM administrateur WHERE id_admin = ?");
    $select_stmt->execute([$id_admin]);
    $admin = $select_stmt->fetch();

    if ($admin) {
        // Archiver l'administrateur
        $archive_stmt = $conn->prepare("INSERT INTO administrateur (id_admin, prenom, nom, telephone, email) VALUES (?, ?, ?, ?, ?)");
        if ($archive_stmt->execute([$admin['id_admin'], $admin['prenom'], $admin['nom'], $admin['telephone'], $admin['email']])) {
            // Supprimer l'administrateur de la table principale
            $delete_stmt = $conn->prepare("DELETE FROM administrateur WHERE id_admin = ?");
            $delete_stmt->execute([$id_admin]);

            header('Location: soumission.php?message=Archivage réussi');
            exit();
        } else {
            echo "Erreur lors de l'archivage des informations.";
        }
    } else {
        echo "Administrateur non trouvé.";
    }
} else {
    echo "ID administrateur manquant.";
}
