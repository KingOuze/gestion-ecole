document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        let match = false;

        for (let i = 0; i < cells.length; i++) {
            if (cells[i].textContent.toLowerCase().includes(filter)) {
                match = true;
                break;
            }
        }
        row.style.display = match ? '' : 'none';
    });
});
document.getElementById('monthSelect').addEventListener('change', function() {
    const selectedMonth = this.value;
    const rows = document.querySelectorAll('#tableau tbody tr');

    rows.forEach(row => {
        const moisCell = row.cells[3]; // La colonne "Mois" est à l'index 3
        if (moisCell) {
            // Affiche la ligne si le mois correspond à la sélection ou si aucune sélection
            if (selectedMonth === '' || moisCell.textContent === selectedMonth) {
                row.style.display = ''; // Affiche la ligne
            } else {
                row.style.display = 'none'; // Cache la ligne
            }
        }
    });
});
