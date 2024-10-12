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
$paiements = [];
$error_message = '';
$success_message = ''; // Message de succès
$update_success = false; // Indicateur de succès de mise à jour

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification si la recherche par matricule a été soumise
    if (isset($_POST['matricule'])) {
        $matricule = $_POST['matricule'];

        // Préparation de la requête pour récupérer les informations de l'élève
        $stmt = $conn->prepare("
            SELECT e.id, e.matricule, e.nom, e.prenom, c.nom_classe AS classe, pe.mensualite 
            FROM eleve e
            LEFT JOIN paiement_eleve pe ON e.id = pe.id_eleve
            LEFT JOIN classe c ON pe.id_classe = c.id
            WHERE e.matricule = :matricule
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        $eleveInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les paiements de l'élève
    if (!empty($eleveInfo)) {
        $stmt = $conn->prepare("
            SELECT mois, etat 
            FROM Suivi_paiements 
            WHERE id_eleve = :id_eleve
        ");
        $stmt->bindParam(':id_eleve', $eleveInfo['id']);
        $stmt->execute();
        $paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mise à jour de l'état de paiement
    if (isset($_POST['update_payment'])) {
        $payment_month = $_POST['month']; // Mois à mettre à jour
        $new_state = $_POST['payment_state']; // 0 pour "Non payé", 1 pour "Payé"
        
        // Vérifier si l'élève a déjà un suivi de paiement
        $stmt = $conn->prepare("
            SELECT * FROM Suivi_paiements 
            WHERE id_eleve = (SELECT id FROM eleve WHERE matricule = :matricule) 
            AND mois = :mois
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':mois', $payment_month);
        $stmt->execute();
        $existing_payment = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si l'enregistrement existe, on met à jour
        if ($existing_payment) {
            $stmt = $conn->prepare("
                UPDATE Suivi_paiements
                SET etat = :etat
                WHERE id_eleve = (SELECT id FROM eleve WHERE matricule = :matricule) 
                AND mois = :mois
            ");
        } else {
            // Sinon, on insère un nouvel enregistrement
            $stmt = $conn->prepare("
                INSERT INTO Suivi_paiements (id_eleve, mois, etat) 
                VALUES ((SELECT id FROM eleve WHERE matricule = :matricule), :mois, :etat)
            ");
        }

        // Lier les paramètres
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':mois', $payment_month);
        $stmt->bindParam(':etat', $new_state);

        try {
            // Exécuter la requête
            $stmt->execute();
            $update_success = true; // Indique que la mise à jour ou insertion a réussi
            $success_message = "L'etat de paiement a été enregistré avec succès."; // Message de succès
        } catch (PDOException $e) {
            $error_message = "Erreur lors de la mise à jour : " . $e->getMessage();
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
            <li><a href="Dashboard_Mensualite_eleve.php">Suivi de paiement d'un eleve</a></li>
            <li><a href="Dashboard_Mensualite_eleve.php">Retour</a></li>
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
                <?php if (!empty($success_message)): ?>
                    <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
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
                            <th>Actions</th>
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
                                        <option value="Octobre">Octobre</option>
                                        <option value="Novembre">Novembre</option>
                                        <option value="Décembre">Décembre</option>
                                        <option value="Janvier">Janvier</option>
                                        <option value="Février">Février</option>
                                        <option value="Mars">Mars</option>
                                        <option value="Avril">Avril</option>
                                        <option value="Mai">Mai</option>
                                        <option value="Juin">Juin</option>
                                        <option value="Juillet">Juillet</option>
                                    </select>
                            </td>
                            <td><?php echo htmlspecialchars($eleveInfo['mensualite']); ?> CFA</td>
                            <td>
                                <select name="payment_state" required>
                                    <option value="0" <?php echo (empty($eleveInfo['etat']) || $eleveInfo['etat'] == '0') ? 'selected' : ''; ?>>Non payé</option>
                                    <option value="1" <?php echo ($eleveInfo['etat'] == '1') ? 'selected' : ''; ?>>Payé</option>
                                </select>
                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($matricule); ?>">
                                <button type="submit" name="update_payment" class="btn-submit">Mettre à jour</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <?php if (!empty($paiements)): ?>
                    <h3>Paiements de l'élève</h3>
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>État</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paiements as $paiement): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($paiement['mois']); ?></td>
                                    <td><?php echo $paiement['etat'] == 1 ? 'Payé' : 'Non payé'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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