<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des administrateurs</title>
    <link rel="stylesheet" href="/public/css/modifier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
    <?php if ($message): ?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="#">Ecole de la réussite</a></li>
                <li><a href="/app/views/dashboard.php">Tableau de Bord</a></li>
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
                        </div>
                        <th>Nom</th>
                        <th>Matricule</th>
                        <th>Adresse Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Inclure le fichier de configuration pour la base de données
                    require_once __DIR__ . '/../../config/db.php'; 

                    try {
                        // Requête pour récupérer les administrateurs
                        $stmt = $conn->query("SELECT prenom, nom, matricule, email FROM administrateur");
                        
                        // Vérifier si des résultats sont trouvés
                        $rowCount = $stmt->rowCount();
                        echo "Nombre d'administrateurs trouvés : " . $rowCount; // Affichage du nombre d'administrateurs

                        if ($rowCount > 0) {
                            // Affichage des données pour chaque administrateur
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td><input type='checkbox'></td>";
                                echo "<td>" . htmlspecialchars($row["prenom"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["matricule"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                echo "<td>
                                <a href='modifier.php?matricule=" . htmlspecialchars($row["matricule"]) . 
                                   "&prenom=" . htmlspecialchars($row["prenom"]) . 
                                   "&nom=" . htmlspecialchars($row["nom"]) . 
                                   "&email=" . htmlspecialchars($row["email"]) . "'>
                                    <i class='fas fa-edit'></i>
                                </a>
                                <i class='fas fa-trash' onclick='confirmDelete(\"" . htmlspecialchars($row["matricule"]) . "\")'></i>
                              </td>";
                        
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Aucun administrateur trouvé</td></tr>";
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
        function confirmDelete(matricule) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cet administrateur ?")) {
                // Logique pour supprimer l'administrateur (à implémenter)
                window.location.href = 'supprimer.php?matricule=' + matricule;
            }
        }
    </script>

    <script src="/public/js/modifier.js"></script>
</body>
</html>