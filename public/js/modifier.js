document.getElementById("adminForm").addEventListener("submit", function(event) { 
    let valid = true;

    // Récupérer les valeurs des champs
    const nom = document.getElementById('FormControlInput1').value.trim();
    const prenom = document.getElementById('FormControlInput2').value.trim();
    const email = document.getElementById('FormControlInput3').value.trim();
    const telephone = document.getElementById('FormControlInput4').value.trim();
    const ancienMotDePasse = document.getElementById('ancienMotDePasse').value.trim();
    const nouveauMotDePasse = document.getElementById('nouveauMotDePasse').value.trim();
    const confirmerMotDePasse = document.getElementById('confirmerMotDePasse').value.trim();
    
    // Réinitialiser les messages d'erreur
    document.getElementById('errorNom').textContent = "";
    document.getElementById('errorPrenom').textContent = "";
    document.getElementById('errorEmail').textContent = "";
    document.getElementById('errorTelephone').textContent = "";
    document.getElementById('errorMotDePasse').textContent = "";
    document.getElementById('errorMotDePasseConfirmer').textContent = "";

    // Fonction pour valider que le champ n'est pas vide ou composé uniquement d'espaces
    function isEmptyOrSpaces(str) {
        return str === "" || !str.trim();
    }

    // Validation des champs requis
    if (isEmptyOrSpaces(nom)) {
        document.getElementById('errorNom').textContent = "Le nom est requis.";
        valid = false;
    }
    if (isEmptyOrSpaces(prenom)) {
        document.getElementById('errorPrenom').textContent = "Le prénom est requis.";
        valid = false;
    }
    if (isEmptyOrSpaces(email)) {
        document.getElementById('errorEmail').textContent = "L'email est requis.";
        valid = false;
    }
    if (isEmptyOrSpaces(telephone)) {
        document.getElementById('errorTelephone').textContent = "Le téléphone est requis.";
        valid = false;
    }

     // Vérifier si l'ancien mot de passe est saisi
    if (ancienMotDePasse !== "") {
        // Rendre les champs nouveau mot de passe et confirmer obligatoires
        if (isEmptyOrSpaces(nouveauMotDePasse)) {
            document.getElementById('errorMotDePasse').textContent = "Le nouveau mot de passe est requis.";
            valid = false;
        }
        if (isEmptyOrSpaces(confirmerMotDePasse)) {
            document.getElementById('errorMotDePasseConfirmer').textContent = "La confirmation du mot de passe est requise.";
            valid = false;
        }

        // Vérifier si les mots de passe correspondent
        if (nouveauMotDePasse !== confirmerMotDePasse) {
            document.getElementById('errorMotDePasseConfirmer').textContent = "Les mots de passe ne correspondent pas.";
            valid = false;
        }
    }

    // Si le formulaire n'est pas valide, empêcher la soumission
    if (!valid) {
        event.preventDefault();
    }
});
if (isEmptyOrSpaces(confirmerMotDePasse)) {
    document.getElementById('errorMotDePasseConfirmer').textContent = "La confirmation du mot de passe est requise.";
    valid = false;
}