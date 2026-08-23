@extends('layouts.app')

@section('title', 'Saisir une Vente')

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title">Enregistrer une Vente</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Saisissez le client, attachez son logo et ajoutez les articles commandés</p>
    </div>
    <div>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
            Annuler
        </a>
    </div>
</div>

<form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" id="order-form">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
        
        <!-- Customer Section -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title">Informations Client</h3>
            
            <div class="form-group">
                <label class="form-label">Type de Client</label>
                <div style="display: flex; gap: 20px; margin-top: 5px;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <input type="radio" name="customer_type" value="existing" checked onchange="switchCustomerType('existing')" style="accent-color: var(--primary);">
                        Client existant
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <input type="radio" name="customer_type" value="new" onchange="switchCustomerType('new')" style="accent-color: var(--primary);">
                        Nouveau Client
                    </label>
                </div>
            </div>

            <!-- Existing Customer -->
            <div id="existing-customer-group" class="form-group">
                <label class="form-label" for="customer_id">Sélectionner le Client</label>
                <select name="customer_id" id="customer_id" class="form-control">
                    <option value="">-- Choisir un client --</option>
                    @foreach($customers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->name }} ({{ $cust->phone ?? 'sans tel' }})</option>
                    @endforeach
                </select>
            </div>

            <!-- New Customer Inline Form -->
            <div id="new-customer-group" style="display: none; border-top: 1px dashed var(--border-color); padding-top: 1rem; margin-top: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="customer_name">Nom Complet</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Nom et Prénom">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="customer_phone">Téléphone</label>
                        <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="06XXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="customer_email">Adresse Email</label>
                        <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="client@email.com">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="customer_address">Adresse de livraison complète</label>
                    <textarea name="customer_address" id="customer_address" rows="2" class="form-control" placeholder="Adresse complète..."></textarea>
                </div>
            </div>
        </div>

        <!-- Payments and Logo Attachment -->
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title">Détails Commande, Avances & Logo</h3>
            
            <div class="form-group">
                <label class="form-label" for="logo">Logo Personnalisé (À projeter)</label>
                <input type="file" name="logo" id="logo" class="form-control">
                <small style="color: var(--text-secondary); margin-top: 5px; display: block;">Joignez l'image du logo fourni par le client. Format : PNG/JPG/WebP/SVG.</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="advance_cash">Avance en Espèces (DH)</label>
                    <input type="number" step="0.01" name="advance_cash" id="advance_cash" class="form-control" value="0.00" min="0" oninput="calculateBalance()">
                </div>
                <div class="form-group">
                    <label class="form-label" for="advance_transfer">Avance par Virement (DH)</label>
                    <input type="number" step="0.01" name="advance_transfer" id="advance_transfer" class="form-control" value="0.00" min="0" oninput="calculateBalance()">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="delivery_date">Date de livraison prévue</label>
                    <input type="date" name="delivery_date" id="delivery_date" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label" for="status">Statut Initial</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending">En attente (Acompte non validé)</option>
                        <option value="confirmed">Confirmé (Envoyer au fournisseur)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Instructions / Personnalisations particulières</label>
                <textarea name="notes" id="notes" rows="2" class="form-control" placeholder="Spécifiez la couleur de projection, lentille rotative..."></textarea>
            </div>
        </div>

    </div>

    <!-- Products Selector Panel -->
    <div class="glass-card">
        <h3 class="card-title">
            <span>Articles commandés</span>
            <button type="button" class="btn btn-secondary btn-sm" onclick="addProductRow()">
                <i class="fa-solid fa-plus"></i> Ajouter un article
            </button>
        </h3>

        <div class="table-responsive">
            <table class="table" id="items-table">
                <thead>
                    <tr>
                        <th style="width: 45%;">Produit</th>
                        <th style="width: 15%;">Quantité</th>
                        <th style="width: 20%;">Prix Unitaire (DH)</th>
                        <th style="width: 20%;">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="items-tbody">
                    <!-- Rows will be injected by JavaScript -->
                </tbody>
            </table>
        </div>

        <div style="display: flex; flex-direction: column; align-items: flex-end; margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; gap: 8px;">
            <div style="font-size: 1.15rem; font-weight: 700; color: var(--text-primary);">Total commande : <span id="summary-total-ttc">0,00</span> DH</div>
            <div style="font-size: 1rem; color: var(--warning);">Total Avances : <span id="summary-advances" style="font-weight: 700;">0,00</span> DH</div>
            <div style="font-size: 1.4rem; color: var(--primary); font-weight: 800; border-top: 1px dashed var(--border-color); padding-top: 8px; margin-top: 4px;">Solde Restant : <span id="summary-remaining">0,00</span> DH</div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 2rem; padding: 1rem; font-size: 1.1rem;">
            Enregistrer et Valider la Commande <i class="fa-solid fa-file-invoice"></i>
        </button>
    </div>
