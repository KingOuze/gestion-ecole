<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Professeurs</title>
</head>
<body>

<h1>Liste des Professeurs</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Matricule</th>
            <th>Ajouter Heures</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($professeurs)): ?>
            <tr>
                <td colspan="5" style="text-align: center;">Aucun professeur trouvé.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($professeurs as $professeur): ?>
            <tr>
                <td><?php echo htmlspecialchars($professeur['id']); ?></td>
                <td><?php echo htmlspecialchars($professeur['prenom']); ?></td>
                <td><?php echo htmlspecialchars($professeur['nom']); ?></td>
                <td><?php echo htmlspecialchars($professeur['matricule']); ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="id_admin" value="<?php echo htmlspecialchars($professeur['id']); ?>">
                        <input type="number" name="heures_travaillees" placeholder="Heures" required>
                        <input type="number" name="taux_horaire" placeholder="Taux Horaire" required>
                        <button type="submit" name="attribuer_heures">Attribuer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
