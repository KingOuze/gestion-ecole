<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Professeurs</title>
    <link rel="stylesheet" href="/public/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="?action=eleve"><i class="fas fa-user-graduate"></i> Élèves</a></li>
            <li><a href="?action=administrateur"><i class="fas fa-user-shield"></i> Administrateurs</a></li>
            <li><a href="?action=surveillant"><i class="fas fa-user-check"></i> Surveillants</a></li>
            <li><a href="?action=comptable"><i class="fas fa-money-bill-wave"></i> Comptables</a></li>
            <li><a href="?action=professeur"><i class="fas fa-chalkboard-teacher"></i> Professeurs</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Liste des Professeurs</h1>
        <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($professeurs as $professeur): ?>
            <tr>
                <td><?= $professeur['id'] ?? 'N/A' ?></td>
                <td><?= $professeur['nom'] ?? 'N/A' ?></td>
                <td><?= $professeur['prenom'] ?? 'N/A' ?></td>
                <td><?= $professeur['email'] ?? 'N/A' ?></td>
                <td>
                    <a href="#">Editer</a> | <a href="#">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    </div>
</body>
</html>