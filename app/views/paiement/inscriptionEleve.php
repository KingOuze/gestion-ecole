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
               <!-- <ul class="list-unstyled">
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Gestion des élèves</a></li>
                    <li><a href="#">Paiements</a></li>
                    <li><a href="#">Rapports</a></li>
                    <li><a href="#">Paramètres</a></li>
                </ul>-->
            </nav>

            <main class="col-md-9 ml-sm-auto col-lg-9 px-4">
                <div class="header">
                    <h1>Gestion de paiements des élèves</h1>
                    <button class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </div>
            <?php if($eleve == NULL){ ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <i class="fas fa-user-graduate card-icon"></i>
                            <h5>Total élèves</h5>
                            <h2>5,423</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <i class="fas fa-money-bill-wave card-icon"></i>
                            <h5>Total élèves à payer</h5>
                            <h2>1,893</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <i class="fas fa-check-circle card-icon"></i>
                            <h5>Total élèves payés</h5>
                            <h2>189</h2>
                        </div>
                    </div>
                </div>

                <!-- Barre de recherche centrée avec bouton -->
                <div class="search-bar text-center">
                    <div class="input-group w-50 mx-auto">
                        <input type="text" class="form-control" placeholder="Recherche par matricule">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bottom-image">
                    <img src="/gestion-ecole/public/images/img.png" alt="Description de l'image" /> 
                </div>

            <?php } else { ?>
                  <!-- Tableau des élèves -->
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
                                <th>État</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lamine Nassy</td>
                                <td>ER-EL-10000</td>
                                <td>Primaire/CE1</td>
                                <td>15,000</td>
                                <td>2024-2025</td>
                                <td class="status-non-payé"><button class="status-non-payé">non payé</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        async function fetchStudent(matricule) {
            try {
                const response = await fetch(`get_student.php?matricule=${matricule}`);
                if (!response.ok) {
                    throw new Error('Erreur lors de la récupération des données');
                }
                const student = await response.json();
                displayStudent(student);
            } catch (error) {
                console.error('Erreur:', error);
            }
        }

        function displayStudent(student) {
            const tableBody = document.getElementById('studentTableBody');
            tableBody.innerHTML = ''; // Effacer le contenu précédent

            if (student.message) {
                alert(student.message);
                return;
            }

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${student.name}</td>
                <td>${student.matricule}</td>
                <td>${student.level}</td>
                <td>${student.fees}</td>
                <td>${student.year}</td>
                <td class="${student.paid ? 'status-payé' : 'status-non-payé'}">${student.paid ? 'payé' : 'non payé'}</td>
            `;
            tableBody.appendChild(row);
        }

        function searchStudent() {
            const input = document.getElementById('searchInput');
            const matricule = input.value.trim();
            if (matricule) {
                fetchStudent(matricule);
            }
        }
    </script>
</body>
</html>