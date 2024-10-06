// Sélectionner tous les éléments ayant la classe "input"
const inputs = document.querySelectorAll(".input");

// Fonction pour ajouter la classe "focus" au parent de l'input
function addcl() {
    // Obtenir le parent du parent (c'est-à-dire l'élément contenant l'input)
    let parent = this.parentNode.parentNode;
    // Ajouter la classe "focus" au parent
    parent.classList.add("focus");
}

// Fonction pour retirer la classe "focus" du parent si l'input est vide
function remcl() {
    // Obtenir le parent du parent (c'est-à-dire l'élément contenant l'input)
    let parent = this.parentNode.parentNode;
    // Vérifier si la valeur de l'input est vide
    if (this.value == "") {
        // Retirer la classe "focus" du parent si l'input est vide
        parent.classList.remove("focus");
    }
}

// Parcourir tous les inputs sélectionnés
inputs.forEach(input => {
    // Ajouter un événement "focus" pour déclencher la fonction addcl lors de la mise au point de l'input
    input.addEventListener("focus", addcl);
    // Ajouter un événement "blur" pour déclencher la fonction remcl lors de la perte du focus de l'input
    input.addEventListener("blur", remcl);
});

// Ajouter la logique pour basculer l'affichage du mot de passe une fois que le DOM est chargé
document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    // Vérifier si les éléments existent avant d'ajouter des écouteurs d'événements
    if (togglePassword && password) {
        // Ajouter un gestionnaire d'événement pour l'icône
        togglePassword.addEventListener('click', function () {
            // Basculer le type d'entrée entre "password" et "text"
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Basculer l'icône entre eye et eye-slash
            this.classList.toggle('fa-eye-slash');
        });
    }
});
