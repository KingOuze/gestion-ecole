<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Exemple d'initialisation de $users, assurez-vous qu'elle est définie dans votre logique
//$users = []; // Remplacez ceci par votre logique de récupération des utilisateurs
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Administrateurs</title>
    <link rel="stylesheet" href="/gestion-ecole/public/css/modifier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            <button class="add-button" id="openModalBtn" >
            <i class="fas fa-plus" ></i> <a href="/gestion-ecole/public/index.php?action=ajouter">Ajouter</a>
            
           
            </button>
        </div>

        <table class="table">
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
                    <?php 
                    $role = isset($user["role"]) && !empty($user["role"]) ? htmlspecialchars($user["role"]) : 'eleve'; 
                    ?>
                    <a href='/gestion-ecole/public/index.php?action=edite&role=<?= $role ?>&id=<?= htmlspecialchars($user["id"]) ?>'>
                        <i class='fas fa-edit'></i>
                    </a>
                    <a>
                        <i class='fas fa-trash delete-user' 
                           data-id='<?php echo htmlspecialchars($user["id"]); ?>' 
                           data-prenom='<?php echo htmlspecialchars($user["prenom"]); ?>' 
                           data-nom='<?php echo htmlspecialchars($user["nom"]); ?>' 
                           data-telephone='<?php echo htmlspecialchars($user["telephone"]); ?>' 
                           data-email='<?php echo htmlspecialchars($user["email"]); ?>'
                        >
                        </i>
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
        
    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmation d'Archivage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir archiver cet administrateur ?</p>
                    <div id="userInfo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmArchive">Oui, archiver</button>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>

        let userId;
        let userRole = '<?= $role?>';

        $(document).ready(function() {
            $('.delete-user').on('click', function() {
                userId = $(this).data('id');
                const prenom = $(this).data('prenom');
                const nom = $(this).data('nom');
                const email = $(this).data('email');
                const telephone = $(this).data('telephone');
                console.log(userRole);
                const userInfo = `ID: ${userId}<br>Prénom: ${prenom}<br>Nom: ${nom}<br>Email: ${email}<br>Téléphone: ${telephone}`;
                
                $('#userInfo').html(userInfo);
                $('#confirmModal').modal('show');
            });

            $('#confirmArchive').on('click', function() {
                // Effectuer une requête AJAX pour archiver l'utilisateur
                $.ajax({
                    type: 'POST',
                    url: '/gestion-ecole/public/index.php?action=archive&role=' + userRole,
                    data: { id: userId }, // Ajout de l'ID à la requête
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Réactualiser la page ou rediriger
                            window.location.href = '/gestion-ecole/public/index.php?action=liste&role=' + userRole;
                            console.log("success");
                        } else {
                            alert('Erreur: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Une erreur s\'est produite : ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>