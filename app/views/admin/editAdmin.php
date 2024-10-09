<?php
// Inclure les fichiers nécessaires
include_once 'C:/xmp/htdocs/gestion-ecole/config/db.php';
include_once 'C:/xmp/htdocs/gestion-ecole/app/models/Admin.php';

// Créer une instance de la base de données
$database = new Database();
$db = $database->conn;

// Initialiser la variable $admin
$admin = new Admin($db);

// Vérifier si l'ID est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $admin->id_admin = $_GET['id'];
    $admin->readOne(); // Récupérer les informations de l'administrateur

    // Vérifier si les données sont récupérées
    if (!$admin->nom) {
        echo "Aucun administrateur trouvé avec cet ID.";
        exit;
    }
} else {
    echo "ID non spécifié.";
    exit;
}

// Traiter le formulaire de mise à jour
if (isset($_POST['update'])) {
    // Assigner les nouvelles valeurs
    $admin->nom = $_POST['nom'];
    $admin->prenom = $_POST['prenom'];
    $admin->email = $_POST['email'];
    $admin->telephone = $_POST['telephone'];
    $admin->mot_de_passe = $_POST['mot_de_passe'];
   

    // Effectuer la mise à jour
    if ($admin->update()) {
        echo "Mise à jour réussie !";
        header("Location: listAdmin.php"); // Rediriger vers la liste des administrateurs
        exit;
    } else {
        echo "Erreur lors de la mise à jour de l'administrateur.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Administrateur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/modifier2.css">
</head>
<body>
    <div class="container">
        <h1>Modifier Administrateur</h1>
        <form action="" method="post">
            <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($admin->id_admin); ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" value="<?php echo htmlspecialchars($admin->nom); ?>" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom:</label>
                    <input type="text" name="prenom" value="<?php echo htmlspecialchars($admin->prenom); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($admin->email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone:</label>
                    <input type="text" name="telephone" value="<?php echo htmlspecialchars($admin->telephone); ?>" required>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe:</label>
                    <input type="text" name="mot_de_passe" value="<?php echo htmlspecialchars($admin->mot_de_passe); ?>" required>
                </div>
            </div>

            <div class="button-group">
                <input type="submit" value="Modifier" name="update" class="btn-primary">
                <a href="listAdmin.php" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>

