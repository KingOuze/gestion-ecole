<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des administrateurs</title>
    <link rel="stylesheet" href="../../../public/css/modifier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <img src="Badge_Education_Badge_Logo.png" alt="Logo">
            <li><a href="#"class ="school-name">Ecole de la réussite</a></li><br><br>
            <li><a href="#">Tableau de Bord</a></li>
            <li><a href="modifier.php">Gestion administrateurs</a></li>
            <li><a href="#">Gestion des élèves</a></li>
            <li><a href="#">Gestion enseignants</a></li>
            <li><a href="#">Gestion finance</a></li>
            <li><a href="#">Gestion surveillant</a></li>
            <li><a class="active" href="#">Gestion professeur</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="header">
            <div class="search-bar">
                <input type="text" placeholder="Rechercher">
                <i class="fas fa-search"></i>
            </div>
            <button class="add-button" id="openModalBtn">
                <i class="fas fa-plus"></i> Ajouter un élève
            </button>
        </div>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php include ('C:/xmp/htdocs/gestion-ecole/app/views/ModifierEleve/get_eleve.php'); ?> 
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(telephone) {
        if (confirm("Êtes-vous sûr de vouloir archiver cet eleve ?")) {
            window.location.href = 'supprimer.php?telephone=' + telephone;
        }
    }
</script>

</body>
</html>
