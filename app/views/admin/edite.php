<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/gestion-ecole/public/css/inscription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <form id="adminForm" action="/gestion-ecole/public/index.php?action=update&role=<?= $role ?>&id=<?= $users["id"]?>" method="POST">
            <h1 id="formTitle">Modification</h1>
            <img src="/gestion-ecole/public/images/IconeInscription.png" alt="Icone" class="img-top-right">

            <div class="form-row d-flex flex-wrap">
                <div class="col-sm-4 form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" value="<?= htmlspecialchars($users["nom"])?>" name="nom" class="form-control" id="FormControlInput1" placeholder="Entrer un nom" required>
                    <div class="error-message" id="errorNom"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" value="<?= htmlspecialchars($users["prenom"])?>" name="prenom" class="form-control" id="FormControlInput2" placeholder="Entrer un prenom" required>
                    <div class="error-message" id="errorPrenom"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="email">Email :</label>
                    <input type="email" value="<?= htmlspecialchars($users["email"])?>" name="email" class="form-control" id="FormControlInput3" placeholder="name@example.com" required>
                    <div class="error-message" id="errorEmail"></div>
                </div>
            </div>

            <div class="form-row d-flex flex-wrap">
                <div class="col-sm-4 form-group">
                    <label for="ancienMotDePasse">Ancien Mot de passe :</label>
                    <input type="password" id="ancienMotDePasse" name="ancienMotDePasse" class="form-control" placeholder="Entrer l'ancien mot de passe">
                </div>

                <div class="col-sm-4 form-group">
                    <label for="nouveauMotDePasse">Nouveau Mot de passe :</label>
                    <input type="password" id="nouveauMotDePasse" name="nouveauMotDePasse" class="form-control" placeholder="Entrer un nouveau mot de passe">
                    <div class="error-message" id="errorMotDePasse"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="confirmerMotDePasse">Confirmer Mot de passe :</label>
                    <input type="password" id="confirmerMotDePasse" name="confirmerMotDePasse" class="form-control" placeholder="Confirmer le mot de passe">
                    <div class="error-message" id="errorMotDePasseConfirmer"></div>
                </div>
            </div>

            <div class="form-row d-flex flex-wrap">
                <div class="col-sm-4 form-group">
                    <label for="telephone">Téléphone :</label>
                    <input type="number" value="<?= htmlspecialchars($users["telephone"])?>" name="telephone" class="form-control" id="FormControlInput4" placeholder="Entrer un numéro de téléphone" required>
                    <div class="error-message" id="errorTelephone"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="adresse">Adresse :</label>
                    <input type="text" value="<?= htmlspecialchars($users["adresse"])?>" name="adresse" class="form-control" placeholder="Entrer une adresse" required>
                    <div class="error-message" id="errorAdresse"></div>
                </div>
            </div>

            <div id="autresInfos" style="display:none;"></div>

            <!-- Section ELEVE -->
            <?php if ($role == 'eleve') { ?>
            <div id="eleveFields" style="display:block;">
                <div class="form-row d-flex flex-wrap">
                    <div class="col-sm-4 form-group">
                        <label for="dateNaissance">Date de Naissance :</label>
                        <input type="text" value="<?= htmlspecialchars($users["date_naissance"])?>" name="dateNaissance" class="form-control" placeholder="Entrer votre date de naissance" required>
                        <div class="error-message" id="errorDateNaissance"></div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="classe">Classe :</label>
                        <select name="classeEleve" class="form-control" id="FormControlInput5">
                            <option value="" disabled selected>Sélectionner une classe</option>
                            <?php foreach ($allClass as $classe) { ?>
                                <option value="<?= htmlspecialchars($classe['id']) ?>" <?= $classe['id'] == $users['id_classe'] ? 'selected' : '' ?>><?= htmlspecialchars($classe["nom_classe"]) ?></option>   
                            <?php } ?>
                        </select>
                        <div class="error-message" id="errorClasseSurveillant"></div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="nomtuteur">Nom Tuteur :</label>
                        <input type="text" name="nomTuteur" value="<?= htmlspecialchars($users["tuteur"])?>" class="form-control" placeholder="Entrer le nom de tuteur" required>
                        <div class="error-message" id="errorNumerotuteur"></div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <!-- Section PROFESSEUR -->
            <?php if ($role == 'professeur') { ?>
            <div id="professeurFields" style="display:block;">
                <div class="form-row d-flex flex-wrap">
                    <div class="col-sm-4 form-group">
                        <label for="matiere[]">Matière :</label>
                        <select name="matieres[]" class="form-control" id="FormControlInput4" multiple>
                            <option value="" disabled selected>Sélectionner une matière</option>
                            <?php foreach ($matieres as $matiere) { ?>
                                <option value="<?= htmlspecialchars($matiere["id"]) ?>"><?= htmlspecialchars($matiere["nom_matiere"]) ?></option>   
                            <?php } ?>
                        </select>                    
                        <div class="error-message" id="errorMatiere"></div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="classeProfesseur[]">Classe :</label>
                        <select name="classesProfesseur[]" class="form-control" id="FormControlInput5" multiple>
                            <option value="" disabled selected>Sélectionner les classes</option>
                            <?php foreach ($secondaires as $secondaire) { ?>
                                <option value="<?= htmlspecialchars($secondaire["id"]) ?>"><?= htmlspecialchars($secondaire["nom_classe"]) ?></option>   
                            <?php } ?>
                        </select>
                        <div class="error-message" id="errorClasseProfesseur"></div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <!-- Section SURVEILLANT -->
            <?php if ($role == 'surveillant') { ?>
            <div id="surveillantFields" style="display:block;">
                <div class="form-row d-flex flex-wrap">
                    <div class="col-sm-4 form-group">
                        <label for="classe">Classe :</label>
                        <select name="classe" class="form-control" id="FormControlInput7">
                            <option value="" disabled selected>Sélectionner une classe</option>
                            <?php foreach ($secondaires as $secondaire) { ?>
                                <option value="<?= htmlspecialchars($secondaire["id"]) ?>"><?= htmlspecialchars($secondaire["nom_classe"]) ?></option>   
                            <?php } ?>
                        </select>
                        <div class="error-message" id="errorClasseEnseignant"></div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="text-center">
                <button type="submit" class="btn btn-primary" style="width: 200px;">Enregistrer</button>
                <button class="btn btn-primary" style="width: 200px;">
                    <a class="btn-primary" href="/gestion-ecole/public/index.php?action=liste&role=<?= $role?>">Retour</a>
                </button>
            </div>
        </form>
    </div>

    <script src="/gestion-ecole/public/js/modifier.js"></script>
</body>
</html>
