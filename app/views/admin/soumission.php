<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des administrateurs</title>
    <link rel="stylesheet" href="/gestion-ecole/public/css/modifier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="Logo" class="logo">
        <h1>École de la réussite</h1>
        <nav>
            <ul>
                <li><a href="/gestion-ecole/public/index.php?action=index&role=administrateur">Tableau de Bord</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=administrateur">Gestion Administrateurs</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=eleve">Gestion des Élèves</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=surveillant">Gestion Surveillant</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=professeur">Gestion Professeur</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=enseignant">Gestion Enseignants</a></li>
                <li><a href="/gestion-ecole/public/index.php?action=liste&role=comptable">Gestion Comptables</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main content -->
    <div class="main-content">
        <div class="header">
            <div class="search-bar">
                <input type="text" placeholder="Rechercher">
                <button><i class="fas fa-search"></i></button>
            </div>
            <a href="/gestion-ecole/public/index.php?action=ajouter" class="add-button">
                <i class="fas fa-plus"></i> Ajouter 
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Adresse Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($users != NULL && count($users) > 0) {
                    foreach($users as $user) { ?>
                        <tr>
                            <td><input type='checkbox'></td>
                            <td><?php echo htmlspecialchars($user["prenom"]) ?></td>
                            <td><?php echo htmlspecialchars($user["nom"]) ?></td>
                            <td><?php echo htmlspecialchars($user["telephone"]) ?></td>
                            <td><?php echo htmlspecialchars($user["email"]) ?></td>
                            <td>
                                <?php $role = isset($user["role"]) && !empty($user["role"]) ? htmlspecialchars($user["role"]) : 'eleve'; ?>
                                <a href='/gestion-ecole/public/index.php?action=edite&role=<?= $role ?>&id=<?= htmlspecialchars($user["id"]) ?>'>
                                    <i class='fas fa-edit'></i>
                                </a>
                                <a>
                                    <i class='fas fa-trash' onclick='confirmDelete(<?php echo htmlspecialchars($user["id"]) ?>, "<?php echo htmlspecialchars($role) ?>" )'></i>
                                </a> 
                            </td>   
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='6'>Aucun utilisateur trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id, role) {
        if (confirm("Êtes-vous sûr de vouloir archiver cet " + role + " ?")) {
            window.location.href = '/gestion-ecole/public/index.php?action=archive&role=' + role + '&id=' + id;
        }
    }
</script>

</body>
</html>