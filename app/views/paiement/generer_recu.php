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

// Vérification que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matricule']) && isset($_POST['month'])) {
    $matricule = $_POST['matricule'];
    $mois = $_POST['month'];

    // Récupérer les informations de l'élève et le paiement pour le mois sélectionné
    $stmt = $conn->prepare("
        SELECT e.matricule, e.nom, e.prenom, c.nom_classe AS classe, pe.mensualite, sp.mois, sp.etat 
        FROM eleve e
        JOIN Suivi_paiements sp ON e.id = sp.id_eleve
        JOIN paiement_eleve pe ON e.id = pe.id_eleve
        JOIN classe c ON pe.id_classe = c.id
        WHERE e.matricule = :matricule AND sp.mois = :mois AND sp.etat = 1
    ");
    $stmt->bindParam(':matricule', $matricule);
    $stmt->bindParam(':mois', $mois);
    $stmt->execute();
    $eleveInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($eleveInfo) {
        // Récupérer le dernier numéro de reçu pour cet élève
        $stmt = $conn->prepare("
            SELECT MAX(numero_recu) AS dernier_recu 
            FROM Suivi_paiements 
            WHERE id_eleve = (SELECT id FROM eleve WHERE matricule = :matricule)
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $numeroRecu = $result['dernier_recu'] ? $result['dernier_recu'] + 1 : 1;

        // Enregistrer le paiement avec le numéro de reçu
        $stmt = $conn->prepare("
            INSERT INTO Suivi_paiements (id_eleve, mois, etat, numero_recu) 
            VALUES ((SELECT id FROM eleve WHERE matricule = :matricule), :mois, 1, :numero_recu)
        ");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':mois', $mois);
        $stmt->bindParam(':numero_recu', $numeroRecu);
        $stmt->execute();

        // Informations pour le reçu
        $dateGeneration = date('d/m/Y');
        $montant = htmlspecialchars($eleveInfo['mensualite']);
        
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
                    height: 100vh;
                    background-color: #f9f9f9;
                }
                
                .recu {
                    border: 2px solid #000;
                    padding: 50px;
                    width: 600px;
                    margin: auto;
                    border-radius: 5px;
                    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
                    background-color: #fff;
                    height: 80%;
                }
                .header {
                    text-align: center;
                    margin-top: 10px;
                }
                .logo {
                    width: 300px;
                    margin-bottom:5px;
                }
                .details {
                    margin-top: 10px;
                    border: 1px solid #000;
                    padding: 10px;
                    border-radius: 5px;
                }
                .footer {
                    margin-top: 30px;
                    text-align: right;
                }
                .seal {
                    width: 100px;
                }
                .info {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 20px;
                }
                .buttons {
                    text-align: center;
                    margin-top: 20px;
                }
                .btn {
                    padding: 10px 20px;
                    margin: 5px;
                    border: none;
                    border-radius: 5px;
                    background-color: #38D39F;
                    color: white;
                    cursor: pointer;
                }
                .btn:hover {
                    background-color: #B6FF00;
                }
            </style>
            <script>
                function imprimer() {
                    window.print();
                }
            </script>
        </head>
        <body>
            <div class='recu'>
                <div class='header'>
                    <img src='Badge_Education_Badge_Logo.png' alt='Logo de l'école' class='logo'>
                    <p>Date: $dateGeneration</p>
                    <p>N° Reçu: N-$numeroRecu</p>
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
                    <img src='cachet_EcoleReussite.png' alt='Cachet de l'école' class='seal'>
                </div>
                <div class='buttons'>
                    <button class='btn' onclick='window.history.back();'>Retour</button>
                    <button class='btn' onclick='imprimer();'>Imprimer le reçu</button>
                </div>
            </div>
        </body>
        </html>";
    } else {
        echo "<p>Aucune information trouvée pour cet élève ou le paiement n'a pas été effectué pour le mois sélectionné.</p>";
    }
} else {
    echo "<p>Accès non autorisé.</p>";
}

$conn = null; // Ferme la connexion
