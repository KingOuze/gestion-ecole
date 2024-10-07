<?php
require_once __DIR__ . '/../models/DashboardModel.php'; // Chemin corrigé

class DashboardController {
    private $model;

    public function __construct() {
        $this->model = new DashboardModel();
    }

    public function index() {
        // Récupérer les statistiques du modèle
        $data = $this->model->getCounts();

        // Inclure la vue du tableau de bord
        require_once __DIR__ . '/../views/dashboard.php'; // Assurez-vous que le chemin est correct
    }
}
?>

