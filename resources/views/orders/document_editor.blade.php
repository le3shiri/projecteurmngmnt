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
            
            <!-- Hidden inputs for all section states -->
            <input type="hidden" name="show_logo" id="show_logo" value="1">
            <input type="hidden" name="show_emitter" id="show_emitter" value="1">
            <input type="hidden" name="show_customer" id="show_customer" value="1">
            <input type="hidden" name="show_advances" id="show_advances" value="1">
            <input type="hidden" name="show_words" id="show_words" value="1">
            <input type="hidden" name="show_conditions" id="show_conditions" value="1">
            <input type="hidden" name="show_cachet" id="show_cachet" value="1">
            <input type="hidden" name="show_legal_footer" id="show_legal_footer" value="1">

            <!-- Master Section Visibility Control Panel -->
            <div class="glass-card" style="margin: 0; background: linear-gradient(135deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.85)); border: 1px solid rgba(212, 175, 55, 0.35);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h3 class="card-title" style="margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-sliders" style="color: var(--primary);"></i> Contrôle des Sections du Document
                        </h3>
                        <p style="font-size: 0.78rem; color: var(--text-secondary); margin: 3px 0 0 0;">
                            Activez ou masquez n'importe quelle section en 1 clic. L'aperçu et le PDF s'adaptent automatiquement.
                        </p>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="setAllSections(true)" style="font-size: 0.75rem; padding: 4px 10px;">
                            <i class="fa-solid fa-check-double"></i> Tout activer
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="setAllSections(false)" style="font-size: 0.75rem; padding: 4px 10px;">
                            <i class="fa-solid fa-ban"></i> Tout masquer
                        </button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <!-- 1. Logo -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-image" style="color: var(--primary); width: 16px;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary);">Logo Entreprise</span>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Logo">
                            <input type="checkbox" data-section-toggle="logo" checked onchange="toggleDocSection('logo', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="logo" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>

                    <!-- 2. Émetteur -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-building" style="color: var(--info); width: 16px;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary);">Émetteur</span>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Émetteur">
                            <input type="checkbox" data-section-toggle="emitter" checked onchange="toggleDocSection('emitter', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="emitter" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>

                    <!-- 3. Client -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-user" style="color: var(--warning); width: 16px;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary);">Client</span>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Client">
                            <input type="checkbox" data-section-toggle="customer" checked onchange="toggleDocSection('customer', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="customer" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>

                    <!-- 4. Acomptes & Solde -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-money-bill-wave" style="color: var(--success); width: 16px;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary);">Acomptes & Solde</span>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Acomptes & Solde">
                            <input type="checkbox" data-section-toggle="advances" checked onchange="toggleDocSection('advances', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="advances" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>

                    <!-- 5. Somme en lettres -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-spell-check" style="color: #a855f7; width: 16px;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary);">Somme en Lettres</span>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Somme en Lettres">
                            <input type="checkbox" data-section-toggle="words" checked onchange="toggleDocSection('words', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="words" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>

                    <!-- 6. Conditions & Délais -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-truck-fast" style="color: var(--primary); width: 16px;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary);">Conditions & Délais</span>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Conditions & Délais">
                            <input type="checkbox" data-section-toggle="conditions" checked onchange="toggleDocSection('conditions', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="conditions" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>

                    <!-- 7. Cachet & Signature -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-stamp" style="color: #ec4899; width: 16px;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary);">Cachet & Signature</span>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Cachet & Signature">
                            <input type="checkbox" data-section-toggle="cachet" checked onchange="toggleDocSection('cachet', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="cachet" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>

                    <!-- 8. Pied de page Légal -->
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-scale-balanced" style="color: #38bdf8; width: 16px;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary);">Pied de page légal / RIB</span>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Pied de page">
                            <input type="checkbox" data-section-toggle="legal_footer" checked onchange="toggleDocSection('legal_footer', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="legal_footer" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

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
            <div class="glass-card" id="card_emitter" style="margin: 0; transition: opacity 0.3s;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h3 class="card-title" style="margin: 0;"><i class="fa-solid fa-building" style="color: var(--info);"></i> Informations Émetteur (Votre Entreprise)</h3>
                    <label style="position: relative; display: inline-block; width: 48px; height: 26px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Désactiver Émetteur">
                        <input type="checkbox" data-section-toggle="emitter" checked onchange="toggleDocSection('emitter', this.checked)" style="opacity:0; width:0; height:0;">
                        <span data-section-slider="emitter" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 26px;">
                            <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 4px; bottom: 4px; transform: translateX(22px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                        </span>
                    </label>
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <label class="form-label" for="emitter_name">Nom Entreprise</label>
                    <input type="text" name="emitter_name" id="emitter_name" class="form-control" value="Projecteur LOGO" oninput="updateLivePreview()">
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <label class="form-label" for="emitter_address">Adresse</label>
                    <input type="text" name="emitter_address" id="emitter_address" class="form-control" value="Hay Nasr lot Oumnia num 27 magasin num 1 - Tanger." oninput="updateLivePreview()">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="emitter_phone">GSM / Téléphone</label>
                        <input type="text" name="emitter_phone" id="emitter_phone" class="form-control" value="+212607056637" oninput="updateLivePreview()">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emitter_email">E-mail</label>
                        <input type="email" name="emitter_email" id="emitter_email" class="form-control" value="worklogo47@gmail.com" oninput="updateLivePreview()">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="emitter_website">Site web</label>
                        <input type="text" name="emitter_website" id="emitter_website" class="form-control" value="www.projecteurlogo.com" oninput="updateLivePreview()">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emitter_ice">ICE</label>
                        <input type="text" name="emitter_ice" id="emitter_ice" class="form-control" value="0040525690000032" oninput="updateLivePreview()">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="emitter_if">IF</label>
                        <input type="text" name="emitter_if" id="emitter_if" class="form-control" value="73411678" oninput="updateLivePreview()">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emitter_tp">Taxe Professionnelle N°</label>
                        <input type="text" name="emitter_tp" id="emitter_tp" class="form-control" value="7210/2026/5669" oninput="updateLivePreview()">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="emitter_rib">RIB BMCE</label>
                    <input type="text" name="emitter_rib" id="emitter_rib" class="form-control" value="011 640 0000372100000583 28" oninput="updateLivePreview()">
                </div>
            </div>

            <!-- Client Card -->
            <div class="glass-card" id="card_customer" style="margin: 0; transition: opacity 0.3s;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h3 class="card-title" style="margin: 0;"><i class="fa-solid fa-user" style="color: var(--warning);"></i> Informations Client (Saisissable en Arabe/Français)</h3>
                    <label style="position: relative; display: inline-block; width: 48px; height: 26px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Désactiver Client">
                        <input type="checkbox" data-section-toggle="customer" checked onchange="toggleDocSection('customer', this.checked)" style="opacity:0; width:0; height:0;">
                        <span data-section-slider="customer" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 26px;">
                            <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 4px; bottom: 4px; transform: translateX(22px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                        </span>
                    </label>
                </div>
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
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="advances">Acomptes Versés (DH)</label>
                        <input type="number" step="0.01" name="advances" id="advances" class="form-control" value="{{ $order->advance_cash + $order->advance_transfer }}" oninput="updateLivePreview()">
                    </div>
                </div>

                <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 8px;">
                    <!-- Acomptes & Solde Toggle -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: rgba(15,23,42,0.4); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div>
                            <div style="font-weight: 600; font-size: 0.85rem; color: var(--text-primary);"><i class="fa-solid fa-money-bill-wave" style="color: var(--success); margin-right: 6px;"></i> Lignes Acomptes & Reste à régler</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary);">Afficher le détail des acomptes et du solde dans le récapitulatif</div>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Acomptes & Reste">
                            <input type="checkbox" data-section-toggle="advances" checked onchange="toggleDocSection('advances', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="advances" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>

                    <!-- Somme en lettres Toggle -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: rgba(15,23,42,0.4); border: 1px solid var(--border-color); border-radius: 8px;">
                        <div>
                            <div style="font-weight: 600; font-size: 0.85rem; color: var(--text-primary);"><i class="fa-solid fa-spell-check" style="color: #a855f7; margin-right: 6px;"></i> Bloc 'Somme en toutes lettres'</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary);">Afficher le montant écrit en lettres sous le tableau</div>
                        </div>
                        <label style="position: relative; display: inline-block; width: 44px; height: 24px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Masquer Somme en lettres">
                            <input type="checkbox" data-section-toggle="words" checked onchange="toggleDocSection('words', this.checked)" style="opacity:0; width:0; height:0;">
                            <span data-section-slider="words" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 24px;">
                                <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 3px; bottom: 3px; transform: translateX(20px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                            </span>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Conditions & Délais Card with Toggle Switch -->
            <div class="glass-card" id="card_conditions" style="margin: 0; transition: opacity 0.3s;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h3 class="card-title" style="margin: 0;"><i class="fa-solid fa-truck-fast" style="color: var(--primary);"></i> Conditions & Délais</h3>
                    
                    <!-- Toggle Switch -->
                    <label style="position: relative; display: inline-block; width: 48px; height: 26px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Désactiver les conditions">
                        <input type="checkbox" data-section-toggle="conditions" id="conditions_toggle" checked onchange="toggleDocSection('conditions', this.checked)" style="opacity:0; width:0; height:0;">
                        <span data-section-slider="conditions" id="conditions_toggle_slider" style="
                            position: absolute; cursor: pointer;
                            top: 0; left: 0; right: 0; bottom: 0;
                            background: var(--primary, #d4af37);
                            transition: 0.3s; border-radius: 26px;
                        ">
                            <span style="
                                position: absolute; content: '';
                                height: 18px; width: 18px;
                                left: 4px; bottom: 4px;
                                transform: translateX(22px);
                                background: #ffffff;
                                transition: 0.3s; border-radius: 50%;
                                display: block;
                            "></span>
                        </span>
                    </label>
                </div>

                <div id="conditions_toggle_hint" style="font-size: 0.8rem; color: var(--success); margin-bottom: 12px; font-weight: 500;">
                    <i class="fa-solid fa-circle-check"></i> Actif sur le document (cliquez sur l'interrupteur pour le retirer)
                </div>

                <div id="conditions_fields">
                    <div class="form-group" style="margin-bottom: 10px;">
                        <label class="form-label" for="condition_delivery">Délai de livraison</label>
                        <textarea name="condition_delivery" id="condition_delivery" rows="2" class="form-control" oninput="updateLivePreview()">Livraison sous 3 à 5 jours ouvrés après validation du devis et le versement de l'acompte.</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="condition_manufacturing">Condition de fabrication</label>
                        <textarea name="condition_manufacturing" id="condition_manufacturing" rows="2" class="form-control" oninput="updateLivePreview()">La personnalisation et la fabrication de votre logo débutent immédiatement dès réception d’un acompte de 10% du montant total.</textarea>
                    </div>
                </div>
            </div>

            <!-- Cachet & Signature Card with Toggle Switch -->
            <div class="glass-card" id="card_cachet" style="margin: 0; transition: opacity 0.3s;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h3 class="card-title" style="margin: 0;"><i class="fa-solid fa-stamp" style="color: var(--primary);"></i> Cachet & Signature</h3>
                    
                    <!-- Toggle Switch -->
                    <label style="position: relative; display: inline-block; width: 48px; height: 26px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Désactiver le cachet">
                        <input type="checkbox" data-section-toggle="cachet" id="cachet_toggle" checked onchange="toggleDocSection('cachet', this.checked)" style="opacity:0; width:0; height:0;">
                        <span data-section-slider="cachet" id="cachet_toggle_slider" style="
                            position: absolute; cursor: pointer;
                            top: 0; left: 0; right: 0; bottom: 0;
                            background: var(--primary, #d4af37);
                            transition: 0.3s; border-radius: 26px;
                        ">
                            <span style="
                                position: absolute; content: '';
                                height: 18px; width: 18px;
                                left: 4px; bottom: 4px;
                                transform: translateX(22px);
                                background: #ffffff;
                                transition: 0.3s; border-radius: 50%;
                                display: block;
                            "></span>
                        </span>
                    </label>
                </div>

                <div id="cachet_toggle_hint" style="font-size: 0.8rem; color: var(--success); margin-bottom: 10px; font-weight: 500;">
                    <i class="fa-solid fa-circle-check"></i> Cachet officiel actif (cliquez pour retirer)
                </div>

                <div id="cachet_preview_thumbnail" style="display: flex; align-items: center; gap: 12px; background: rgba(0,0,0,0.15); padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color);">
                    <img src="{{ $cachetBase64 ?? asset('cachet-removebg-preview.png') }}" style="max-height: 48px; width: auto; background: #fff; padding: 2px; border-radius: 4px;" alt="Aperçu Cachet">
                    <div style="font-size: 0.78rem; color: var(--text-secondary);">
                        Tampon officiel Projecteur LOGO avec ICE 0040525690000032 et signature.
                    </div>
                </div>
            </div>

            <!-- Pied de page Légal Card with Toggle Switch -->
            <div class="glass-card" id="card_legal_footer" style="margin: 0; transition: opacity 0.3s;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h3 class="card-title" style="margin: 0;"><i class="fa-solid fa-scale-balanced" style="color: #38bdf8;"></i> Pied de Page Légal (ICE, RIB BMCE)</h3>
                    <label style="position: relative; display: inline-block; width: 48px; height: 26px; cursor: pointer; flex-shrink: 0; margin: 0;" title="Activer / Désactiver le pied de page légal">
                        <input type="checkbox" data-section-toggle="legal_footer" checked onchange="toggleDocSection('legal_footer', this.checked)" style="opacity:0; width:0; height:0;">
                        <span data-section-slider="legal_footer" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--primary, #d4af37); transition: 0.3s; border-radius: 26px;">
                            <span style="position: absolute; content: ''; height: 18px; width: 18px; left: 4px; bottom: 4px; transform: translateX(22px); background: #ffffff; transition: 0.3s; border-radius: 50%; display: block;"></span>
                        </span>
                    </label>
                </div>
                <div id="legal_footer_toggle_hint" style="font-size: 0.8rem; color: var(--success); margin-bottom: 8px; font-weight: 500;">
                    <i class="fa-solid fa-circle-check"></i> Tableau légal officiel actif en bas de page
                </div>
                <div style="font-size: 0.78rem; color: var(--text-secondary); line-height: 1.5; background: rgba(0,0,0,0.15); padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color);">
                    Tableau 3 lignes : Adresse Tanger, E-mail, GSM, ICE 0040525690000032, IF 73411678, TP 7210/2026/5669 et RIB BMCE.
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
                        <div id="preview-header-logo">
                            @if(!empty($logoBase64))
                                <img src="{{ $logoBase64 }}" style="max-height: 50px; width: auto;" alt="Logo">
                            @elseif(file_exists(public_path('logo.png')))
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
                    <div id="preview-info-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <div id="preview-emitter-block">
                            <div style="font-size: 10px; font-weight: bold; color: #4b5563; text-transform: uppercase; margin-bottom: 5px;">ÉMETTEUR</div>
                            <div id="preview-emitter-name" style="font-weight: bold; font-size: 13px; color: #111827;">Projecteur LOGO</div>
                            <div id="preview-emitter-address" style="font-size: 12px; color: #4b5563;">Hay Nasr lot Oumnia num 27 magasin num 1 - Tanger.</div>
                            <div style="font-size: 12px; color: #4b5563;">GSM: <span id="preview-emitter-phone">+212607056637</span></div>
                            <div style="font-size: 12px; color: #4b5563;">Email: <span id="preview-emitter-email">worklogo47@gmail.com</span></div>
                            <div style="font-size: 12px; color: #4b5563;">Site web: <span id="preview-emitter-website">www.projecteurlogo.com</span></div>
                        </div>
                        <div id="preview-client-block">
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
                            <tr id="preview-row-advances" style="color: #059669; font-weight: bold;">
                                <td style="padding: 4px 8px;">Acomptes versés:</td>
                                <td style="padding: 4px 8px; text-align: right;" id="preview-advances">0,00 DH</td>
                            </tr>
                            <tr id="preview-row-remaining" style="font-size: 14px; font-weight: bold; color: #2563eb; border-top: 2px solid #2563eb; border-bottom: 2px solid #2563eb;">
                                <td style="padding: 8px;">Reste à régler:</td>
                                <td style="padding: 8px; text-align: right;" id="preview-remaining">0,00 DH</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Somme en lettre & Cachet Row -->
                    <div id="preview-words-cachet-row" style="display: flex; gap: 15px; margin-bottom: 15px; align-items: stretch;">
                        <div id="preview-words-container" style="flex: 1; background-color: #f9fafb; border: 1px solid #f3f4f6; border-left: 4px solid #d1d5db; padding: 10px; border-radius: 4px; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-size: 9px; font-weight: bold; color: #374151; text-transform: uppercase;">LA SOMME EN LETTRE</div>
                            <div id="preview-words" style="font-size: 11px; font-weight: bold; font-style: italic; color: #1f2937; margin-top: 2px;">CALCUL EN COURS...</div>
                        </div>
                        <div id="preview-cachet-container" style="width: 140px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <div style="font-size: 8.5px; font-weight: bold; color: #4b5563; text-transform: uppercase; margin-bottom: 3px;">Cachet et Signature</div>
                            <img src="{{ $cachetBase64 ?? asset('cachet-removebg-preview.png') }}" style="max-height: 100px; max-width: 130px; object-fit: contain;" alt="Cachet et Signature">
                        </div>
                    </div>

                    <!-- Additional Conditions Box -->
                    <div id="preview-conditions-box" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 3px solid #2563eb; padding: 8px 12px; border-radius: 4px; margin-top: 15px; margin-bottom: 15px; font-size: 11px; color: #334155; line-height: 1.5;">
                        <div style="font-size: 9px; font-weight: bold; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">INFORMATIONS & CONDITIONS DE COMMANDE</div>
                        <ul style="margin: 0; padding-left: 18px; font-size: 10.5px;">
                            <li id="preview-condition-delivery">Livraison sous 3 à 5 jours ouvrés après validation du devis et le versement de l'acompte.</li>
                            <li id="preview-condition-manufacturing">La personnalisation et la fabrication de votre logo débutent immédiatement dès réception d’un acompte de 10% du montant total.</li>
                        </ul>
                    </div>

                    <!-- Legal Footer Table (Identical to PDF) -->
                    <table id="preview-legal-footer-table" style="width: 100%; border-collapse: collapse; margin-top: 25px; border: 1px solid #d1d5db; font-size: 10px; text-align: center; color: #111827;">
                        <tr>
                            <td style="padding: 5px 8px; border: 1px solid #d1d5db; line-height: 1.45;">
                                <strong id="preview-foot-name">Projecteur LOGO</strong> - Adresse : <span id="preview-foot-address">Hay Nasr lot Oumnia num 27 magasin num 1 - Tanger.</span><br>
                                E-mail : <span id="preview-foot-email">worklogo47@gmail.com</span> - Site web : <span id="preview-foot-website">www.projecteurlogo.com</span> - GSM: <span id="preview-foot-phone">+212607056637</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 8px; border: 1px solid #d1d5db; line-height: 1.45;">
                                ICE : <span id="preview-foot-ice">0040525690000032</span> - IF : <span id="preview-foot-if">73411678</span> - Taxe Professionnelle N° : <span id="preview-foot-tp">7210/2026/5669</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 8px; border: 1px solid #d1d5db; line-height: 1.45;">
                                RIB BMCE : <span id="preview-foot-rib">011 640 0000372100000583 28</span>
                            </td>
                        </tr>
                    </table>

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

    // Master Section States
    const sectionStates = {
        logo: true,
        emitter: true,
        customer: true,
        advances: true,
        words: true,
        conditions: true,
        cachet: true,
        legal_footer: true
    };

    function toggleDocSection(sectionKey, enabled) {
        if (enabled === undefined) {
            sectionStates[sectionKey] = !sectionStates[sectionKey];
        } else {
            sectionStates[sectionKey] = !!enabled;
        }
        const state = sectionStates[sectionKey];

        // 1. Update hidden form input
        const inputEl = document.getElementById('show_' + sectionKey);
        if (inputEl) inputEl.value = state ? '1' : '0';

        // 2. Update any checkbox with data-section-toggle
        document.querySelectorAll(`[data-section-toggle="${sectionKey}"]`).forEach(cb => {
            cb.checked = state;
        });

        // 3. Update slider visuals
        document.querySelectorAll(`[data-section-slider="${sectionKey}"]`).forEach(slider => {
            slider.style.background = state ? SLIDER_ON_BG : SLIDER_OFF_BG;
            const knob = slider.querySelector('span');
            if (knob) {
                const shift = slider.style.width === '44px' || slider.offsetWidth <= 44 ? '20px' : '22px';
                knob.style.transform  = state ? `translateX(${shift})` : 'translateX(0)';
                knob.style.background = state ? KNOB_ON_COLOR : KNOB_OFF_COLOR;
            }
        });

        // 4. Update specific hint elements if present
        const hintEl = document.getElementById(sectionKey + '_toggle_hint');
        if (hintEl) {
            hintEl.style.color = state ? 'var(--success)' : 'var(--text-secondary)';
            if (sectionKey === 'cachet') {
                hintEl.innerHTML = state 
                    ? '<i class="fa-solid fa-circle-check"></i> Cachet officiel actif (cliquez pour retirer)' 
                    : '<i class="fa-solid fa-eye-slash"></i> Cachet retiré (cliquez pour réactiver)';
            } else if (sectionKey === 'conditions') {
                hintEl.innerHTML = state 
                    ? '<i class="fa-solid fa-circle-check"></i> Actif sur le document (cliquez sur l\'interrupteur pour le retirer)' 
                    : '<i class="fa-solid fa-eye-slash"></i> Retiré du document (cliquez pour réactiver)';
            } else if (sectionKey === 'legal_footer') {
                hintEl.innerHTML = state 
                    ? '<i class="fa-solid fa-circle-check"></i> Tableau légal officiel actif en bas de page' 
                    : '<i class="fa-solid fa-eye-slash"></i> Tableau légal masqué du document';
            }
        }

        // 5. Conditions fields display
        if (sectionKey === 'conditions') {
            const fieldsEl = document.getElementById('conditions_fields');
            if (fieldsEl) fieldsEl.style.display = state ? 'block' : 'none';
        }

        // 6. Cachet thumbnail opacity
        if (sectionKey === 'cachet') {
            const thumbEl = document.getElementById('cachet_preview_thumbnail');
            if (thumbEl) thumbEl.style.opacity = state ? '1' : '0.4';
        }

        // 7. Dim / highlight associated card
        const cardEl = document.getElementById('card_' + sectionKey);
        if (cardEl) {
            cardEl.style.opacity = state ? '1' : '0.45';
        }

        // 8. Apply visibility to Live Preview
        applySectionVisibility();
    }

    function setAllSections(enabled) {
        Object.keys(sectionStates).forEach(key => {
            toggleDocSection(key, enabled);
        });
    }

    // Backwards compatibility wrappers
    function toggleCachet(enabled) {
        toggleDocSection('cachet', enabled);
    }
    function toggleConditions(enabled) {
        toggleDocSection('conditions', enabled);
    }

    function applySectionVisibility() {
        // Logo
        const logoEl = document.getElementById('preview-header-logo');
        if (logoEl) logoEl.style.display = sectionStates.logo ? 'block' : 'none';

        // Emitter & Client
        const infoRow   = document.getElementById('preview-info-row');
        const emitterEl = document.getElementById('preview-emitter-block');
        const clientEl  = document.getElementById('preview-client-block');
        if (emitterEl) emitterEl.style.display = sectionStates.emitter ? 'block' : 'none';
        if (clientEl)  clientEl.style.display  = sectionStates.customer ? 'block' : 'none';

        if (infoRow) {
            if (!sectionStates.emitter && !sectionStates.customer) {
                infoRow.style.display = 'none';
            } else {
                infoRow.style.display = 'grid';
                if (sectionStates.emitter && sectionStates.customer) {
                    infoRow.style.gridTemplateColumns = '1fr 1fr';
                } else {
                    infoRow.style.gridTemplateColumns = '1fr';
                }
            }
        }

        // Advances & Remaining
        const rowAdv = document.getElementById('preview-row-advances');
        const rowRem = document.getElementById('preview-row-remaining');
        if (rowAdv) rowAdv.style.display = sectionStates.advances ? 'table-row' : 'none';
        if (rowRem) rowRem.style.display = sectionStates.advances ? 'table-row' : 'none';

        // Words & Cachet
        const wordsRow  = document.getElementById('preview-words-cachet-row');
        const wordsEl   = document.getElementById('preview-words-container');
        const cachetEl  = document.getElementById('preview-cachet-container');
        if (wordsEl)  wordsEl.style.display  = sectionStates.words ? 'flex' : 'none';
        if (cachetEl) cachetEl.style.display = sectionStates.cachet ? 'flex' : 'none';

        if (wordsRow) {
            if (!sectionStates.words && !sectionStates.cachet) {
                wordsRow.style.display = 'none';
            } else {
                wordsRow.style.display = 'flex';
            }
        }

        // Conditions
        const condBox = document.getElementById('preview-conditions-box');
        if (condBox) condBox.style.display = sectionStates.conditions ? 'block' : 'none';

        // Legal Footer Table
        const footTable = document.getElementById('preview-legal-footer-table');
        if (footTable) footTable.style.display = sectionStates.legal_footer ? 'table' : 'none';
    }

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
        const eName = document.getElementById('emitter_name').value || 'Projecteur LOGO';
        const eAddr = document.getElementById('emitter_address').value || 'Hay Nasr lot Oumnia num 27 magasin num 1 - Tanger.';
        const ePhone = document.getElementById('emitter_phone').value || '+212607056637';
        const eEmail = document.getElementById('emitter_email').value || 'worklogo47@gmail.com';
        const eWeb = document.getElementById('emitter_website').value || 'www.projecteurlogo.com';
        const eIce = document.getElementById('emitter_ice').value || '0040525690000032';
        const eIf = document.getElementById('emitter_if').value || '73411678';
        const eTp = document.getElementById('emitter_tp').value || '7210/2026/5669';
        const eRib = document.getElementById('emitter_rib').value || '011 640 0000372100000583 28';

        document.getElementById('preview-emitter-name').textContent = eName;
        document.getElementById('preview-emitter-address').textContent = eAddr;
        document.getElementById('preview-emitter-phone').textContent = ePhone;
        document.getElementById('preview-emitter-email').textContent = eEmail;
        document.getElementById('preview-emitter-website').textContent = eWeb;

        document.getElementById('preview-foot-name').textContent = eName;
        document.getElementById('preview-foot-address').textContent = eAddr;
        document.getElementById('preview-foot-email').textContent = eEmail;
        document.getElementById('preview-foot-website').textContent = eWeb;
        document.getElementById('preview-foot-phone').textContent = ePhone;
        document.getElementById('preview-foot-ice').textContent = eIce;
        document.getElementById('preview-foot-if').textContent = eIf;
        document.getElementById('preview-foot-tp').textContent = eTp;
        document.getElementById('preview-foot-rib').textContent = eRib;

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

        const condDeliveryInput = document.getElementById('condition_delivery');
        const condManufacturingInput = document.getElementById('condition_manufacturing');
        if (condDeliveryInput && document.getElementById('preview-condition-delivery')) {
            document.getElementById('preview-condition-delivery').textContent = condDeliveryInput.value;
        }
        if (condManufacturingInput && document.getElementById('preview-condition-manufacturing')) {
            document.getElementById('preview-condition-manufacturing').textContent = condManufacturingInput.value;
        }

        // Re-apply modular sections visibility
        applySectionVisibility();
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Ensure hidden field active & TVA rate input disabled on load
        document.getElementById('tva_rate').disabled        = true;
        document.getElementById('tva_rate_hidden').disabled = false;
        applySectionVisibility();
        updateLivePreview();
    });
</script>
@endsection
