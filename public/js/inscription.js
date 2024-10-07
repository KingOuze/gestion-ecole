function toggleFields() {
    const role = document.getElementById('role').value;
    const autresInfosDiv = document.getElementById('autresInfos');
    const eleveFields = document.getElementById('eleveFields');
    const professeurFields = document.getElementById('professeurFields');
    const surveillantFields = document.getElementById('surveillantFields');
    const enseignantFields = document.getElementById('enseignantFields');




    autresInfosDiv.style.display = 'none'; // Masquer par défaut
    eleveFields.style.display = 'none'; // Masquer les champs élève
    professeurFields.style.display = 'none'; // Masquer les champs professeur
    surveillantFields.style.display = 'none'; // Masquer les champs professeur
    enseignantFields.style.display = 'none'; // Masquer les champs professeur



    if (role === 'enseignant') {
        enseignantFields.style.display = 'block'; 
    } else if (role === 'eleve') {
        eleveFields.style.display = 'block'; // Afficher les champs élève
    } else if (role === 'professeur') {
        professeurFields.style.display = 'block'; // Afficher les champs professeur
    } else if (role === 'surveillant') {
        surveillantFields.style.display = 'block'; // Afficher les champs élève
    }
}

function validateForm() {
    // Effacer les messages d'erreur précédents
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(el => el.textContent = '');

    const nom = document.getElementById('FormControlInput1').value.trim();
    const prenom = document.getElementById('FormControlInput2').value.trim();
    const email = document.getElementById('FormControlInput3').value.trim();
    const motDePasse = document.querySelector('input[name="motDePasse"]').value.trim();
    const telephone = document.querySelector('input[name="telephone"]').value.trim();
    const adresse = document.querySelector('input[name="adresse"]').value.trim();
    const role = document.getElementById('role').value;

    // Validation des champs requis
    if (!nom) {
        document.getElementById('errorNom').textContent = "Le nom est requis.";
        return false;
    }
    if (!prenom) {
        document.getElementById('errorPrenom').textContent = "Le prénom est requis.";
        return false;
    }
    if (!email) {
        document.getElementById('errorEmail').textContent = "L'email est requis.";
        return false;
    }
    if (!motDePasse) {
        document.getElementById('errorMotDePasse').textContent = "Le mot de passe est requis.";
        return false;
    }
    if (!telephone) {
        document.getElementById('errorTelephone').textContent = "Le téléphone est requis.";
        return false;
    }
    if (!adresse) {
        document.getElementById('errorAdresse').textContent = "L'adresse est requise.";
        return false;
    }

    // Validation de l'email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById('errorEmail').textContent = "Veuillez entrer un email valide.";
        return false;
    }

    // Validation du numéro de téléphone
    const telephoneRegex = /^\d{9}$/; // Exemple pour un numéro de téléphone à 9 chiffres
    if (!telephoneRegex.test(telephone)) {
        document.getElementById('errorTelephone').textContent = "Veuillez entrer un numéro de téléphone valide (9 chiffres).";
        return false;
    }

    // Validation des champs spécifiques selon le rôle
    if (role === 'eleve') {
        const dateNaissance = document.querySelector('input[name="dateNaissance"]').value.trim();
        const classe = document.querySelector('input[name="classe"]').value.trim();
        const numerotuteur = document.querySelector('input[name="numerotuteur"]').value.trim();

        if (!dateNaissance) {
            document.getElementById('errorDateNaissance').textContent = "La date de naissance est requise.";
            return false;
        }
        if (!classe) {
            document.getElementById('errorClasseEleve').textContent = "La classe est requise.";
            return false;
        }
        if (!numerotuteur) {
            document.getElementById('errorNumerotuteur').textContent = "Le numéro de tuteur est requis.";
            return false;
        }
    } else if (role === 'professeur') {
        const matiereField = document.querySelector('select[name="matieres[]"]');
        const classeField = document.querySelector('select[name="classesProfesseur[]"]');
    
        if (matiereField && classeField) {
            const matieres = matiereField.selectedOptions;
            const classesProfesseur = classeField.selectedOptions;
    
            if (matieres.length === 0) {
                document.getElementById('errorMatiere').textContent = "Au moins une matière est requise.";
                return false;
            }
            if (classesProfesseur.length === 0) {
                document.getElementById('errorClasseProfesseur').textContent = "Au moins une classe est requise.";
                return false;
            }

      
    }

    // Si toutes les validations passent
    return true;
}
}

// let matriculeCounter = 1; // Compteur pour les matricules

// function generateMatricule() {
//     const prefix = 'ADM-'; // Préfixe pour le matricule
//     const paddedCounter = String(matriculeCounter).padStart(3, '0'); // Ajouter des zéros devant pour avoir toujours 3 chiffres
//     return prefix + paddedCounter; // Générer le matricule final
// }



function ajouter() {
    // Récupérez les informations de l'administrateur ici

    const matricule = generateMatricule(); // Générer un nouveau matricule
    matriculeCounter++; // Incrémenter le compteur pour le prochain matricule

    // Ici, vous pouvez maintenant utiliser le matricule pour enregistrer l'administrateur
    console.log("Matricule généré : " + matricule);


}
 //l'visualiser le mot de passe
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('motDePasse');
    const eyeIcon = document.getElementById('eyeIcon');

    // Toggle le type de champ
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});


// Modifie le formulaire pour utiliser la fonction validateForm
document.querySelector('form').onsubmit = function() {
    return validateForm();
}