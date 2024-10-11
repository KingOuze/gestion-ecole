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
$error_message = '';
$update_success = false; // Indicateur de succès de mise à jour

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si la recherche par matricule a été soumise
    if (isset($_POST['matricule'])) {
        $matricule = $_POST['matricule'];

        // Préparation de la requête pour récupérer les informations de l'élève
        $stmt = $conn->prepare("
            SELECT e.matricule, e.nom, e.prenom, sp.mois, sp.etat, c.nom_classe AS classe, pe.mensualite 
            FROM eleve e
            LEFT JOIN Suivi_paiements sp ON e.id = sp.id_eleve
            LEFT JOIN paiement_eleve pe ON e.id = pe.id_eleve
            LEFT JOIN classe c ON pe.id_classe = c.id
            WHERE e.matricule = :matricule
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        $eleveInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mise à jour de l'état de paiement
    if (isset($_POST['update_payment'])) {
        $month = $_POST['month'];
        $new_state = $_POST['payment_state']; // 0 pour "Non payé", 1 pour "Payé"

        // Vérification si le mois n'est pas vide
        if (empty($month)) {
            $error_message = "Le mois ne peut pas être vide.";
        } else {
            // Préparation de la requête d'insertion
            $stmt = $conn->prepare("
                INSERT INTO Suivi_paiements (id_eleve, mois, etat)
                VALUES ((SELECT id FROM eleve WHERE matricule = :matricule), :mois, :etat)
                ON DUPLICATE KEY UPDATE etat = :etat
            ");

            // Lier les paramètres
            $stmt->bindParam(':matricule', $matricule);
            $stmt->bindParam(':mois', $month);
            $stmt->bindParam(':etat', $new_state);
            
            try {
                // Exécuter la requête
                $stmt->execute();
                $update_success = ($new_state == '1'); // Vérifie si la mise à jour a été faite et si l'état est "Payé"
            } catch (PDOException $e) {
                $error_message = "Erreur lors de la mise à jour : " . $e->getMessage();
            }
        }
    }
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
                    <button type="submit" class="search-button1">
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
            <p id="special-paragraph">Informations de l'élève</p>
            <?php if (!empty($eleveInfo)): ?>
                <?php if (!empty($error_message)): ?>
                    <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <table border="1" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Mois</th>
                            <th>Mensualité</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($eleveInfo['matricule']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['nom']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($eleveInfo['classe']); ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <select name="month" required>
                                        <option value="Octobre" <?php echo ($eleveInfo['mois'] == 'Octobre') ? 'selected' : ''; ?>>Octobre</option>
                                        <option value="Novembre" <?php echo ($eleveInfo['mois'] == 'Novembre') ? 'selected' : ''; ?>>Novembre</option>
                                        <option value="Décembre" <?php echo ($eleveInfo['mois'] == 'Décembre') ? 'selected' : ''; ?>>Décembre</option>
                                        <option value="Janvier" <?php echo ($eleveInfo['mois'] == 'Janvier') ? 'selected' : ''; ?>>Janvier</option>
                                        <option value="Février" <?php echo ($eleveInfo['mois'] == 'Février') ? 'selected' : ''; ?>>Février</option>
                                        <option value="Mars" <?php echo ($eleveInfo['mois'] == 'Mars') ? 'selected' : ''; ?>>Mars</option>
                                        <option value="Avril" <?php echo ($eleveInfo['mois'] == 'Avril') ? 'selected' : ''; ?>>Avril</option>
                                        <option value="Mai" <?php echo ($eleveInfo['mois'] == 'Mai') ? 'selected' : ''; ?>>Mai</option>
                                        <option value="Juin" <?php echo ($eleveInfo['mois'] == 'Juin') ? 'selected' : ''; ?>>Juin</option>
                                        <option value="Juillet" <?php echo ($eleveInfo['mois'] == 'Juillet') ? 'selected' : ''; ?>>Juillet</option>
                                    </select>
                            </td>
                            <td><?php echo htmlspecialchars($eleveInfo['mensualite']); ?> CFA</td>
                            <td>
                                <select name="payment_state" required>
                                    <option value="0" <?php echo (empty($eleveInfo['etat']) || $eleveInfo['etat'] == '0') ? 'selected' : ''; ?>>Non payé</option>
                                    <option value="1" <?php echo ($eleveInfo['etat'] == '1') ? 'selected' : ''; ?>>Payé</option>
                                </select>
                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($matricule); ?>">
                                <input type="hidden" name="etat" value="<?php echo htmlspecialchars($new_state); ?>">

                                <button type="submit" name="update_payment" class="btn-submit">Mettre à jour</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <?php if ($eleveInfo['etat'] == '1'): // Afficher le bouton si l'élève a payé ?>
                    <form method="post" action="generer_recu.php" style="margin-top: 20px;">
                        <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($matricule); ?>">
                        <input type="hidden" name="mois" value="<?php echo htmlspecialchars($eleveInfo['mois']); ?>">
                        <button type="submit" class="btn-recu">Générer un reçu</button>
                    </form>
                <?php endif; ?>

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