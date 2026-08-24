@extends('layouts.app')

@section('title', 'Modifier Commande ' . $order->code)

@section('content')
<div class="header-bar">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-pen-to-square" style="color: var(--primary);"></i> Modifier la Commande</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">
            <strong style="color: var(--primary); font-family: monospace;">{{ $order->code }}</strong>
            &nbsp;— Créée le {{ $order->created_at->format('d/m/Y') }} par {{ $order->agent->name ?? 'Direct' }}
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Annuler
        </a>
    </div>
</div>

<form action="{{ route('orders.update', $order->id) }}" method="POST" enctype="multipart/form-data" id="order-edit-form">
    @csrf
    @method('PUT')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style: none; margin: 0; padding: 0;">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">

        {{-- ── Customer & Status ── --}}
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title"><i class="fa-solid fa-user" style="color: var(--primary);"></i> Client & Statut</h3>

            <div class="form-group">
                <label class="form-label" for="customer_id">Client</label>
                <select name="customer_id" id="customer_id" class="form-control" required>
                    <option value="">-- Choisir un client --</option>
                    @foreach($customers as $cust)
                        <option value="{{ $cust->id }}" {{ $order->customer_id == $cust->id ? 'selected' : '' }}>
                            {{ $cust->name }} ({{ $cust->phone ?? 'sans tel' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="status">Statut</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending"    {{ $order->status == 'pending'    ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed"  {{ $order->status == 'confirmed'  ? 'selected' : '' }}>Confirmée</option>
                        <option value="shipped"    {{ $order->status == 'shipped'    ? 'selected' : '' }}>Expédiée</option>
                        <option value="delivered"  {{ $order->status == 'delivered'  ? 'selected' : '' }}>Livrée</option>
                        <option value="cancelled"  {{ $order->status == 'cancelled'  ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="delivery_date">Date de livraison prévue</label>
                    <input type="date" name="delivery_date" id="delivery_date" class="form-control"
                           value="{{ $order->delivery_date ? $order->delivery_date->format('Y-m-d') : '' }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Instructions / Personnalisations</label>
                <textarea name="notes" id="notes" rows="3" class="form-control"
                          placeholder="Couleur de projection, lentille rotative...">{{ old('notes', $order->notes) }}</textarea>
            </div>
        </div>

        {{-- ── Logo & Advances ── --}}
        <div class="glass-card" style="margin: 0;">
            <h3 class="card-title"><i class="fa-solid fa-image" style="color: var(--primary);"></i> Logo & Avances</h3>

            {{-- Logo preview & replacement --}}
            <div class="form-group">
                <label class="form-label" for="logo">Logo Personnalisé</label>
                @if($order->logo_path)
                    <div style="background: #000; border-radius: 6px; padding: 10px; text-align: center; margin-bottom: 8px; border: 1px solid var(--border-color);">
                        <img src="{{ asset('public-storage/' . $order->logo_path) }}"
                             alt="Logo actuel"
                             style="max-height: 80px; max-width: 100%; object-fit: contain;">
                    </div>
                    <small style="color: var(--text-secondary); display: block; margin-bottom: 6px;">
                        <i class="fa-solid fa-circle-info"></i> Logo actuel affiché. Choisissez un nouveau fichier pour le remplacer.
                    </small>
                @endif
                <input type="file" name="logo" id="logo" class="form-control"
                       accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp">
                <small style="color: var(--text-secondary); margin-top: 4px; display: block;">Format : PNG/JPG/WebP/SVG. Max : 3 Mo</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="advance_cash">Avance en Espèces (DH)</label>
                    <input type="number" step="0.01" name="advance_cash" id="advance_cash"
                           class="form-control" min="0"
                           value="{{ old('advance_cash', number_format($order->advance_cash, 2, '.', '')) }}"
                           oninput="calculateBalance()">
                </div>
                <div class="form-group">
                    <label class="form-label" for="advance_transfer">Avance par Virement (DH)</label>
                    <input type="number" step="0.01" name="advance_transfer" id="advance_transfer"
                           class="form-control" min="0"
                           value="{{ old('advance_transfer', number_format($order->advance_transfer, 2, '.', '')) }}"
                           oninput="calculateBalance()">
                </div>
            </div>
        </div>
    </div>

    {{-- ── Articles / Items ── --}}
    <div class="glass-card">
        <h3 class="card-title" style="display: flex; justify-content: space-between; align-items: center;">
            <span><i class="fa-solid fa-boxes-packing" style="color: var(--primary);"></i> Articles Commandés</span>
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
                        <th style="width: 15%;">Total</th>
                        <th style="width: 5%;"></th>
                    </tr>
                </thead>
                <tbody id="items-tbody">
                    {{-- Pre-filled by JavaScript using existingItems --}}
                </tbody>
            </table>
        </div>

        <div style="display: flex; flex-direction: column; align-items: flex-end; margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; gap: 8px;">
            <div style="font-size: 1.15rem; font-weight: 700; color: var(--text-primary);">
                Total commande : <span id="summary-total-ttc">0,00</span> DH
            </div>
            <div style="font-size: 1rem; color: var(--warning);">
                Total Avances : <span id="summary-advances" style="font-weight: 700;">0,00</span> DH
            </div>
            <div style="font-size: 1.4rem; color: var(--primary); font-weight: 800; border-top: 1px dashed var(--border-color); padding-top: 8px; margin-top: 4px;">
                Solde Restant : <span id="summary-remaining">0,00</span> DH
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 2rem; padding: 1rem; font-size: 1.1rem;">
            <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
        </button>
    </div>
</form>
@endsection

@section('scripts')
<script>
    const availableProducts = {!! json_encode($products->map(function($p) {
        return ['id' => $p->id, 'name' => $p->name, 'code' => $p->code, 'price' => $p->price, 'stock' => $p->stock];
    })) !!};

    // Pre-load existing order items
    const existingItems = {!! json_encode($order->items->map(function($item) {
        return [
            'product_id' => $item->product_id,
            'product_name' => $item->product_name,
            'quantity' => $item->quantity,
            'unit_price' => (float)$item->unit_price,
        ];
    })) !!};

    let rowId = 0;

    function buildProductOptions(selectedId) {
        let html = '<option value="">-- Choisir un produit --</option>';
        availableProducts.forEach(prod => {
            const sel = (prod.id == selectedId) ? 'selected' : '';
            html += `<option value="${prod.id}" data-price="${prod.price}" data-stock="${prod.stock}" ${sel}>${prod.name} (${prod.code}) - Stock: ${prod.stock}</option>`;
        });
        return html;
    }

    function addProductRow(productId = null, quantity = 1, unitPrice = null) {
        const tbody = document.getElementById('items-tbody');
        const tr = document.createElement('tr');
        tr.id = `row-${rowId}`;

        tr.innerHTML = `
            <td>
                <select name="items[${rowId}][product_id]" class="form-control" onchange="updateRowPrice(${rowId}, this)" required>
                    ${buildProductOptions(productId)}
                </select>
            </td>
            <td>
                <input type="number" name="items[${rowId}][quantity]" class="form-control"
                       value="${quantity}" min="1" oninput="calculateRowTotal(${rowId})" required>
            </td>
            <td>
                <input type="number" step="0.01" name="items[${rowId}][unit_price]" class="form-control"
                       value="${unitPrice !== null ? unitPrice.toFixed(2) : '0.00'}" min="0"
                       oninput="calculateRowTotal(${rowId})" required>
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

        // Set stock limit if product is pre-selected
        if (productId) {
            const prod = availableProducts.find(p => p.id == productId);
            if (prod) {
                const qtyInput = tr.querySelector(`input[name="items[${rowId}][quantity]"]`);
                qtyInput.setAttribute('max', prod.stock + quantity); // allow current qty + available stock
            }
        }

        calculateRowTotal(rowId);
        rowId++;
    }

    function removeProductRow(id) {
        const row = document.getElementById(`row-${id}`);
        if (row) row.remove();
        calculateBalance();
    }

    function updateRowPrice(id, selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const priceInput = document.querySelector(`input[name="items[${id}][unit_price]"]`);
        const qtyInput   = document.querySelector(`input[name="items[${id}][quantity]"]`);

        if (selectedOption && selectedOption.dataset.price) {
            priceInput.value = parseFloat(selectedOption.dataset.price).toFixed(2);
            qtyInput.setAttribute('max', parseInt(selectedOption.dataset.stock));
        } else {
            priceInput.value = '0.00';
        }
        calculateRowTotal(id);
    }

    function calculateRowTotal(id) {
        const qtyInput   = document.querySelector(`input[name="items[${id}][quantity]"]`);
        const priceInput = document.querySelector(`input[name="items[${id}][unit_price]"]`);
        const totalSpan  = document.getElementById(`row-total-${id}`);

        if (!qtyInput || !priceInput || !totalSpan) return;
        const total = (parseInt(qtyInput.value) || 0) * (parseFloat(priceInput.value) || 0);
        totalSpan.textContent = total.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        calculateBalance();
    }

    function calculateBalance() {
        let totalHt = 0;
        for (let i = 0; i < rowId; i++) {
            const qtyInput   = document.querySelector(`input[name="items[${i}][quantity]"]`);
            const priceInput = document.querySelector(`input[name="items[${i}][unit_price]"]`);
            if (qtyInput && priceInput) {
                totalHt += (parseInt(qtyInput.value) || 0) * (parseFloat(priceInput.value) || 0);
            }
        }
        const advanceCash     = parseFloat(document.getElementById('advance_cash').value)    || 0;
        const advanceTransfer = parseFloat(document.getElementById('advance_transfer').value) || 0;
        const totalAdvances   = advanceCash + advanceTransfer;
        const remaining       = Math.max(0, totalHt - totalAdvances);

        document.getElementById('summary-total-ttc').textContent = totalHt.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('summary-advances').textContent  = totalAdvances.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('summary-remaining').textContent = remaining.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Pre-fill existing items
        existingItems.forEach(item => {
            addProductRow(item.product_id, item.quantity, item.unit_price);
        });
        // If no items, add an empty row
        if (existingItems.length === 0) {
            addProductRow();
        }
    });
</script>
@endsection
