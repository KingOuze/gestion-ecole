<!DOCTYPE html>
<html>
<head>
    <title>Page de connexion</title> <!-- Définit le titre de la page -->
    <link rel="stylesheet" href="/public/css/connexion.css"> <!-- Lien vers le fichier CSS -->
    <script src="https://kit.fontawesome.com/a81368914c.js"></script> <!-- Lien vers FontAwesome pour les icônes -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Rendre la page responsive -->
</head>
<body>
    <img class="wave" src="/public/images/connexion_image/wave.png"> <!-- 'wave' : classe pour styliser l'image de la vague en fond ou en haut de page -->
    <div class="container"> <!-- 'container' : classe qui englobe le contenu principal de la page -->
        <div class="img">
            <img src="/public/images/connexion_image/bg.svg"> <!-- 'img' : classe pour styliser la section contenant l'image -->
        </div>
        <div class="login-content"> <!-- 'login-content' : classe pour styliser la zone contenant le formulaire de connexion -->
            <form action="" method="POST"> <!-- Formulaire de connexion -->
                <img src="/public/images/connexion_image/avatar.svg"> <!-- Image de l'avatar placée au-dessus du formulaire -->
                <h2 class="title">Ecole de la Réussite</h2> <!-- 'title' : classe pour styliser le titre du formulaire -->

                <?php
                // Affichage du message d'erreur en cas d'échec de connexion
                if (isset($errorMessage)) {
                    echo "<p style='color:red;'>$errorMessage</p>"; // Message d'erreur en rouge
                }
                ?>

                <div class="input-div one"> <!-- 'input-div' : classe pour styliser les conteneurs de champ de saisie, 'one' peut être utilisée pour les distinguer s'il y a plusieurs éléments -->
                    <div class="i">
                        <i class="fas fa-user"></i> <!-- Icône d'utilisateur (FontAwesome) -->
                    </div>
                    <div class="div"> <!-- 'div' : classe probablement utilisée pour styliser les éléments d'entrée -->
                        <h5>Email</h5> <!-- Libellé pour le champ de saisie de l'email -->
                        <input type="text" class="input" name="email" required> <!-- 'input' : classe pour styliser le champ de saisie de l'email -->
                    </div>
                </div>
                <div class="input-div pass"> <!-- 'input-div' : classe pour styliser le champ de mot de passe, 'pass' pour indiquer que c'est pour le mot de passe -->
                    <div class="i"> 
                        <i class="fas fa-lock"></i> <!-- Icône de cadenas (FontAwesome) -->
                    </div>
                    <div class="div"> <!-- 'div' : classe pour styliser le conteneur du champ -->
                        <h5>Mot de Passe</h5> <!-- Libellé pour le champ de mot de passe -->
                        <input type="password" class="input" name="password" required> <!-- 'input' : classe pour styliser le champ de saisie du mot de passe -->
                    </div>
                </div>
                <a href="#">Mot de passe oublié ?</a> <!-- Lien pour le mot de passe oublié -->
                <input type="submit" class="btn" value="Login"> <!-- 'btn' : classe pour styliser le bouton de connexion -->
            </form>
        </div>
    </div>
    <script src="/public/js/connexion.js"></script> <!-- Inclusion du fichier JavaScript 'main.js' -->
</body>
</html>
