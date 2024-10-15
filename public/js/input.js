document.addEventListener('DOMContentLoaded', function() {
    // Lorsque la page est complètement chargée, exécuter ce code.
    
    // Écouteur d'événement pour la barre de recherche (pour filtrer les lignes du tableau par matricule)
    document.getElementById('searchInput').addEventListener('keyup', function() {
        // Récupère la valeur saisie dans la barre de recherche et la convertit en minuscules pour rendre la recherche insensible à la casse
        const filter = this.value.toLowerCase();
        
        // Sélectionne toutes les lignes du tableau, dans le corps du tableau (tbody)
        const rows = document.querySelectorAll('#tableau tbody tr');

        // Parcourt chaque ligne du tableau
        rows.forEach(row => {
            // Récupère la cellule qui contient le "Matricule", ici c'est la colonne 3 (index 2)
            const matriculeCell = row.cells[2]; // La colonne "Matricule" est à l'index 2
            
            if (matriculeCell) {
                // Si le contenu de la cellule matricule contient le texte recherché, on affiche la ligne.
                // Sinon, on la masque.
                row.style.display = matriculeCell.textContent.toLowerCase().includes(filter) ? '' : 'none';
            }
        });
    });

    // Écouteur d'événement pour le sélecteur de mois (pour filtrer les lignes du tableau par mois)
    document.getElementById('monthSelect').addEventListener('change', function() {
        // Récupère la valeur du mois sélectionné dans le menu déroulant
        const selectedMonth = this.value;
        
        // Sélectionne toutes les lignes du tableau, dans le corps du tableau (tbody)
        const rows = document.querySelectorAll('#tableau tbody tr');

        // Parcourt chaque ligne du tableau
        rows.forEach(row => {
            // Récupère la cellule qui contient le "Mois", ici c'est la colonne 4 (index 3)
            const moisCell = row.cells[3]; // La colonne "Mois" est à l'index 3
            
            if (moisCell) {
                // Si le mois dans la cellule correspond au mois sélectionné, ou si aucun mois n'est sélectionné (tous les mois affichés),
                // on affiche la ligne. Sinon, on la masque.
                row.style.display = (selectedMonth === '' || moisCell.textContent === selectedMonth) ? '' : 'none';
            }
        });
    });
});
