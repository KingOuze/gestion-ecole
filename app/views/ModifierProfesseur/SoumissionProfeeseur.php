<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Professeurs</title>
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
            <li><a href="#">Gestion administrateurs</a></li>
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
                <i class="fas fa-plus"></i> Ajouter un administrateur
            </button>
        </div>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Adresse Email</th>
                    <th>Matiere</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once('/../config/db.php');
                try {
                    $stmt = $conn->query("SELECT professeur.*, administrateur.prenom AS admin_prenom, administrateur.nom AS admin_nom, administrateur.email AS admin_email, nom_matiere AS matiere
                      FROM professeur 
                      JOIN administrateur  ON professeur.id_admin = administrateur.id_admin");
                    $rowCount = $stmt->rowCount();
                    echo "Nombre de professeurs trouvés : " . $rowCount;

                    if ($rowCount > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td><input type='checkbox'></td>";
                            echo "<td>" . htmlspecialchars($row["prenom"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["telephone"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) .  "</td>";
                            echo "<td>" . htmlspecialchars($row["matiere"]) .  "</td>";
                            echo "<td>
                            <a href='ModifierProfesseur.php?telephone=" . htmlspecialchars($row["telephone"]) . 
                               "&prenom=" . htmlspecialchars($row["prenom"]) . 
                               "&nom=" . htmlspecialchars($row["nom"]) . 
                               "&email=" . htmlspecialchars($row["email"]) .
                               "&email=" . htmlspecialchars($row["matiere"]) . "'>
                                <i class='fas fa-edit'></i>
                            </a>
                            <i class='fas fa-trash' onclick='confirmDelete(\"" . htmlspecialchars($row["telephone"]) . "\")'></i>
                          </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Aucun profeeseur trouvé</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "Erreur : " . htmlspecialchars($e->getMessage());
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(telephone) {
        if (confirm("Êtes-vous sûr de vouloir archiver ce professeur ?")) {
            window.location.href = 'supprimer.php?telephone=' + telephone;
        }
    }
</script>

</body>
</html>
