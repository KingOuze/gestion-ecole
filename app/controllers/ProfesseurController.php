<?php
include '..app/models/DashboardModel.php'; // Inclure le modèle

class ProfesseursController {
    public function show() {
        $model = new DashboardModel(); // Créer une instance du modèle
        $professeurs = $model->getProfesseurs(); // Récupérer les professeurs
        include '..app/views/gestion_professeurs.php'; // Afficher la vue des professeurs
    }
}
?>