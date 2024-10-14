<?php
require_once(' /../config/db.php');
// Récupération des données de l'administrateur
$telephone = isset($_GET['telephone']) ? htmlspecialchars($_GET['telephone']) : '';
$prenom = $nom = $email = '';

// Récupérer les informations de l'administrateur à modifier
if ($telephone) {
    $stmt = $conn->prepare("SELECT prenom, nom, email, telephone FROM administrateur WHERE telephone = ?");
    $stmt->execute([$telephone]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $prenom = htmlspecialchars($admin['prenom']);
        $nom = htmlspecialchars($admin['nom']);
        $email = htmlspecialchars($admin['email']);
        $telephone = htmlspecialchars($admin['telephone']);
    }
}

// Mise à jour de l'administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_prenom = htmlspecialchars($_POST['prenom']);
    $new_nom = htmlspecialchars($_POST['nom']);
    $new_email = htmlspecialchars($_POST['email']);
    $new_telephone = htmlspecialchars($_POST['telephone']);

    $update_stmt = $conn->prepare("UPDATE administrateur SET prenom = ?, nom = ?, email = ?, telephone = ? WHERE telephone = ?");
    if ($update_stmt->execute([$new_prenom, $new_nom, $new_email, $new_telephone, $telephone])) {
        // Redirection avec message de succès
        header('Location: soumission.php?message=Modification réussie');
        exit();
    } else {
        // Gérer l'erreur de mise à jour
        echo "Erreur lors de la mise à jour des informations.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/modifier2.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <h1>Modifier</h1>
            <div class="form-row">
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" value="<?php echo $prenom; ?>" placeholder="Entrer le prénom">
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" value="<?php echo $nom; ?>" placeholder="Entrer le nom">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="Entrer le téléphone">
                </div>
                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Entrer l'email" >
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="btn-primary">Modifier</button>
                <a href="soumission.php" class="btn-secondary">Retour</a>
            </div>
        </form>
    </div>
</body>
</html>