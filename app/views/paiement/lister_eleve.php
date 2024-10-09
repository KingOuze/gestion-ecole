<?php
// Connexion à la base de données avec PDO
$host = 'localhost';
$db   = 'gestion-ecole';
$user = 'root'; // Remplace par ton nom d'utilisateur
$pass = '';     // Remplace par ton mot de passe

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$matricule = '';
$eleveInfo = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $matricule = $_POST['matricule'];

    // Préparation de la requête pour récupérer les informations de l'élève
    $stmt = $conn->prepare("SELECT * FROM eleve WHERE matricule = :matricule");
    $stmt->bindParam(':matricule', $matricule);
    $stmt->execute();

    // Récupération des données
    $eleveInfo = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Paiements des Élèves</title>
    <link rel="stylesheet" href="lister.css">
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <img src="Badge_Education_Badge_Logo.png" alt="Logo">
            <h2 class="school-name">Ecole de la réussite</h2>
        </div>
        <ul>
            <li><a href="#">Tableau de Bord</a></li>
            <li><a href="#">Gestion Finance</a></li>
        </ul>
    </div>

    <div class="listecontainer">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <p class="centered-paragraph">Paiement Mensualité</p>
                <form method="post" class="search">
                    <input type="text" name="matricule" placeholder="Recherche par matricule" required value="<?php echo htmlspecialchars($matricule); ?>">
                    <button type="submit" name="search" class="search-button1">
                        <span class="icon">🔍</span>
                    </button>
                </form>
                <a href="#" class="deconnexion-link">
                    <span>Déconnexion</span>
                    <img src="iconeDeconnexion.png" alt="Déconnexion" class="deconnexion-icon">
                </a>
            </div>
        </div>

        <div class="container1">
            <p id="special-paragraph">Informations de l'eleve</p>
            <?php if (!empty($eleveInfo)): ?>
                <h2></h2>
                <table border="1" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Niveau</th>
                            <th>Mois</th> <!-- Colonne pour le mois -->
                            <th>Montant</th> <!-- Nouvelle colonne pour le montant -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($eleveInfo['matricule']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['nom']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['classe']); ?></td> <!-- Remplace par le bon champ -->
                            <td><?php echo htmlspecialchars($eleveInfo['niveau']); ?></td> <!-- Remplace par le bon champ -->
                            <td>
                                <select name="mois" class="mois-select">
                                    <option value="octobre">Octobre</option>
                                    <option value="novembre">Novembre</option>
                                    <option value="decembre">Décembre</option>
                                    <option value="janvier">Janvier</option>
                                    <option value="fevrier">Février</option>
                                    <option value="mars">Mars</option>
                                    <option value="avril">Avril</option>
                                    <option value="mai">Mai</option>
                                    <option value="juin">Juin</option>
                                    <option value="juillet">Juillet</option>
                                </select>
                            </td>
                            <td>
                                <select name="montant" class="montant-select">
                                    <option value="7500f">7500 F</option>
                                    <option value="10000f">10000 F</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun élève trouvé avec ce matricule.</p>
            <?php endif; ?>
        </div>
   </div>

</body>
</html>

<?php
$conn = null; // Ferme la connexion
?>