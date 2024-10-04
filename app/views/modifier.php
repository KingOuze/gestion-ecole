<?php
// Inclure le fichier de configuration pour la base de données
require_once __DIR__ . '/../../config/db.php'; 

// Variable pour le message de succès
$message = '';

// Récupération des données de l'administrateur
$matricule = isset($_GET['matricule']) ? htmlspecialchars($_GET['matricule']) : '';
$prenom = $nom = $email = $role = '';

// Récupérer les informations de l'administrateur à modifier
if ($matricule) {
    $stmt = $conn->prepare("SELECT prenom, nom, email, role FROM administrateur WHERE matricule = ?");
    if ($stmt->execute([$matricule])) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $prenom = htmlspecialchars($admin['prenom']);
            $nom = htmlspecialchars($admin['nom']);
            $email = htmlspecialchars($admin['email']);
            $role = htmlspecialchars($admin['role']);
        } else {
            echo "Aucun administrateur trouvé avec ce matricule.";
        }
    } else {
        echo "Erreur lors de la récupération des données.";
    }
}

// Mise à jour de l'administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_prenom = htmlspecialchars($_POST['prenom']);
    $new_nom = htmlspecialchars($_POST['nom']);
    $new_email = htmlspecialchars($_POST['email']);
    $new_role = htmlspecialchars($_POST['role']);
    $new_password = !empty($_POST['mot_de_passe']) ? password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT) : null;

    try {
        // Construction de la requête SQL en fonction de la présence d'un nouveau mot de passe
        if ($new_password) {
            $update_stmt = $conn->prepare("UPDATE administrateur SET prenom = ?, nom = ?, email = ?, role = ?, mot_de_passe = ? WHERE matricule = ?");
            $success = $update_stmt->execute([$new_prenom, $new_nom, $new_email, $new_role, $new_password, $matricule]);
        } else {
            $update_stmt = $conn->prepare("UPDATE administrateur SET prenom = ?, nom = ?, email = ?, role = ? WHERE matricule = ?");
            $success = $update_stmt->execute([$new_prenom, $new_nom, $new_email, $new_role, $matricule]);
        }

        if ($success) {
            // Stocker le message de succès
            $message = "Modification réussie !";
        } else {
            echo "Erreur lors de la mise à jour.";
        }
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
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
    <link rel="stylesheet" href="/public/css/modifier2.css"> <!-- Lien vers votre fichier CSS -->
    <style>
        /* Style pour le message de succès */
        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Affichage du message de succès s'il existe -->
        <?php if ($message): ?>
            <div class="success-message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <h1>Modifier</h1>
            <div class="form-row">
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" value="<?php echo $prenom; ?>" placeholder="Entrer le prénom" required>
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" value="<?php echo $nom; ?>" placeholder="Entrer le nom" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="matricule">Matricule</label>
                    <input type="text" name="matricule" value="<?php echo $matricule; ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Entrer l'email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="role">Rôle</label>
                    <select name="role" required>
                        <option value="admin" <?php echo $role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="super_admin" <?php echo $role == 'super_admin' ? 'selected' : ''; ?>>Super Admin</option>
                        <option value="enseignant" <?php echo $role == 'enseignant' ? 'selected' : ''; ?>>Enseignant</option>
                        <option value="professeur" <?php echo $role == 'professeur' ? 'selected' : ''; ?>>Professeur</option>
                        <option value="surveillant" <?php echo $role == 'surveillant' ? 'selected' : ''; ?>>Surveillant</option>
                        <option value="comptable" <?php echo $role == 'comptable' ? 'selected' : ''; ?>>Comptable</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Nouveau Mot de Passe (laisser vide si inchangé)</label>
                    <input type="password" name="mot_de_passe" placeholder="Entrer un nouveau mot de passe">
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
