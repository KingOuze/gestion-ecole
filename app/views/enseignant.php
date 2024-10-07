<!-- views/enseignants.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Enseignants</title>
    <link rel="stylesheet" href="../public/css/styles.css">
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <h2>École de la réussite</h2>
        <ul>
            <li><a href="index.php?page=dashboard">Tableau de Bord</a></li>
            <li><a href="index.php?page=eleves">Gestion des Élèves</a></li>
            <li><a href="index.php?page=professeurs">Gestion des Professeurs</a></li>
            <li><a href="index.php?page=surveillants">Gestion des Surveillants</a></li>
            <li><a href="index.php?page=comptables">Gestion des Comptables</a></li>
            <li><a href="index.php?page=enseignants">Gestion des Enseignants</a></li>
            <li><a href="index.php?page=administrateurs">Gestion des Administrateurs</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <h1>Liste des Enseignants</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Spécialité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enseignants as $enseignant): ?>
                    <tr>
                        <td><?php echo $enseignant['id']; ?></td>
                        <td><?php echo $enseignant['nom']; ?></td>
                        <td><?php echo $enseignant['specialite']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="index.php?page=dashboard">Retour au tableau de bord</a>
    </main>
</div>

</body>
</html>