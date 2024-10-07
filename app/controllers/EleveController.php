<?php
include '..app/models/DashboardModel.php'; // Inclure le modèle

class ElevesController {
    public function show() {
        $model = new DashboardModel(); // Créer une instance du modèle
        $eleves = $model->getEleves(); // Récupérer les élèves
        include '..app/views/gestion_eleves.php'; // Afficher la vue des élèves
    }
}
?>