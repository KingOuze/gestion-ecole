function confirmDelete(matricule) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette soumission ?")) {
        window.location.href = 'supprimer.php?matricule=' + matricule;
    }
}
