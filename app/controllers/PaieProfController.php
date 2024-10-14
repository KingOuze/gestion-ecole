<?php
session_start();

// EnseignantController
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../models/PaieModel.php'; 

class PaieProf {
    private $paieModel;

    public function __construct($db) {
        $this->paieModel = new Paie($db);
    }

    // Payer un professeur
    public function payer($matricule, $mois) {
        $paiement = $this->paieModel->obtenirPaiementParMatricule($matricule);

        if (empty($paiement)) {
            echo "Erreur : Professeur non trouvé.";
            return;
        }

        // Vérifier si déjà payé
        if ($this->paieModel->verifierPaiement($paiement['id_admin'], $mois)) {
            echo "Le professeur a déjà été payé pour ce mois.";
            return;
        }

        // Mettre à jour le statut de paiement
        $this->paieModel->payerProfesseur($paiement['id_admin'], $mois);
        echo "Le professeur " . htmlspecialchars($paiement['prenom']) . " " . htmlspecialchars($paiement['nom']) . " a été payé.";
    }

    // Annuler un paiement
    public function annulerPaiement($matricule, $mois) {
        $paiement = $this->paieModel->obtenirPaiementParMatricule($matricule);

        if (empty($paiement)) {
            echo "Erreur : Professeur non trouvé.";
            return;
        }

        // Annuler le paiement
        $this->paieModel->annulerPaiement($paiement['id_admin'], $mois);
        echo "Le paiement du professeur " . htmlspecialchars($paiement['prenom']) . " " . htmlspecialchars($paiement['nom']) . " a été annulé.";
    }

    // Méthode pour obtenir les paiements
    public function obtenirPaiements($search, $mois) {
        return $this->paieModel->obtenirPaiements($search, $mois);
    }
}
