document.querySelectorAll('.data-link').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page
        const type = this.getAttribute('data-type');

        fetch(`?action=getData&type=${type}`)
            .then(response => response.json())
            .then(data => {
                const dataTable = document.getElementById("data-table");
                dataTable.innerHTML = ''; // Vider le tableau avant d'ajouter les nouveaux éléments

                data.forEach(item => {
                    const card = document.createElement('div');
                    card.className = 'card'; // Classe pour la carte
                    card.innerHTML = `
                        <h3>${item.name}</h3>  <!-- Remplacez 'name' par la propriété appropriée -->
                        <p>${item.details}</p>  <!-- Remplacez 'details' par la propriété appropriée -->
                    `;
                    dataTable.appendChild(card);
                });
            });
    });
});

// Gestion du bouton de déconnexion
document.getElementById("logout").addEventListener("click", function() {
    window.location.href = '/logout.php'; // Rediriger vers la page de déconnexion
});