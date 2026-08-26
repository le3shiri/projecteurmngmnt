@extends('layouts.app')

@section('title', 'Éditeur de Document - ' . strtoupper($type) . ' ' . $order->code)

@section('content')
<div class="header-bar" style="margin-bottom: 1.5rem;">
    <div>
        <h1 class="page-title"><i class="fa-solid fa-pen-to-square"></i> Édition Manuelle - {{ strtoupper($type) }} {{ $order->code }}</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Modifiez les champs du document en direct avant impression ou téléchargement PDF</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Retour à la Commande
        </a>
        <button type="button" onclick="window.print()" class="btn btn-secondary">
            <i class="fa-solid fa-print"></i> Imprimer
        </button>
        <button type="submit" form="doc-editor-form" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Télécharger le PDF
        </button>
    </div>
</div>

<form id="doc-editor-form" action="{{ route('orders.document.generate', [$order->id, $type]) }}" method="POST">
    @csrf

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="no-print">
        
        <!-- Left Column: Editable Controls -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Document Meta Card -->
            <div class="glass-card" style="margin: 0;">
                <h3 class="card-title"><i class="fa-solid fa-file-invoice" style="color: var(--primary);"></i> En-tête du Document</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="doc_number">Numéro du Document</label>
                        <input type="text" name="doc_number" id="doc_number" class="form-control" value="{{ $order->code }}" oninput="updateLivePreview()">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="doc_date">Date d'émission</label>
                        <input type="date" name="doc_date" id="doc_date" class="form-control" value="{{ $order->created_at->format('Y-m-d') }}" onchange="updateLivePreview()">
                    </div>
                </div>
            </div>

            <!-- Emitter Card -->
            <div class="glass-card" style="margin: 0;">
                <h3 class="card-title"><i class="fa-solid fa-building" style="color: var(--info);"></i> Informations Émetteur (Votre Entreprise)</h3>
                <div class="form-group" style="margin-bottom: 10px;">
                    <label class="form-label" for="emitter_name">Nom Entreprise</label>
                    <input type="text" name="emitter_name" id="emitter_name" class="form-control" value="Projecteur CRM Inc." oninput="updateLivePreview()">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="emitter_subtitle">Activité / Sous-titre</label>
                        <input type="text" name="emitter_subtitle" id="emitter_subtitle" class="form-control" value="Boutique physique et en ligne" oninput="updateLivePreview()">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emitter_country">Pays / Région</label>
                        <input type="text" name="emitter_country" id="emitter_country" class="form-control" value="Maroc" oninput="updateLivePreview()">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="emitter_phone">Téléphone</label>
                        <input type="text" name="emitter_phone" id="emitter_phone" class="form-control" value="+212 600-000000" oninput="updateLivePreview()">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emitter_email">Email</label>
                        <input type="email" name="emitter_email" id="emitter_email" class="form-control" value="contact@projecteurlogo.com" oninput="updateLivePreview()">
                    </div>
                </div>
            </div>

            <!-- Client Card -->
            <div class="glass-card" style="margin: 0;">
                <h3 class="card-title"><i class="fa-solid fa-user" style="color: var(--warning);"></i> Informations Client (Saisissable en Arabe/Français)</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="customer_name">Nom complet du client</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ $order->customer->name ?? '' }}" oninput="updateLivePreview()" dir="auto">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="customer_company">Société / Organisme</label>
                        <input type="text" name="customer_company" id="customer_company" class="form-control" value="{{ $order->customer->company ?? '' }}" oninput="updateLivePreview()" dir="auto">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="customer_phone">Téléphone</label>
                        <input type="text" name="customer_phone" id="customer_phone" class="form-control" value="{{ $order->customer->phone ?? '' }}" oninput="updateLivePreview()">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="customer_email">Email</label>
                        <input type="text" name="customer_email" id="customer_email" class="form-control" value="{{ $order->customer->email ?? '' }}" oninput="updateLivePreview()">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="customer_address">Adresse complète</label>
                    <textarea name="customer_address" id="customer_address" class="form-control" rows="2" oninput="updateLivePreview()" dir="auto">{{ $order->customer->address ?? '' }}</textarea>
                </div>
            </div>

            <!-- Articles Card -->
            <div class="glass-card" style="margin: 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 class="card-title" style="margin: 0;"><i class="fa-solid fa-boxes-stacked" style="color: var(--success);"></i> Lignes du Document</h3>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="addEditorRow()">
                        <i class="fa-solid fa-plus"></i> Ajouter une ligne
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table" style="font-size: 0.85rem;">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Code</th>
                                <th style="width: 40%;">Désignation</th>
                                <th style="width: 15%;">Qté</th>
                                <th style="width: 25%;">Prix (DH)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="editor-items-tbody">
                            @foreach($order->items as $index => $item)
                                <tr id="edit-row-{{ $index }}">
                                    <td>
                                        <input type="text" name="items[{{ $index }}][code]" class="form-control item-code" value="{{ $item->product_code }}" oninput="updateLivePreview()">
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $index }}][name]" class="form-control item-name" value="{{ $item->product_name }}" oninput="updateLivePreview()" dir="auto">
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $index }}][quantity]" class="form-control item-qty" value="{{ $item->quantity }}" min="1" oninput="updateLivePreview()">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="items[{{ $index }}][unit_price]" class="form-control item-price" value="{{ $item->unit_price }}" min="0" oninput="updateLivePreview()">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeEditorRow({{ $index }})"><i class="fa-solid fa-times"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- TVA Toggle Section -->
                <div style="margin-top: 1rem; padding: 1rem; background: rgba(15,23,42,0.5); border: 1px solid var(--border-color); border-radius: 10px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 0;">
                        <!-- Toggle Switch -->
                        <label style="position: relative; display: inline-block; width: 48px; height: 26px; cursor: pointer; flex-shrink: 0;">
                            <input type="checkbox" id="tva_toggle" onchange="toggleTva(this.checked)" style="opacity:0; width:0; height:0;">
                            <span id="tva_toggle_slider" style="
                                position: absolute; cursor: pointer;
                                top: 0; left: 0; right: 0; bottom: 0;
                                background: #374151;
                                transition: 0.3s; border-radius: 26px;
                            ">
                                <span style="
                                    position: absolute; content: '';
                                    height: 18px; width: 18px;
                                    left: 4px; bottom: 4px;
                                    background: #9ca3af;
                                    transition: 0.3s; border-radius: 50%;
                                    display: block;
                                "></span>
                            </span>
                        </label>
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">Appliquer la TVA</div>
                            <div style="font-size: 0.78rem; color: var(--text-secondary);">Par défaut : prix HT uniquement, sans TVA</div>
                        </div>
                    </div>

                    <!-- TVA Fields (hidden by default) -->
                    <div id="tva_fields" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px dashed var(--border-color);">
                        <div class="form-row">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="tva_rate">Taux TVA (%)</label>
                                <input type="number" step="0.1" name="tva_rate" id="tva_rate" class="form-control" value="20" oninput="updateLivePreview()" placeholder="Ex: 20">
                            </div>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 8px; margin-bottom: 0;">
                            <i class="fa-solid fa-circle-info"></i>
                            Les prix saisis dans le tableau sont considérés comme <strong>Prix HT</strong>.
                            La TVA sera calculée automatiquement.
                        </p>
                    </div>
                </div>

                <!-- Hidden field to always send tva_rate=0 when toggle is OFF -->
                <input type="hidden" id="tva_rate_hidden" name="tva_rate" value="0">

                <div class="form-row" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label class="form-label" for="advances">Acomptes Versés (DH)</label>
                        <input type="number" step="0.01" name="advances" id="advances" class="form-control" value="{{ $order->advance_cash + $order->advance_transfer }}" oninput="updateLivePreview()">
                    </div>
                </div>

            </div>

        </div>

        <!-- Right Column: Real-time Live Document Preview -->
        <div style="position: sticky; top: 20px; height: fit-content;">
            <div class="glass-card" style="margin: 0; background: #ffffff; color: #111827; box-shadow: 0 10px 25px rgba(0,0,0,0.3); border-radius: 12px; padding: 2rem;">
                <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; font-weight: bold; margin-bottom: 1rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; display: flex; justify-content: space-between; align-items: center;">
                    <span><i class="fa-solid fa-eye"></i> Aperçu du document en direct</span>
                    <span class="badge badge-confirmed" style="font-size: 0.7rem;">Format A4 Impression</span>
                </div>

                <!-- Document Body Container for Print/Preview -->
                <div id="document-preview-container" style="font-family: 'Inter', sans-serif; font-size: 13px; line-height: 1.4; color: #1f2937;">
                    
                    <!-- Header -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <div>
                            @if(file_exists(public_path('logo.png')))
                                <img src="{{ asset('logo.png') }}" style="max-height: 50px; width: auto;" alt="Logo">
                            @else
                                <div style="font-size: 20px; font-weight: 800; color: #2563eb;">PROJECTEUR LOGO</div>
                            @endif
                        </div>
                        <div style="text-align: right;">
                            <div id="preview-doc-title" style="font-size: 18px; font-weight: 800; color: #2563eb; text-transform: uppercase;">
                                {{ strtoupper($type) }} N° {{ $order->code }}
                            </div>
                            <div id="preview-doc-date" style="font-size: 12px; color: #4b5563; margin-top: 3px;">
                                Date: {{ $order->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>

                    <div style="border-bottom: 2px solid #2563eb; margin-bottom: 20px;"></div>

                    <!-- Emitter & Client -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <div>
                            <div style="font-size: 10px; font-weight: bold; color: #4b5563; text-transform: uppercase; margin-bottom: 5px;">ÉMETTEUR</div>
                            <div id="preview-emitter-name" style="font-weight: bold; font-size: 13px; color: #111827;">Projecteur CRM Inc.</div>
                            <div id="preview-emitter-subtitle" style="font-size: 12px; color: #4b5563;">Boutique physique et en ligne</div>
                            <div id="preview-emitter-country" style="font-size: 12px; color: #4b5563;">Maroc</div>
                            <div style="font-size: 12px; color: #4b5563;">Tél: <span id="preview-emitter-phone">+212 600-000000</span></div>
                            <div style="font-size: 12px; color: #4b5563;">Email: <span id="preview-emitter-email">contact@projecteurlogo.com</span></div>
                        </div>
                        <div>
                            <div style="font-size: 10px; font-weight: bold; color: #4b5563; text-transform: uppercase; margin-bottom: 5px;">CLIENT</div>
                            <div id="preview-client-name" style="font-weight: bold; font-size: 13px; color: #111827;">{{ $order->customer->name ?? '' }}</div>
                            <div id="preview-client-company" style="font-size: 12px; color: #4b5563;">{{ $order->customer->company ? 'Société: ' . $order->customer->company : '' }}</div>
                            <div style="font-size: 12px; color: #4b5563;">Tél: <span id="preview-client-phone">{{ $order->customer->phone ?? '' }}</span></div>
                            <div style="font-size: 12px; color: #4b5563;">Email: <span id="preview-client-email">{{ $order->customer->email ?? '' }}</span></div>
                            <div style="font-size: 12px; color: #4b5563;">Adresse: <span id="preview-client-address">{{ $order->customer->address ?? '' }}</span></div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                        <thead>
                            <tr style="background: #f3f4f6; text-transform: uppercase; font-size: 10px; color: #374151;">
                                <th style="padding: 8px; text-align: left; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">RÉF</th>
                                <th style="padding: 8px; text-align: left; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">DÉSIGNATION</th>
                                <th style="padding: 8px; text-align: center; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">QTÉ</th>
                                <th id="preview-pu-header" style="padding: 8px; text-align: right; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">P.U (DH)</th>
                                <th style="padding: 8px; text-align: right; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">TOTAL (DH)</th>
                            </tr>
                        </thead>
                        <tbody id="preview-items-tbody">
                            <!-- Injected by JavaScript -->
                        </tbody>
                    </table>

                    <!-- Totals -->
                    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                        <table style="width: 50%; border-collapse: collapse; font-size: 12px;">
                            <!-- Shown only when TVA is ON -->
                            <tr id="row-total-ht" style="display: none;">
                                <td style="padding: 4px 8px; font-weight: bold; color: #374151;">Total HT:</td>
                                <td style="padding: 4px 8px; text-align: right;" id="preview-total-ht">0,00 DH</td>
                            </tr>
                            <tr id="row-tva" style="display: none;">
                                <td style="padding: 4px 8px; font-weight: bold; color: #374151;">TVA (<span id="preview-tva-rate">0</span>%):</td>
                                <td style="padding: 4px 8px; text-align: right;" id="preview-tva-amount">0,00 DH</td>
                            </tr>
                            <!-- Always shown -->
                            <tr style="font-weight: bold; font-size: 13px; color: #111827;">
                                <td style="padding: 4px 8px;" id="preview-total-label">Total Commande:</td>
                                <td style="padding: 4px 8px; text-align: right;" id="preview-total-ttc">0,00 DH</td>
                            </tr>
                            <tr style="color: #059669; font-weight: bold;">
                                <td style="padding: 4px 8px;">Acomptes versés:</td>
                                <td style="padding: 4px 8px; text-align: right;" id="preview-advances">0,00 DH</td>
                            </tr>
                            <tr style="font-size: 14px; font-weight: bold; color: #2563eb; border-top: 2px solid #2563eb; border-bottom: 2px solid #2563eb;">
                                <td style="padding: 8px;">Reste à régler:</td>
                                <td style="padding: 8px; text-align: right;" id="preview-remaining">0,00 DH</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Somme en lettre -->
                    <div style="background-color: #f9fafb; border: 1px solid #f3f4f6; border-left: 4px solid #d1d5db; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                        <div style="font-size: 9px; font-weight: bold; color: #374151; text-transform: uppercase;">LA SOMME EN LETTRE</div>
                        <div id="preview-words" style="font-size: 11px; font-weight: bold; font-style: italic; color: #1f2937; margin-top: 2px;">CALCUL EN COURS...</div>
                    </div>

                    <!-- Footer -->
                    <div style="margin-top: 25px; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 10px;">
                        <p style="margin: 0;">Merci pour votre confiance. Projecteur Logo — Boutique physique et en ligne.</p>
                        <p style="font-size: 8px; margin: 2px 0 0 0; color: #d1d5db;">Document généré automatiquement via la plateforme CRM Projecteur.</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</form>
@endsection

@section('scripts')
<script>
    let editorRowIndex = {{ count($order->items) }};
    let tvaEnabled = false;

    // Style constants for the toggle
    const SLIDER_ON_BG  = 'var(--primary, #d4af37)';
    const SLIDER_OFF_BG = '#374151';
    const KNOB_ON_COLOR = '#ffffff';
    const KNOB_OFF_COLOR = '#9ca3af';

    function toggleTva(enabled) {
        tvaEnabled = enabled;

        // Visual toggle styling
        const sliderEl = document.getElementById('tva_toggle_slider');
        const knobEl   = sliderEl ? sliderEl.querySelector('span') : null;
        if (sliderEl) sliderEl.style.background = enabled ? SLIDER_ON_BG : SLIDER_OFF_BG;
        if (knobEl) {
            knobEl.style.transform  = enabled ? 'translateX(22px)' : 'translateX(0)';
            knobEl.style.background = enabled ? KNOB_ON_COLOR : KNOB_OFF_COLOR;
        }

        // Show / hide the TVA fields
        document.getElementById('tva_fields').style.display = enabled ? 'block' : 'none';

        // Manage the form input names so only one tva_rate is submitted
        const tvaRateInput   = document.getElementById('tva_rate');
        const hiddenTvaInput = document.getElementById('tva_rate_hidden');
        if (tvaRateInput) {
            tvaRateInput.disabled = !enabled; // disabled fields are excluded from POST
        }
        hiddenTvaInput.disabled = enabled; // the hidden 0-value field is only active when toggle is OFF

        updateLivePreview();
    }

    function addEditorRow() {
        const tbody = document.getElementById('editor-items-tbody');
        const tr = document.createElement('tr');
        tr.id = `edit-row-${editorRowIndex}`;
        tr.innerHTML = `
            <td>
                <input type="text" name="items[${editorRowIndex}][code]" class="form-control item-code" value="ART-${editorRowIndex+1}" oninput="updateLivePreview()">
            </td>
            <td>
                <input type="text" name="items[${editorRowIndex}][name]" class="form-control item-name" value="Nouvelle prestation" oninput="updateLivePreview()" dir="auto">
            </td>
            <td>
                <input type="number" name="items[${editorRowIndex}][quantity]" class="form-control item-qty" value="1" min="1" oninput="updateLivePreview()">
            </td>
            <td>
                <input type="number" step="0.01" name="items[${editorRowIndex}][unit_price]" class="form-control item-price" value="100.00" min="0" oninput="updateLivePreview()">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeEditorRow(${editorRowIndex})"><i class="fa-solid fa-times"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
        editorRowIndex++;
        updateLivePreview();
    }

    function removeEditorRow(index) {
        const row = document.getElementById(`edit-row-${index}`);
        if (row) {
            row.remove();
        }
        updateLivePreview();
    }

    function formatDateDisplay(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        if (parts.length === 3) {
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        }
        return dateStr;
    }

    function updateLivePreview() {
        // Document Header
        const docNum = document.getElementById('doc_number').value || '{{ $order->code }}';
        const docDate = formatDateDisplay(document.getElementById('doc_date').value);
        const docType = '{{ strtoupper($type) }}';
        
        document.getElementById('preview-doc-title').textContent = `${docType} N° ${docNum}`;
        document.getElementById('preview-doc-date').textContent = `Date: ${docDate}`;

        // Emitter
        document.getElementById('preview-emitter-name').textContent = document.getElementById('emitter_name').value || 'Projecteur CRM Inc.';
        document.getElementById('preview-emitter-subtitle').textContent = document.getElementById('emitter_subtitle').value || '';
        document.getElementById('preview-emitter-country').textContent = document.getElementById('emitter_country').value || '';
        document.getElementById('preview-emitter-phone').textContent = document.getElementById('emitter_phone').value || '';
        document.getElementById('preview-emitter-email').textContent = document.getElementById('emitter_email').value || '';

        // Client
        document.getElementById('preview-client-name').textContent = document.getElementById('customer_name').value || '';
        const comp = document.getElementById('customer_company').value;
        document.getElementById('preview-client-company').textContent = comp ? `Société: ${comp}` : '';
        document.getElementById('preview-client-phone').textContent = document.getElementById('customer_phone').value || '';
        document.getElementById('preview-client-email').textContent = document.getElementById('customer_email').value || '';
        document.getElementById('preview-client-address').textContent = document.getElementById('customer_address').value || '';

        // Rows
        const tbody = document.getElementById('preview-items-tbody');
        tbody.innerHTML = '';

        let totalHt = 0;
        const rows = document.querySelectorAll('#editor-items-tbody tr');

        rows.forEach(tr => {
            const code = tr.querySelector('.item-code').value || '';
            const name = tr.querySelector('.item-name').value || '';
            const qty = parseInt(tr.querySelector('.item-qty').value) || 0;
            const price = parseFloat(tr.querySelector('.item-price').value) || 0;
            const rowTotal = qty * price;
            totalHt += rowTotal;

            const ptr = document.createElement('tr');
            ptr.style.borderBottom = '1px solid #f3f4f6';
            ptr.innerHTML = `
                <td style="padding: 8px; color: #6b7280; font-size: 11px;">${code}</td>
                <td style="padding: 8px;">${name}</td>
                <td style="padding: 8px; text-align: center;">${qty}</td>
                <td style="padding: 8px; text-align: right;">${price.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                <td style="padding: 8px; text-align: right; font-weight: bold;">${rowTotal.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            `;
            tbody.appendChild(ptr);
        });

        // Totals — respect TVA toggle
        let tvaRate   = 0;
        let tvaAmount = 0;
        let totalTtc  = totalHt;

        if (tvaEnabled) {
            const tvaRateInput = document.getElementById('tva_rate');
            tvaRate   = parseFloat(tvaRateInput ? tvaRateInput.value : 0) || 0;
            tvaAmount = totalHt * (tvaRate / 100);
            totalTtc  = totalHt + tvaAmount;
        }

        const advances  = parseFloat(document.getElementById('advances').value) || 0;
        const remaining = Math.max(0, totalTtc - advances);

        // Toggle visibility of HT / TVA rows
        document.getElementById('row-total-ht').style.display = tvaEnabled ? 'table-row' : 'none';
        document.getElementById('row-tva').style.display      = tvaEnabled ? 'table-row' : 'none';

        // Update preview table header
        document.getElementById('preview-pu-header').textContent = tvaEnabled ? 'P.U HT (DH)' : 'P.U (DH)';
        document.getElementById('preview-total-label').textContent = tvaEnabled ? 'Total TTC:' : 'Total Commande:';

        document.getElementById('preview-total-ht').textContent    = totalHt.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';
        document.getElementById('preview-tva-rate').textContent    = tvaRate;
        document.getElementById('preview-tva-amount').textContent  = tvaAmount.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';
        document.getElementById('preview-total-ttc').textContent   = totalTtc.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';
        document.getElementById('preview-advances').textContent    = advances.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';
        document.getElementById('preview-remaining').textContent   = remaining.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH';

        const wordsLabel = tvaEnabled ? 'TOTAL TTC' : 'TOTAL';
        document.getElementById('preview-words').textContent = `${wordsLabel}: ${totalTtc.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} DH`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Ensure hidden field active & TVA rate input disabled on load
        document.getElementById('tva_rate').disabled        = true;
        document.getElementById('tva_rate_hidden').disabled = false;
        updateLivePreview();
    });
</script>
@endsection
