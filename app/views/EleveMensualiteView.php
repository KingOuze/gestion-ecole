<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Paiements des Élèves</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/gestion-ecole/public/css/EleveMensualiteView.css">




</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <img src="/gestion-ecole/public/images/Badge_Education_Badge_Logo.png" alt="Logo">
            <h2 class="school-name">Ecole de la réussite</h2>
        </div>
        <ul>
            <li><a href="#">Tableau de Bord</a></li>
            <li><a href="/gestion-ecole/app/views/DashboardpaiementEleve.php">Retour</a></li>
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
                    <img src="/gestion-ecole/public/images/iconeDeconnexion.png" alt="Déconnexion" class="deconnexion-icon">
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
                                    <option value="1" <?php echo isset($eleveInfo['etat']) && $eleveInfo['etat'] == '1' ? 'selected' : ''; ?>>Payé</option>
                                    </select>
                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($matricule); ?>">
                                <button type="submit" name="update_payment" class="btn-submit">Mettre à jour</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

                            <!-- Modal de reçu -->
                <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="receiptModalLabel">Reçu de Paiement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="bulletin-container">
                                    <div class="header">
                                        <img src="/gestion-ecole/public/images/Badge_Education_Badge_Logo.png" alt="Logo de l'école">
                                        <div class="title">Recu de paiement</div>
                                        <div class="date-reçu">
                                            <div>Date : <span id="modal-date"></span></div>
                                            <div>Reçu : N-0001</div>
                                        </div>
                                    </div>

                                    <div class="info-section">
                                        <div class="info">
                                            <label>Matricule :</label>
                                            <span id="modal-matricule"></span>
                                        </div>
                                        <div class="info">
                                            <label>Nom et Prénom :</label>
                                            <span id="modal-nom"></span>
                                        </div>
                                        <div class="info">
                                            <label>Montant :</label>
                                            <span id="modal-montant"></span>
                                        </div>
                                        <div class="info">
                                            <label>Mois :</label>
                                            <span id="modal-mois"></span>
                                        </div>
                                    </div>

                                    <div class="footer">
                                        <div class="signature">LE DIRECTEUR</div>
                                        <img src="/gestion-ecole/public/images/cachet_EcoleReussite.png" alt="Logo de signature" class="signature-logo">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button type="button" class="btn btn-outline-primary" id="printReceiptButton" onclick="printReceipt()">
                                    <i class="fas fa-print"></i> Imprimer
                                </button>                
                            </div>
                        </div>
                    </div>
                </div>


                <?php if (!empty($paiements)): ?>
                    <p id="special-paragraph">Suivi des paiements de l'élève</p>

                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paiements as $paiement): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($paiement['mois']); ?></td>
                                    <td><?php echo $paiement['etat'] == 1 ? 'Payé' : 'Non payé'; ?></td>
                                    <td>
                                        <?php if ($paiement['etat'] == 1): ?>
                                            <form method="post" action="gererPaiement" style="display: inline;">
                                                <input type="hidden" name="action" value="gererPaiement">
                                                <input type="hidden" name="matricule" value="<?php echo htmlspecialchars($eleveInfo['matricule']); ?>">
                                                <input type="hidden" name="month" value="<?php echo htmlspecialchars($paiement['mois']); ?>">
                                                
                                                <!-- Bouton Générer un reçu -->
                                                <button type="button" class="btn-recu" data-toggle="modal" data-target="#receiptModal" onclick="remplirModal('<?php echo htmlspecialchars($eleveInfo['matricule']); ?>', '<?php echo htmlspecialchars($eleveInfo['nom'] . ' ' . $eleveInfo['prenom']); ?>', '<?php echo htmlspecialchars($eleveInfo['mensualite']); ?> CFA', '<?php echo htmlspecialchars($paiement['mois']); ?>')">
                                                    Générer un reçu
                                                </button>
                                            </form>

                                        <?php endif; ?>
                                    </td>
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

   <script>
function remplirModal(matricule, nom, montant, mois, numeroRecu) {
    document.getElementById('modal-matricule').textContent = matricule;
    document.getElementById('modal-nom').textContent = nom;
    document.getElementById('modal-montant').textContent = montant;
    document.getElementById('modal-mois').textContent = mois;
    document.getElementById('modal-recu').textContent = numeroRecu; // Ajouter cette ligne

    var today = new Date();
    var date = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
    document.getElementById('modal-date').textContent = date;
}

function printReceipt() {
    var modalContent = document.querySelector('.modal-body').innerHTML;
    var printWindow = window.open('', '_blank', 'width=600,height=400');
    printWindow.document.write(`
        <html>
            <head>
                <title>Impression du Reçu</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <style>
                    body { font-family: Arial, sans-serif; }
                    .header, .footer { text-align: center; }
                </style>
            </head>
            <body>
                ${modalContent}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
    };
}
</script>

<script>
        // Obtenir la date actuelle
        const currentDate = new Date();
        // Formater la date
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = currentDate.toLocaleDateString('fr-FR', options);
        // Afficher la date dans l'élément
        document.getElementById('modal-date').textContent = formattedDate;
    </script>

</body>
</html>