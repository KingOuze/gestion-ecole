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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = $_POST['matricule'];
    $mois = $_POST['mois'];

    // Requête pour récupérer les informations de l'élève
    $stmt = $conn->prepare("
        SELECT e.matricule, e.nom, e.prenom, c.nom_classe AS classe, pe.mensualite 
        FROM eleve e
        LEFT JOIN Suivi_paiements sp ON e.id = sp.id_eleve
        LEFT JOIN paiement_eleve pe ON e.id = pe.id_eleve
        LEFT JOIN classe c ON pe.id_classe = c.id
        WHERE e.matricule = :matricule AND sp.mois = :mois
    ");
    $stmt->bindParam(':matricule', $matricule);
    $stmt->bindParam(':mois', $mois);
    $stmt->execute();
    $eleveInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($eleveInfo) {
        // Informations pour le reçu
        $dateGeneration = date('d/m/Y');
        $montant = htmlspecialchars($eleveInfo['mensualite']);
        $etat = 'Payé'; // Puisque nous générons le reçu pour un élève qui a payé

        // Affichage du reçu
        echo "<html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Reçu de Paiement</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh; /* Centrer verticalement */
                    background-color: #f9f9f9; /* Couleur de fond */
                }
                
                .recu {
                    border: 2px solid #000;
                    padding: 40px; /* Augmentez cette valeur pour plus d'espace à l'intérieur */
                    width: 500px; /* Augmentez cette valeur pour élargir le reçu */
                    margin: auto;
                    border-radius: 10px;
                    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
                    background-color: #fff;
                }
                .header {
                    text-align: center; /* Centrer le logo */
                    margin-bottom: 20px;
                }

                .header-info {
                    text-align: right; /* Centre le texte à droite */
                }
                .logo {
                    width: 320px; /* Ajuste la taille de l'image de logo */
                }
                .details {
                    margin-top: 20px;
                    border: 1px solid #000; /* Cadre autour des détails */
                    padding: 10px; /* Espace à l'intérieur du cadre */
                    border-radius: 5px; /* Bords arrondis */
                }
                .footer {
                    margin-top: 30px;
                    text-align: right;
                }
                .seal {
                    width: 150px; /* Ajuste la taille de l'image du cachet */
                }
                .info {
                    display: flex;
                    justify-content: space-between; /* Alignement des attributs et valeurs */
                    margin-bottom: 20px; /* Ajuste cette valeur pour augmenter l'espace */
                }
            </style>
        </head>
        <body>
            <div class='recu'>
                <div class='header'>
                    <img src='Badge_Education_Badge_Logo.png' alt='Logo de l'école' class='logo'> <!-- Remplace le chemin par l'URL de l'image -->
                    <p>Date: $dateGeneration</p>
                    <p>N° Reçu: N-0003</p>
                </div>
                <h3 style='text-align: center;'>REÇU DE PAIEMENT</h3>
                <div class='details'>
                    <div class='info'><strong>Matricule</strong> <span>" . htmlspecialchars($eleveInfo['matricule']) . "</span></div>
                    <div class='info'><strong>Nom et Prénom</strong> <span>" . htmlspecialchars($eleveInfo['nom'] . ' ' . $eleveInfo['prenom']) . "</span></div>
                    <div class='info'><strong>Montant</strong> <span>$montant CFA</span></div>
                    <div class='info'><strong>Classe</strong> <span>" . htmlspecialchars($eleveInfo['classe']) . "</span></div>
                    <div class='info'><strong>Mois</strong> <span>" . htmlspecialchars($mois) . "</span></div>
                </div>
                <div class='footer'>
                    <img src='cachet_EcoleReussite.png' alt='Cachet de l'école' class='seal'> <!-- Remplace le chemin par l'URL de l'image -->
                </div>
            </div>
        </body>
        </html>";
    } else {
        echo "<p>Aucune information trouvée pour cet élève.</p>";
    }
} else {
    echo "<p>Accès non autorisé.</p>";
}

$conn = null; // Ferme la connexion
?>