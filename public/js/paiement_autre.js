document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="matricule"]');
    const resultsTable = document.getElementById('results-table');
    const searchButton = document.querySelector('.search-button');

    // Affiche ou cache le tableau des résultats en fonction de l'entrée
    input.addEventListener('input', function() {
        resultsTable.style.display = input.value.trim() === '' ? 'none' : 'table';
    });

    // Gestion des changements de statut de paiement
    const statusSelects = document.querySelectorAll('.payment-status');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const receiptButton = select.closest('tr').querySelector('.btn-receipt');
            receiptButton.style.display = select.value === "paid" ? 'inline-block' : 'none';
        });
    });


        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('input[name="matricule"]');
            const resultsTable = document.getElementById('results-table');

            input.addEventListener('input', function() {
                resultsTable.style.display = input.value.trim() === '' ? 'none' : 'table';
            });

            const statusSelects = document.querySelectorAll('.payment-status');

            statusSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const receiptButton = select.closest('tr').querySelector('.btn-receipt');

                    if (select.value === "paid") {
                        receiptButton.style.display = 'inline-block';
                    } else {
                        receiptButton.style.display = 'none';
                    }
                });
            });

            document.querySelectorAll('.btn-receipt').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const matricule = row.children[0].textContent;
                    const nom = row.children[1].textContent;
                    const prenom = row.children[2].textContent;
                    const montant = row.children[5].textContent;
                    const date = new Date().toLocaleDateString('fr-FR');
                    const mois = new Intl.DateTimeFormat('fr-FR', { month: 'long' }).format(new Date());

                    document.getElementById('modal-matricule').textContent = matricule;
                    document.getElementById('modal-nom').textContent = `${nom} ${prenom}`;
                    document.getElementById('modal-montant').textContent = montant;
                    document.getElementById('modal-date').textContent = date;
                    document.getElementById('modal-mois').textContent = mois;

                    $('#receiptModal').modal('show');
                });
            });
        });

        document.getElementById('payer').addEventListener('click', function() {
            const matricule = document.getElementById('matricule').value;
            const nom = document.getElementById('nom').value;
            const prenom = document.getElementById('prenom').value;
            const montant = document.getElementById('montant').value;
            const mois = document.getElementById('mois').value;
        
            const formData = new FormData();
            formData.append('enregistrer', true);
            formData.append('matricule', matricule);
            formData.append('nom', nom);
            formData.append('prenom', prenom);
            formData.append('montant', montant);
            formData.append('mois', mois);
        
            fetch('/path/to/enregistrerPaiement', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Mettre à jour les informations du reçu
                    document.getElementById('modal-matricule').textContent = data.paiementInfo.matricule;
                    document.getElementById('modal-nom').textContent = data.paiementInfo.nom;
                    document.getElementById('modal-prenom').textContent = data.paiementInfo.prenom;
                    document.getElementById('modal-mois').textContent = data.paiementInfo.mois_payer;
                    document.getElementById('modal-montant').textContent = data.paiementInfo.montant;
        
                    // Afficher le modal du reçu
                    $('#recuModal').modal('show');
                } else {
                    console.error('Erreur lors de l\'enregistrement du paiement');
                }
            })
            .catch(error => {
                console.error('Erreur :', error);
            });
        });
        

    // Gestion de l'événement de clic sur le bouton de réception
    document.querySelectorAll('.btn-receipt').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const matricule = row.children[0].textContent;
            const nom = row.children[1].textContent;
            const prenom = row.children[2].textContent;
            const montant = row.children[5].textContent;
            const date = new Date().toLocaleDateString('fr-FR');
            const mois = new Intl.DateTimeFormat('fr-FR', { month: 'long' }).format(new Date());

            document.getElementById('modal-matricule').textContent = matricule;
            document.getElementById('modal-nom').textContent = `${nom} ${prenom}`;
            document.getElementById('modal-montant').textContent = montant;
            document.getElementById('modal-date').textContent = date;
            document.getElementById('modal-mois').textContent = mois;

            $('#receiptModal').modal('show');
        });
    });

    // Ajout de l'événement pour le bouton de recherche
    searchButton.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le formulaire de se soumettre
        const matricule = input.value;

        // Vérifiez que le matricule n'est pas vide
        if (matricule.trim() === "") {
            alert("Veuillez entrer un matricule.");
            return;
        }

        fetch(`search.php?matricule=${matricule}`)
            .then(response => response.json())
            .then(data => {
                const resultsTableBody = document.querySelector('#results-table tbody');
                resultsTableBody.innerHTML = ''; // Vider le tableau avant d'ajouter les résultats

                if (data.length === 0) {
                    resultsTableBody.innerHTML = '<tr><td colspan="7">Aucun résultat trouvé.</td></tr>';
                } else {
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.matricule}</td>
                            <td>${row.nom}</td>
                            <td>${row.prenom}</td>
                            <td>${new Date().toLocaleDateString('fr-FR')}</td>
                            <td>${new Intl.DateTimeFormat('fr-FR', { month: 'long' }).format(new Date())}</td>
                            <td>${row.montant}</td>
                            <td>
                                <select class="form-control payment-status">
                                    <option value="not-paid">Non payé</option>
                                    <option value="paid">Payer</option>
                                </select>
                                <button class="btn btn-primary btn-receipt" style="display: none;">Générer un reçu</button>
                            </td>
                        `;
                        resultsTableBody.appendChild(tr);
                    });
                }
            })
            .catch(error => console.error('Erreur:', error));
    });
    
    $(document).ready(function() {
        let numeroRecuCounter = 1; // Compteur pour le numéro de reçu
    
        $('.btn-receipt').on('click', function() {
            // Récupérer les données nécessaires pour le reçu
            var matricule = $(this).closest('tr').find('.payment-status').data('matricule');
            var nom = $(this).closest('tr').find('.payment-status').data('nom');
            var prenom = $(this).closest('tr').find('.payment-status').data('prenom');
            var montant = $(this).closest('tr').find('.payment-status').data('montant');
            var mois = $(this).closest('tr').find('.month-select').val();
            var date = new Date().toLocaleDateString(); // Date actuelle pour le reçu
    
            // Générer le numéro de reçu en l'incrémentant
            var numeroRecu = 'N-' + String(numeroRecuCounter).padStart(4, '0');
            numeroRecuCounter++; // Incrémenter le compteur
    
            // Convertir le mois en format lisible
            var moisNom = convertMonthToString(mois);
    
            // Remplir les données du reçu dans le modal
            $('#receiptModal .modal-body .bulletin-container #modal-matricule').text(matricule);
            $('#receiptModal .modal-body .bulletin-container #modal-nom').text(nom + ' ' + prenom);
            $('#receiptModal .modal-body .bulletin-container #modal-montant').text(montant + ' FCFA');
            $('#receiptModal .modal-body .bulletin-container #modal-mois').text(moisNom);
            $('#receiptModal .modal-body .bulletin-container .date-reçu div:first-child span').text(date);
            $('#receiptModal .modal-body .bulletin-container .date-reçu div:last-child').text('Reçu : ' + numeroRecu);
    
            // Afficher le modal
            $('#receiptModal').modal('show');
        });
    
        // Fonction pour convertir le mois en chaîne lisible
        function convertMonthToString(mois) {
            const moisNoms = [
                "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
                "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
            ];
            return moisNoms[mois - 1]; // Assurez-vous que 'mois' est un nombre de 1 à 12
        }
    });
    
    
        document.addEventListener('DOMContentLoaded', function() {
            let currentRow;
    
            // Gérer l'affichage de la section d'image et du tableau
            function toggleImageAndTable() {
                const imageSection = document.getElementById('image-section');
                const resultsTable = document.getElementById('results-table');
    
                // Si le tableau existe et qu'il a des lignes, on masque l'image
                if (resultsTable && resultsTable.style.display !== 'none') {
                    imageSection.style.display = 'none'; // Masquer l'image si le tableau est visible
                } else {
                    imageSection.style.display = 'block'; // Afficher l'image si le tableau est masqué
                }
            }
    
            // Appel initial pour définir l'affichage
            toggleImageAndTable();
    
            // Événement pour le champ matricule
            const matriculeInput = document.querySelector('input[name="matricule"]');
            matriculeInput.addEventListener('input', function() {
                if (!this.value.trim()) { // Si le champ est vide
                    toggleImageAndTable(); // Met à jour l'affichage
                }
            });
    
            // Événement pour le bouton de recherche
            document.querySelector('form').addEventListener('submit', function() {
                toggleImageAndTable(); // Met à jour l'affichage lors de la soumission
            });
    
            document.querySelectorAll('.payment-status').forEach(select => {
                select.addEventListener('change', function() {
                    const selectedValue = this.value;
                    currentRow = this.closest('tr');
    
                    if (selectedValue === 'payer') {
                        $('#paymentConfirmationModal').modal('show');
                    } else if (selectedValue === 'deja-paye') {
                        const receiptButton = currentRow.querySelector('.btn-receipt');
                        receiptButton.style.display = 'inline-block';
                    } else {
                        const receiptButton = currentRow.querySelector('.btn-receipt');
                        receiptButton.style.display = 'none';
                    }
                });
            });
    
            document.getElementById('confirmPaymentButton').addEventListener('click', function() {
        const matricule = currentRow.querySelector('.payment-status').dataset.matricule;
        const nom = currentRow.querySelector('.payment-status').dataset.nom;
        const prenom = currentRow.querySelector('.payment-status').dataset.prenom;
        const montant = currentRow.querySelector('.payment-status').dataset.montant;
        const mois = currentRow.querySelector('.month-select').value;
    
        const form = new FormData();
        form.append('matricule', matricule);
        form.append('nom', nom);
        form.append('prenom', prenom);
        form.append('montant', montant);
        form.append('mois', mois);
        form.append('enregistrer', true);
    
        fetch(window.location.href, {
            method: 'POST',
            body: form
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                $('#paymentConfirmationModal').modal('hide');
    
                // Afficher le modal de succès
                const currentTime = new Date();
                const formattedDateTime = currentTime.toLocaleString('fr-FR'); // Format français
                document.getElementById('successMessage').textContent = 'Le paiement a été enregistré avec succès.';
                document.getElementById('currentDateTime').textContent = formattedDateTime;
                $('#paymentSuccessModal').modal('show');
    
                // Mettre à jour la ligne après la fermeture du modal de succès
                $('#paymentSuccessModal').on('hidden.bs.modal', function () {
                    const paymentStatusSelect = currentRow.querySelector('.payment-status');
                    paymentStatusSelect.value = 'deja-paye'; // Mettre à jour le sélecteur
                    const receiptButton = currentRow.querySelector('.btn-receipt');
                    receiptButton.style.display = 'inline-block'; // Afficher le bouton "Générer un reçu"
                });
            } else {
                $('#paymentAlreadyExistsModal').modal('show');
                document.getElementById('existingPaymentMessage').textContent = data.message;
            }
        });
    });
    
            document.getElementById('printReceiptButton').addEventListener('click', function() {
                window.print();
            });
        });
});