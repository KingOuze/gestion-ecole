<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Paiements</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/SuiviPaiement.css">
</head>
<body>
    <!-- Barre latérale -->
    <div class="d-flex">
        <div class="sidebar">
            <div class="logo text-center">
                <img src="Badge_Education_Badge_Logo.png" alt="Logo">
            </div>
            <nav class="nav flex-column">
                <h4>Ecole de la réussite</h4>
                <a class="nav-link active" href="#">Accueil</a>
                <a class="nav-link" href="#">Professeur</a>
                <a class="nav-link" href="#">Suivi Paiement</a>
                <a class="nav-link" href="#">Autres</a>
            </nav>
        </div>

        <!-- Contenu principal -->
        <div class="content flex-grow-1 p-4">
            <h1 class="mb-4">Suivi de Paiement</h1>

            <!-- Sélecteur de mois et barre de recherche -->
            <div class="form-group d-flex align-items-center mb-3">
                <label for="monthSelect" class="mr-3">Sélectionnez le Mois</label>
                <select class="form-control custom-select mr-3" id="monthSelect">
                    <option value="">--Selectionnez le mois--</option>
                    <option>Janvier</option>
                    <option>Février</option>
                    <option>Mars</option>
                    <option>Avril</option>
                    <option>Mai</option>
                    <option>Juin</option>
                    <option>Juillet</option>
                    <option>Août</option>
                    <option>Septembre</option>
                    <option>Octobre</option>
                    <option>Novembre</option>
                    <option>Décembre</option>
                </select>

                <div class="search-container">
                    <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Rechercher un employé...">
                    <span class="icon">🔍</span>
                </div>
            </div>

            <!-- Tableau des paiements -->
            <table class="table table-striped" id="tableau">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Matricule</th>
                        <th>Mois</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rye</td>
                        <td>Olivia</td>
                        <td>ER-L-0001</td>
                        <td>Décembre</td>
                        <td><span class="text-danger">Non payé</span></td>
                    </tr>
                    <tr>
                        <td>Slater</td>
                        <td>Phoenix</td>
                        <td>ER-L-0002</td>
                        <td>Décembre</td>
                        <td><span class="text-success">Payé</span></td>
                    </tr>
                    <tr>
                        <td>Steiner</td>
                        <td>Lana</td>
                        <td>ER-L-0003</td>
                        <td>Décembre</td>
                        <td><span class="text-danger">Non payé</span></td>
                    </tr>
                    <tr>
                        <td>Wilkinson</td>
                        <td>Demi</td>
                        <td>ER-L-0004</td>
                        <td>Décembre</td>
                        <td><span class="text-success">Payé</span></td>
                    </tr>
                    <tr>
                        <td>Wu</td>
                        <td>Candice</td>
                        <td>ER-L-0005</td>
                        <td>Décembre</td>
                        <td><span class="text-danger">Non payé</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../../public/js/input.js"></script> <!-- Lien vers le fichier JS -->
</body>
</html>
