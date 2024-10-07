function confirmArchive(matricule) {
    if (confirm("Êtes-vous sûr de vouloir archiver cet administrateur ?")) {
        window.location.href = 'supprimer.php?matricule=' + matricule;
    }
}