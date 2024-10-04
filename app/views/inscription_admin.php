<!-- views/inscription_admin.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Administrateur</title>
    <link rel="stylesheet" href="/public/css/inscription_admin.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body>
    <div class="container">
        <h1>Inscription administrateur</h1>
        <form method="POST" action="">
            <input type="text" name="nom" placeholder="Entrer le nom" required>
            <input type="text" name="prenom" placeholder="Entrer le prénom" required>
            <input type="email" name="email" placeholder="Entrer l'email" required>
            <input type="number" name="telephone" placeholder="Entrer le numéro de téléphone" required>
            <input type="password" name="mot_de_passe" placeholder="Entrer le mot de passe" required>
            <select name="role" required>
                <option value="">-- Sélectionner le rôle --</option>
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
                <option value="enseignant">Enseignant</option>
                <option value="professeur">Professeur</option>
                <option value="comptable">Comptable</option>
                <option value="surveillant">Surveillant</option>
            </select>
            <button type="submit">Inscrire</button>
        </form>
    </div>
</body>
</html>