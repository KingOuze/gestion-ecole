let userId;
let userRole;

function confirmDelete(id, role, prenom, nom, telephone, email) {
    userId = id;
    userRole = role;

    // Afficher les informations de l'utilisateur dans le modal
    document.getElementById('userInfo').innerHTML = `
        <strong>Prénom:</strong> ${prenom}<br>
        <strong>Nom:</strong> ${nom}<br>
        <strong>Téléphone:</strong> ${telephone}<br>
        <strong>Email:</strong> ${email}
    `;

    // Ouvrir le modal
    $('#confirmModal').modal('show');
}

document.getElementById('confirmArchive').onclick = function() {
    window.location.href = '/gestion-ecole/public/index.php?action=archive&role=' + userRole + '&id=' + userId;
}
// Ajouter un event listener au bouton de confirmation après le chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    const confirmButton = document.getElementById('confirmArchive');
    if (confirmButton) {
        confirmButton.addEventListener('click', function() {
            // Redirection vers le contrôleur d'archivage
            window.location.href = '/gestion-ecole/public/index.php?action=archive&role=' + userRole + '&id=' + userId;
        });
    }
});