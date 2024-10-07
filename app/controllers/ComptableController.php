<?php
include '..app/models/DashboardModel.php'; // Inclure le modèle

class FinanceController {
    public function show() {
        $model = new DashboardModel(); // Créer une instance du modèle
        $finances = $model->getFinances(); // Récupérer les données financières
        include '..app/views/gestion_finance.php'; // Afficher la vue de la gestion financière
    }
}
?>