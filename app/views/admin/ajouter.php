<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/gestion-ecole/public/css/inscription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <div class="container">
        <form action="index.php?action=create" method="POST" onsubmit="return validateForm()">
        <h1 id="formTitle">Inscription</h1>
        <img src="/gestion-ecole/public/images/IconeInscription.png" alt="Icone " class="img-top-right">

            <div class="form-row d-flex flex-wrap">
                <div class="col-sm-4 form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" class="form-control" id="FormControlInput1" placeholder="Entrer un nom">
                    <div class="error-message" id="errorNom"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" class="form-control" id="FormControlInput2" placeholder="Entrer un prenom">
                    <div class="error-message" id="errorPrenom"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="email">Email :</label>
                    <input type="email" name="email" class="form-control" id="FormControlInput3" placeholder="name@example.com">
                    <div class="error-message" id="errorEmail"></div>
                </div>
            </div>

            <div class="form-row d-flex flex-wrap">
                <div class="col-sm-4 form-group">
                    <label for="motDePasse">Mot de passe :</label>
                    <div class="input-group">
                        <input type="password" id ="motDePasse" name="motDePasse" class="form-control" placeholder="Entrer un mot de passe" required>
                        <div class="input-group-append">
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                    </div>
                    </div>
                    <div class="error-message" id="errorMotDePasse"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="telephone">Téléphone :</label>
                    <input type="number" name="telephone" class="form-control" placeholder="Entrer un numero de telephone" required>
                    <div class="error-message" id="errorTelephone"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" class="form-control" placeholder="Entrer une adresse" required>
                    <div class="error-message" id="errorAdresse"></div>
                </div>
            </div>

            <div id="autresInfos" style="display:none;"></div>

            <!-- Section ELEVE -->
            <div id="eleveFields" style="display:none;">
                <div class="form-row d-flex flex-wrap">
                    <div class="col-sm-4 form-group">
                        <label for="dateNaissance">Date de Naissance :</label>
                        <input type="date" name="dateNaissance" class="form-control" placeholder="Entrer votre date de naissance">
                        <div class="error-message" id="errorDateNaissance"></div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="classe">Classe :</label>
                        <select name="classeId" class="form-control" id="FormControlInput7" >
                            <option value="" disabled selected>Sélectionner une classe</option>
                            <?php foreach ($allClass as $classe) { ?>
                                <option value="<?php echo $classe["id"]; ?>">
                                    <?php echo $classe["nom_classe"]; ?>
                                </option>
                            <?php }; ?>
                        </select>
                        <div class="error-message" id="errorClasseEleve"></div>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="nomtuteur">Nom Tuteur :</label>
                        <input type="text" name="nomTuteur" class="form-control" placeholder="Entrer le nom de tuteur">
                        <div class="error-message" id="errorNumerotuteur"></div>
                    </div>
                </div>
            </div>

            <!-- Section PROFESSEUR -->
            <div id="professeurFields" style="display:none;">
            <div class="form-row d-flex flex-wrap">
                <div class="col-sm-4 form-group">
                    <label for="matiere[]">Matière :</label>
                    <select name="matieres[]" class="form-control" id="FormControlInput4" multiple >
                        <option value="" disabled selected>Sélectionner une classe</option>
                        <?php foreach ($matieres as $matiere) { ?>
                                    <option value="<?php echo $matiere["id"]?>"><?php echo $matiere["nom_matiere"]?></option>   
                                <?php } ?>
                    </select>                    
                    <div class="error-message" id="errorMatiere"></div>
                </div>

                <div class="col-sm-4 form-group">
                    <label for="classeProfesseur[]" >Classe :</label>
                    <select name="classesProfesseur[]" class="form-control" id="FormControlInput5" multiple >
                        <option value="" disabled selected>Sélectionner les classes</option>
                        <?php foreach ($secondaires as $secondaire) { ?>
                                    <option value="<?php echo $secondaire["id"]?>"><?php echo $secondaire["nom_classe"]?></option>   
                                <?php } ?>
                    </select>
                    <div class="error-message" id="errorClasseProfesseur"></div>
                </div>

                <div class="col-sm-4 form-group">

                </div>


            </div>
        </div>

            <!-- Section SURVEILLANT -->
            <div id="surveillantFields" style="display:none;">
                <div class="form-row d-flex flex-wrap">
                <div class="col-sm-4 form-group">
                    <label for="classeSurveillant[]">Classe :</label>
                    <select name="classesSurveillant[]" class="form-control" id="FormControlInput5" multiple >
                        <option value="" disabled selected>Sélectionner les classes</option>
                        <?php foreach ($secondaires as $secondaire) { ?>
                                    <option value="<?php echo $secondaire["id_classe"]?>"><?php echo $secondaire["nom_classe"]?></option>   
                                <?php } ?>
                    </select>
                    <div class="error-message" id="errorClasseSurveillant"></div>
                </div>

                    <div class="col-sm-4 form-group">

                    </div>

                    <div class="col-sm-4 form-group">

                    </div>

                </div>
            </div>

           <!-- Section Enseignant -->
            <div id="enseignantFields" style="display:none;">
                <div class="form-row d-flex flex-wrap">
                    <div class="col-sm-4 form-group">
                        <label for="classe">Classe :</label>
                        <select name="classe" class="form-control" id="FormControlInput7" >
                            <option value="" disabled selected>Sélectionner une classe</option>
                            <?php foreach ($secondaires as $secondaire) { ?>
                                <option value="<?php echo $secondaire["id_classe"]?>"><?php echo $secondaire["nom_classe"]?></option>   
                            <?php } ?>
                        </select>
                        <div class="error-message" id="errorClasseEnseignant"></div>
                    </div>
                </div>
            </div>

            <!-- Section ROLE -->
            <div class="form-group">
                <label for="role">Rôle :</label>
                <select name="role" id="role" class="form-control" onchange="toggleFields()" required>
                    <option value="" disabled selected>Sélectionnez un rôle</option>
                    <option value="administrateur">Administrateur</option>
                    <option value="professeur">Professeur</option>
                    <option value="enseignant">Enseignant</option>
                    <option value="comptable">Comptable</option>
                    <option value="surveillant">Surveillant</option>
                    <option value="eleve">Élève</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary" style="width: 200px;">Inscrire</button>
                <button class="btn btn-primary" style="width: 200px;"><a class="btn-primary" href="/gestion-ecole/public/index.php?action=liste&role=<?= $role?>">Retour</a></button>

            </div>
        </form>
    </div>


    <script src="/gestion-ecole/public/js/inscription.js"></script>

</body>
</html>