</form>
@endsection

@section('scripts')
<script>
    // List of active products passed to Javascript
    const availableProducts = {!! json_encode($products) !!};
    let rowId = 0;

    function switchCustomerType(type) {
        const existingGrp = document.getElementById('existing-customer-group');
        const newGrp = document.getElementById('new-customer-group');
        
        const customerIdInput = document.getElementById('customer_id');
        const customerNameInput = document.getElementById('customer_name');

        if (type === 'existing') {
            existingGrp.style.display = 'block';
            newGrp.style.display = 'none';
            customerNameInput.removeAttribute('required');
            customerIdInput.setAttribute('required', 'required');
        } else {
            newGrp.style.display = 'block';
            existingGrp.style.display = 'none';
            customerIdInput.removeAttribute('required');
            customerNameInput.setAttribute('required', 'required');
        }
    }

    function addProductRow() {
        const tbody = document.getElementById('items-tbody');
        const tr = document.createElement('tr');
        tr.id = `row-${rowId}`;
        
        let productOptions = '<option value="">-- Choisir un produit --</option>';
        availableProducts.forEach(prod => {
            productOptions += `<option value="${prod.id}" data-price="${prod.price}" data-stock="${prod.stock}">${prod.name} (Code: ${prod.code}) - Stock: ${prod.stock}</option>`;
        });

        tr.innerHTML = `
            <td>
                <select name="items[${rowId}][product_id]" class="form-control" onchange="updateRowPrice(${rowId}, this)" required>
                    ${productOptions}
                </select>
            </td>
            <td>
                <input type="number" name="items[${rowId}][quantity]" class="form-control" value="1" min="1" oninput="calculateRowTotal(${rowId})" required>
            </td>
            <td>
                <input type="number" step="0.01" name="items[${rowId}][unit_price]" class="form-control" value="0.00" min="0" oninput="calculateRowTotal(${rowId})" required>
            </td>
            <td>
                <span id="row-total-${rowId}" style="font-weight: 600;">0,00</span> DH
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProductRow(${rowId})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        rowId++;
    }

    function removeProductRow(id) {
        const row = document.getElementById(`row-${id}`);
        if (row) {
            row.remove();
        }
        calculateBalance();
    }

    function updateRowPrice(id, selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const priceInput = document.querySelector(`input[name="items[${id}][unit_price]"]`);
        const qtyInput = document.querySelector(`input[name="items[${id}][quantity]"]`);
        
        if (selectedOption && selectedOption.dataset.price) {
            const price = parseFloat(selectedOption.dataset.price);
            priceInput.value = price.toFixed(2);
            
            // limit quantity by stock
            const maxStock = parseInt(selectedOption.dataset.stock);
            qtyInput.setAttribute('max', maxStock);
        } else {
            priceInput.value = '0.00';
        }
        calculateRowTotal(id);
    }

    function calculateRowTotal(id) {
        const qtyInput = document.querySelector(`input[name="items[${id}][quantity]"]`);
        const priceInput = document.querySelector(`input[name="items[${id}][unit_price]"]`);
        const totalSpan = document.getElementById(`row-total-${id}`);
        
        const qty = parseInt(qtyInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = qty * price;
        
        totalSpan.textContent = total.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        calculateBalance();
    }

    function calculateBalance() {
        let totalHt = 0;
        
        // Sum all rows
        for (let i = 0; i < rowId; i++) {
            const qtyInput = document.querySelector(`input[name="items[${i}][quantity]"]`);
            const priceInput = document.querySelector(`input[name="items[${i}][unit_price]"]`);
            if (qtyInput && priceInput) {
                const qty = parseInt(qtyInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                totalHt += qty * price;
            }
        }

        const totalTtc = totalHt;

        const advanceCash = parseFloat(document.getElementById('advance_cash').value) || 0;
        const advanceTransfer = document.getElementById('advance_transfer') ? (parseFloat(document.getElementById('advance_transfer').value) || 0) : 0;
        const totalAdvances = advanceCash + advanceTransfer;
        
        const remaining = Math.max(0, totalTtc - totalAdvances);

        if (document.getElementById('summary-total-ht')) {
            document.getElementById('summary-total-ht').textContent = totalHt.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
        if (document.getElementById('summary-tva')) {
            document.getElementById('summary-tva').textContent = "0,00";
        }
        document.getElementById('summary-total-ttc').textContent = totalTtc.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('summary-advances').textContent = totalAdvances.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('summary-remaining').textContent = remaining.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.addEventListener('DOMContentLoaded', () => {
        switchCustomerType('existing');
        // Add first item row automatically
        addProductRow();
    });
</script>
@endsection
