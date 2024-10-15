<?php
session_start();

// Activer les erreurs pour le débogage
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
        // Récupérer les détails du paiement en fonction du matricule
        $paiement = $this->paieModel->obtenirPaiementParMatricule($matricule);

        if (empty($paiement)) {
            echo "Erreur : Professeur non trouvé.";
            return;
        }

        // Vérifier si le paiement a déjà été effectué pour le mois spécifié
        if ($this->paieModel->verifierPaiement($paiement['id_admin'], $mois)) {
            echo "Le professeur a déjà été payé pour ce mois.";
            return;
        }

        // Effectuer le paiement en mettant à jour le statut
        $this->paieModel->payerProfesseur($paiement['id_admin'], $mois);
        echo "Le professeur " . htmlspecialchars($paiement['prenom']) . " " . htmlspecialchars($paiement['nom']) . " a été payé pour le mois de " . htmlspecialchars($mois) . ".";
    }

    // Annuler un paiement
    public function annulerPaiement($matricule, $mois) {
        // Récupérer les détails du paiement en fonction du matricule
        $paiement = $this->paieModel->obtenirPaiementParMatricule($matricule);

        if (empty($paiement)) {
            echo "Erreur : Professeur non trouvé.";
            return;
        }

        // Annuler le paiement pour le mois spécifié
        $this->paieModel->annulerPaiement($paiement['id_admin'], $mois);
        echo "Le paiement du professeur " . htmlspecialchars($paiement['prenom']) . " " . htmlspecialchars($paiement['nom']) . " pour le mois de " . htmlspecialchars($mois) . " a été annulé.";
    }

    // Obtenir les paiements des professeurs (recherche par matricule et/ou mois)
    public function obtenirPaiements($search = '', $mois = '') {
        // Obtenir la liste des paiements en fonction des critères de recherche
        return $this->paieModel->obtenirPaiements($search, $mois);
    }

    // Gestion des actions de paiement (payer/annuler) et récupération des paiements pour l'affichage
        public function gererPaiements() {
            // Vérification des requêtes POST pour paiement ou annulation
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['payer'])) {
                    $this->payer($_POST['matricule'], $_POST['mois']);
                } elseif (isset($_POST['annuler'])) {
                    $this->annulerPaiement($_POST['matricule'], $_POST['mois']);
                }
            }
        
            // Gestion des recherches via GET
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $mois = isset($_GET['mois']) ? $_GET['mois'] : ''; // Récupérer le mois
        
            // Vérification si le mois est vide
            if (empty($mois)) {
                echo "Erreur : Le mois n'est pas défini.";
                return; // Arrêtez l'exécution si le mois n'est pas défini
            }
        
            // Récupération des paiements en fonction des critères
            $paiements = $this->obtenirPaiements($search, $mois);
        
            // Inclure la vue et passer les variables nécessaires
            include __DIR__ . '/../views/paiement_view.php';
        }
    }