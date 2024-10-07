<?php
include '..app/models/DashboardModel.php'; // Inclure le modèle

class SurveillantsController {
    public function show() {
        $model = new DashboardModel(); // Créer une instance du modèle
        $surveillants = $model->getSurveillants(); // Récupérer les surveillants
        include '..app/views/gestion_surveillants.php'; // Afficher la vue des surveillants
    }
}
?>