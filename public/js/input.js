document.addEventListener('DOMContentLoaded', function() {
    // Écouteur d'événement pour la barre de recherche
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableau tbody tr');

        rows.forEach(row => {
            const matriculeCell = row.cells[2]; // La colonne "Matricule" est à l'index 2
            if (matriculeCell) {
                // Affiche la ligne si le matricule correspond à la recherche ou si le champ est vide
                row.style.display = matriculeCell.textContent.toLowerCase().includes(filter) ? '' : 'none';
            }
        });
    });

    // Écouteur d'événement pour le sélecteur de mois
    document.getElementById('monthSelect').addEventListener('change', function() {
        const selectedMonth = this.value;
        const rows = document.querySelectorAll('#tableau tbody tr');

        rows.forEach(row => {
            const moisCell = row.cells[3]; // La colonne "Mois" est à l'index 3
            if (moisCell) {
                // Affiche la ligne si le mois correspond à la sélection ou si aucune sélection
                row.style.display = (selectedMonth === '' || moisCell.textContent === selectedMonth) ? '' : 'none';
            }
        });
    });
});
