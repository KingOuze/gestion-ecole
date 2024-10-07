<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard du Personnel, des Étudiants et des Administrateurs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <img src="../public/images/logo.png" alt="Logo" class="logo">
            <h1>École de la réussite</h1>
            <nav>
                <ul>
                    <li><a href="?page=dashboard">Tableau de Bord</a></li>
                    <li><a href="?page=administrators">Gestion Administrateurs</a></li>
                    <li><a href="?page=students">Gestion des Élèves</a></li>
                    
                    <li><a href="?page=supervisors">Gestion Surveillant</a></li>
                    <li><a href="?page=professors">Gestion Professeur</a></li>
                    <li><a href="?page=enseignants">Gestion Enseignants</a></li>
                    <li><a href="?page=comptables">Gestion Comptables</a></li>
                </ul>
            </nav>
        </aside>

        <main class="dashboard">
            <header class="dashboard-header">
                <div class="search-container">
                    <input type="text" placeholder="Recherche..." class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <button class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </header>

            <div class="cards-container">
                <div class="card">
                    <i class="icon students fas fa-user-graduate"></i>
                    <h2>Élèves</h2>
                    <p><?php echo $data['eleves']; ?></p>
                </div>
                <div class="card">
                    <i class="icon professors fas fa-chalkboard-teacher"></i>
                    <h2>Professeurs</h2>
                    <p><?php echo $data['professeurs']; ?></p>
                </div>
                <div class="card">
                    <i class="icon teachers fas fa-book"></i>
                    <h2>Enseignants</h2>
                    <p><?php echo $data['enseignants']; ?></p>
                </div>
                <div class="card">
                    <i class="icon accountants fas fa-calculator"></i>
                    <h2>Comptables</h2>
                    <p><?php echo $data['comptables']; ?></p>
                </div>
                <div class="card">
                    <i class="icon supervisors fas fa-user-check"></i>
                    <h2>Surveillants</h2>
                    <p><?php echo $data['surveillants']; ?></p>
                </div>
                <div class="card">
                    <i class="icon administrators fas fa-user-tie"></i>
                    <h2>Administrateurs</h2>
                    <p><?php echo $data['administrateurs']; ?></p>
                </div>
            </div>

            <?php
            // Connexion à la base de données
            $host = 'localhost'; // ou l'adresse de votre serveur
            $db = 'gestion-ecole';
            $user = 'root';
            $pass = '';

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erreur : " . htmlspecialchars($e->getMessage());
            }

            // Récupérer les données
            $page = $_GET['page'] ?? 'dashboard'; // Page par défaut

            switch ($page) {
                case 'administrators':
                    $stmt = $pdo->query("SELECT * FROM administrateur");
                    break;
                case 'students':
                    $stmt = $pdo->query("SELECT * FROM eleve");
                    break;
                case 'finance':
                    $stmt = $pdo->query("SELECT * FROM administrateur WHERE role='comptable'");
                    break;
                case 'supervisors':
                    $stmt = $pdo->query("SELECT * FROM administrateur WHERE role='surveillant'");
                    break;
                case 'professors':
                    $stmt = $pdo->query("SELECT * FROM administrateur WHERE role='professeur'");
                    break;
                case 'enseignants':
                    $stmt = $pdo->query("SELECT * FROM administrateur WHERE role='enseignant'");
                    break;
                case 'comptables':
                    $stmt = $pdo->query("SELECT * FROM administrateur WHERE role='comptable'");
                    break;
                default:
                    $stmt = null; // Aucune requête
                    break;
            }

            $data = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : []; // Récupérer les données
            ?>

            <!-- Affichage des données -->
            <div class="data-container">
                <h2><?php echo ucfirst($page); ?></h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($page === 'students'): ?>
                            <?php foreach ($data as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_eleve']); ?></td> <!-- ID pour les élèves -->
                                    <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php elseif (in_array($page, ['administrators', 'supervisors', 'professors', 'enseignants', 'comptables'])): ?>
                            <?php foreach ($data as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_admin']); ?></td> <!-- ID pour les administrateurs, etc. -->
                                    <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Aucune donnée à afficher.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>