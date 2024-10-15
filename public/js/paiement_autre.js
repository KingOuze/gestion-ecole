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
});