<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gestion-ecole/public/css/style.css">
    <title>Ajouter Salaire d'un Professeur</title>
</head>
<body>

<div class="form-container">
    <h1>Ajouter Salaire d'un Professeur</h1>
    <form method="POST" action="index.php">
        <label for="matricule">Matricule :</label>
        <input type="text" id="matricule" name="matricule" required placeholder="Entrez le matricule du professeur" />

        <label for="taux_horaire">Taux Horaire :</label>
        <input type="number" id="taux_horaire" name="taux_horaire" required placeholder="Entrez le taux horaire" step="0.01" />

        <label for="heures_travaillees">Heures Travaillées :</label>
        <input type="number" id="heures_travaillees" name="heures_travaillees" required placeholder="Entrez le nombre d'heures travaillées" />

        <label for="mois">Mois :</label>
        <input type="month" id="mois" name="mois" required />

        <input type="submit" name="ajouter_salaire" value="Ajouter Salaire" />
    </form>
</div>

</body>
</html>
