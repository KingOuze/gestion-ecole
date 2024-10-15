<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des paiements des élèves</title>
    <link rel="stylesheet" href="/gestion-ecole/public/css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Pour les icônes -->
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 sidebar">
                <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo.png" alt="École de la Réussite">
                <h4>ECOLE DE LA REUSSITE</h4>
            </nav>

            <main class="col-md-9 ml-sm-auto col-lg-9 px-4">
            <?php if($student == NULL || is_string($student)){ ?>
                <div class="header">
                    <h1>Gestion de paiements des élèves</h1>
                    <button class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <i class="fas fa-user-graduate card-icon"></i>
                            <h5>Total élèves</h5>
                            <h2><?= $totalEleves ; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <i class="fas fa-money-bill-wave card-icon"></i>
                            <h5>Nombres de Paiements Validés</h5>
                            <h2><?= $totalPayer ; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <i class="fas fa-check-circle card-icon"></i>
                            <h5>Nombres d'Eleves Restants</h5>
                            <h2><?= $totalRestant ; ?></h2>
                        </div>
                    </div>
                </div>

                <div class="search-bar text-center">
                    <form action="/gestion-ecole/public/index.php?action=inscription" method="POST">
                        <div class="input-group w-50 mx-auto">
                            <input id="searchInput" type="text" name="matricule" class="form-control" placeholder="Recherche par matricule">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <?php if (is_string($student)){ ?>
                        <div>
                            <h6 class="text-danger">* Ce Matricule est introuvable dans la base de données</h6>
                        </div>
                    <?php }  ?>
                </div>
                <div class="bottom-image">
                    <img src="/gestion-ecole/public/images/img.png" alt="Description de l'image" /> 
                </div>
            

            <?php } else { ?>
                <div class="header d-flex align-items-center">
                    <h1 class="mr-2">Gestion de paiements des élèves</h1>
                    <div class="search-bar text-center">
                    <form action="/gestion-ecole/public/index.php?action=inscription" method="POST">
                        <div class="input-group w-40 mx-auto">
                            <input id="searchInput" type="text" name="matricule" class="form-control" placeholder="Recherche par matricule">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                    <button class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </div>
                <div id="studentTableBody" class="student-table">
                    <h2>École de la réussite</h2>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Matricule</th>
                                <th>Prenom et Nom</th>
                                <th>Niveau/Classe</th>
                                <th>Frais d'inscription</th>
                                <th>Année</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $student['matricule'] ?></td>
                                <td><?= $student['prenom'] ?> <?= $student['nom'] ?></td>
                                <td><?= $student['niveau_classe'] ?>/<?= $student['nom_classe'] ?></td>
                                <td><?= $student['montant_tarif'] ?></td>
                                <td><?= $student['annee'] ?></td>
                                <?php if($student['status'] == 0){ ?>
                                    <td id="txt_validation" class="id_non_payé" style="display: block;">Non payé</td>
                                    <td id="btn_valider">
                                        <button class="btn btn-primary btn-receipt" onclick="toggleRecuButton()">Cliquer Pour Payer</button>
                                    </td>
                                    
                                <?php } else { ?>
                                    <td class="text-success" id="valide" style="display: block;"><strong>Payé</strong></td>
                                    <td>
                                    </td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Zone de texte pour le Nota Bene -->
                <div id="commentSection" style="display: none; margin-top: 20px;">
                    <h4 id="paymentComment" class="form-control" rows="4" placeholder="Ajouter un commentaire..."> <strong>NB:</strong> Le paiement ne sera effectif que si le reçu est généré</h4>
                </div>

                <div>
                    <button id="generateReceiptButton" class="btn btn-success btn-generate mr-3 mt-3" onclick="openModal()" style="display: none; margin-top: 30px;">
                        Générer un reçu
                    </button>
                </div>
            <?php } ?>
            </main>
        </div>

        <!-- Modal de confirmation -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmation de l'inscription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Voulez-vous valider le paiement de cette eleve?</p>
                        <div id="userInfo"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-success" id="valide" >valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Déclaration de l'URL a suivre
        const baseUrl = '/gestion-ecole/public/index.php';
        const queryString = `?action=inscription`;

        const id = <?= $student['id'] ?>; // Récupérez le matricule du PHP
        const matricule = "<?= $student['matricule'] ?>"; // Récupérez le matricule du PHP


        //Methode pour procéder au paiement
        function processPayment() {
            // Collecte des données
            const id = <?= $student['id'] ?>; // Récupérez le matricule du PHP
            const matricule = "<?= $student['matricule'] ?>"; // Récupérez le matricule du PHP

        
            
            // Envoi de la requête AJAX
            fetch(baseUrl + queryString, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'matricule': matricule,
                    'id': id,
                })
            })
            .then(response => response.text()) // Récupérer la réponse en tant que texte
            .then(data => {
                //let data1 = {'matricule': 'ELEV003', 'id': 1}
                
                //console.log(data,'tests'); // Afficher la réponse dans la console
                
                try {
                    const jsonResponse = JSON.parse(data); // Essayer de parser le JSON
                    if (jsonResponse.success) {
                        //console.log(data);
                        toggleRecuButton(); // cacher la génération de reçu et le texte NB
                        location.reload(); // Actualise la page

                    } else {
                        alert('Erreur lors du paiement, veuillez réessayer.');
                    }
                } catch (error) {
                    console.error('Erreur de parsing JSON:', error);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });

        }
        function toggleRecuButton() {
            const commentSection = document.getElementById('commentSection');
            const btn_recu = document.getElementById('generateReceiptButton');
            const btn_valide = document.getElementById('valide');
            const btn_non_valide = document.getElementById('btn_valider');
            const btn_text = document.getElementById('txt_validation');

            btn_recu.style.display = commentSection.style.display === 'none' || btn_recu.style.display === '' ? 'block' : 'none';
            commentSection.style.display = commentSection.style.display === 'none' || commentSection.style.display === '' ? 'block' : 'none';

            btn_text.style.display = 'none';
            btn_non_valide.style.display = 'none';
            btn_valide.style.display = 'block';
        }


        function openModal() {
            $('#confirmModal').modal('show');
        }
        document.getElementById('valide').addEventListener('click', function() {
            // Logique de confirmation ici...
            processPayment();
            $('#confirmModal').modal('hide'); // Ferme le modal 
        });
        
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>