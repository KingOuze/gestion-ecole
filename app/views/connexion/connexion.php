<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="/gestion-ecole/public/css/connexion.css">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <img class="wave" src="/gestion-ecole/public/images/connexion_image/wave.png">
    <div class="container">
        <div class="img">
            <img src="/gestion-ecole/public/images/connexion_image/bg.svg">
        </div>
        <div class="login-content">
            
        <form action="/gestion-ecole/app/controllers/ConnexionController.php" method="POST"> <!-- Appel au contrôleur -->

        
              <img src="/gestion-ecole/public/images/connexion_image/Badge_Education_Badge_Logo-removebg-preview.png" style="width: 150px; height: auto;">
    
                <h2 class="title">Ecole de la Réussite</h2>

                <?php if (isset($errorMessage)): ?>
                    <p style='color:red;'><?php echo $errorMessage; ?></p>
                <?php endif; ?>

                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input type="text" class="input" name="email" required>
                    </div>
                </div>
                <div class="input-div pass">
    <div class="i">
        <i class="fas fa-lock"></i>
    </div>
    <div class="div">
        <h5>Mot de Passe</h5>
        <input type="password" class="input" name="password" id="password" required>
        <i class="fas fa-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"></i>
    </div>
</div>

                <input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script src="/gestion-ecole/public/js/connexion.js"></script>
</body>
</html>
