<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Espace Privilège Client - Projecteur LOGO</title>
    
    <!-- Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #0b1120;
            --bg-secondary: #131d32;
            --bg-card: rgba(26, 38, 64, 0.75);
            --bg-card-hover: rgba(33, 49, 82, 0.95);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-gold: rgba(212, 175, 55, 0.35);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --gold: #d4af37;
            --gold-light: #f5d77f;
            --gold-gradient: linear-gradient(135deg, #d4af37 0%, #f59e0b 100%);
            --success: #10b981;
            --accent: #38bdf8;
            --radius-lg: 16px;
            --radius-md: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            padding-bottom: 100px;
        }

        /* Top Navigation Bar */
        .top-nav {
            background: rgba(11, 17, 32, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 1rem 1.5rem;
        }
        .nav-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }
        .brand-logo img {
            max-height: 40px;
            object-fit: contain;
        }
        .vip-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(212, 175, 55, 0.15);
            border: 1px solid var(--border-gold);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            color: var(--gold-light);
            font-weight: 600;
        }

        /* Main Container */
        .main-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Hero Banner */
        .hero-banner {
            background: radial-gradient(circle at top right, rgba(212, 175, 55, 0.2) 0%, rgba(19, 29, 50, 0.85) 60%);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-lg);
            padding: 2.2rem;
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }
        .hero-title {
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 0.8rem;
            background: linear-gradient(135deg, #ffffff 40%, #f5d77f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-desc {
            color: var(--text-secondary);
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        /* Offer Highlights Card */
        .offer-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            background: rgba(11, 17, 32, 0.7);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: var(--radius-md);
            padding: 1rem 1.5rem;
            margin-top: 1rem;
        }
        .discount-pill {
            background: var(--gold-gradient);
            color: #0b1120;
            font-weight: 900;
            font-size: 1.25rem;
            padding: 6px 16px;
            border-radius: 8px;
            letter-spacing: -0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }
        .countdown-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.95rem;
        }
        .timer-unit {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-color);
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 1.15rem;
            color: var(--gold-light);
            font-weight: 700;
        }

        /* Layout Grid */
        .catalog-layout {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 2rem;
            align-items: start;
        }
        @media (max-width: 1080px) {
            .catalog-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Category Filter Tabs */
        .category-filter {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }
        .cat-btn {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .cat-btn:hover, .cat-btn.active {
            background: rgba(212, 175, 55, 0.15);
            color: var(--gold-light);
            border-color: var(--border-gold);
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }
        .product-card {
            background: var(--bg-card);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-gold);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
        }
        .product-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--gold-gradient);
            color: #0b1120;
            font-size: 0.8rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 50px;
            z-index: 2;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .product-img-wrap {
            height: 190px;
            background: #060b14;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-bottom: 1px solid var(--border-color);
        }
        .product-img-wrap img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        .product-card:hover .product-img-wrap img {
            transform: scale(1.05);
        }
        .product-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .product-cat {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .product-name {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #fff;
            line-height: 1.3;
        }
        .product-desc {
            font-size: 0.82rem;
            color: var(--text-secondary);
            line-height: 1.45;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .price-section {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            padding-top: 10px;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .orig-price {
            text-decoration: line-through;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        .vip-price {
            color: var(--gold-light);
            font-size: 1.3rem;
            font-weight: 800;
        }
        .btn-add {
            width: 100%;
            background: rgba(212, 175, 55, 0.12);
            color: var(--gold-light);
            border: 1px solid var(--border-gold);
            padding: 10px;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        .btn-add:hover {
            background: var(--gold-gradient);
            color: #0b1120;
            border-color: transparent;
        }

        /* Cart / Order Drawer */
        .order-drawer {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            position: sticky;
            top: 90px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }
        .drawer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 240px;
            overflow-y: auto;
            margin-bottom: 1.2rem;
            padding-right: 4px;
        }
        .cart-item {
            background: rgba(11, 17, 32, 0.6);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cart-item-info {
            flex-grow: 1;
        }
        .cart-item-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: #fff;
        }
        .cart-item-price {
            font-size: 0.8rem;
            color: var(--gold-light);
            font-weight: 600;
        }
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .qty-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-color);
            color: #fff;
            width: 24px;
            height: 24px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.8rem;
        }
        .qty-btn:hover {
            background: var(--gold-light);
            color: #000;
        }
        .qty-number {
            font-size: 0.88rem;
            font-weight: 700;
            min-width: 18px;
            text-align: center;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }
        .summary-total {
            border-top: 1px dashed var(--border-color);
            padding-top: 10px;
            margin-top: 10px;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gold-light);
        }

        /* Units Logo Customization Cards */
        .units-section {
            margin-top: 1.2rem;
            border-top: 1px solid var(--border-color);
            padding-top: 1.2rem;
        }
        .units-section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .unit-config-card {
            background: rgba(11, 17, 32, 0.7);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 12px;
            margin-bottom: 10px;
        }
        .unit-config-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--gold-light);
            margin-bottom: 8px;
        }
        .logo-options-group {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 8px;
        }
        .logo-opt-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 0.74rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }
        .logo-opt-label:hover {
            border-color: var(--border-gold);
            color: #fff;
        }
        .logo-opt-label.active {
            background: rgba(212, 175, 55, 0.2);
            border-color: var(--gold);
            color: var(--gold-light);
            font-weight: 600;
        }
        .logo-opt-label input[type="radio"] {
            display: none;
        }
        .past-logo-preview {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #000;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            margin-top: 6px;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        .past-logo-preview img {
            max-height: 32px;
            max-width: 50px;
            object-fit: contain;
        }

        .form-group-custom {
            margin-top: 1rem;
        }
        .form-label-custom {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            display: block;
            margin-bottom: 5px;
        }
        .form-input-custom {
            width: 100%;
            background: rgba(11, 17, 32, 0.8);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 12px;
            color: #fff;
            font-size: 0.85rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input-custom:focus {
            border-color: var(--gold);
        }

        .btn-checkout {
            width: 100%;
            background: var(--gold-gradient);
            color: #0b1120;
            border: none;
            padding: 14px;
            border-radius: var(--radius-md);
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 1.2rem;
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.35);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.5);
        }
        .btn-checkout:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
    </style>
</head>
<body>

    <!-- Top Navigation -->
    <header class="top-nav">
        <div class="nav-inner">
            <a href="#" class="brand-logo">
                <img src="{{ asset('logo.png') }}" alt="Projecteur LOGO" onerror="this.style.display='none'; document.getElementById('alt-logo-text').style.display='block';">
                <span id="alt-logo-text" style="display: none; font-weight: 800; font-size: 1.2rem; color: var(--gold);">PROJECTEUR LOGO</span>
            </a>
            <div class="vip-badge-top">
                <i class="fa-solid fa-crown" style="color: var(--gold);"></i>
                <span>Espace Privilège : <strong>{{ $customer->name }}</strong></span>
            </div>
        </div>
    </header>

    <main class="main-container">

        <!-- Hero Banner with Discount Status & Live Timer -->
        <section class="hero-banner">
            <div class="hero-content">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; color: var(--gold-light); font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                    <i class="fa-solid fa-star"></i> Offre Fidélité Exclusive
                </div>
                <h1 class="hero-title">Ravi de vous revoir, {{ $customer->name }} !</h1>
                <p class="hero-desc">
                    Suite à la livraison de votre premier projecteur, profitez de notre catalogue exclusif avec une tarification privilège réservée uniquement à nos clients fidèles.
                </p>

                <div class="offer-strip">
                    <div class="discount-pill">
                        <i class="fa-solid fa-tag"></i> -{{ (int)$discountRate }}% IMMÉDIAT
                    </div>
                    @if($isInitialPeriod)
                        <div style="font-size: 0.9rem; color: #fff;">
                            <strong>Offre des 10 premiers jours :</strong> -11% sur tout le catalogue !<br>
                            <span style="color: var(--text-secondary); font-size: 0.8rem;">Puis -5% permanent à vie.</span>
                        </div>
                        <div class="countdown-box" id="timer-box">
                            <span><i class="fa-regular fa-clock" style="color: var(--gold);"></i> Fin de l'offre 11% dans :</span>
                            <div class="timer-unit" id="timer-display">--j --h --m</div>
                        </div>
                    @else
                        <div style="font-size: 0.9rem; color: #fff;">
                            <strong>Remise permanente à vie :</strong> Bénéficiez de -5% sur toutes vos commandes de projecteurs et gobos !
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Category Filter -->
        @if($categories->count() > 0)
            <div class="category-filter">
                <button class="cat-btn active" onclick="filterCategory('all', this)">Tous nos projecteurs ({{ $products->count() }})</button>
                @foreach($categories as $cat)
                    @php $pCount = $products->where('category_id', $cat->id)->count(); @endphp
                    @if($pCount > 0)
                        <button class="cat-btn" onclick="filterCategory('cat-{{ $cat->id }}', this)">
                            {{ $cat->name }} ({{ $pCount }})
                        </button>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="catalog-layout">
            
            <!-- Products Catalog -->
            <div class="products-grid">
                @forelse($products as $prod)
                    @php
                        $origPrice = (float) $prod->price;
                        $discPrice = round($origPrice * (1 - $discountRate / 100), 2);
                        $savings = round($origPrice - $discPrice, 2);
                    @endphp
                    <div class="product-card" data-category="cat-{{ $prod->category_id ?? 'none' }}">
                        <span class="product-badge">-{{ (int)$discountRate }}%</span>
                        <div class="product-img-wrap">
                            @if($prod->image)
                                <img src="{{ asset('public-storage/' . $prod->image) }}" alt="{{ $prod->name }}" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                            @else
                                <i class="fa-solid fa-lightbulb" style="font-size: 3.5rem; color: var(--gold); opacity: 0.5;"></i>
                            @endif
                        </div>
                        <div class="product-body">
                            <span class="product-cat">{{ $prod->category->name ?? 'Projecteur' }} &bull; Réf: {{ $prod->code }}</span>
                            <h3 class="product-name">{{ $prod->name }}</h3>
                            <p class="product-desc">{{ $prod->description ?? 'Projecteur haute définition pour projection de logo personnalisé en intérieur ou extérieur.' }}</p>
                            
                            <div class="price-section">
                                <div>
                                    <span class="orig-price">{{ number_format($origPrice, 2, ',', ' ') }} DH</span>
                                    <div style="font-size: 0.72rem; color: #10b981; font-weight: 600;">Économie: {{ number_format($savings, 2, ',', ' ') }} DH</div>
                                </div>
                                <div class="vip-price">
                                    {{ number_format($discPrice, 2, ',', ' ') }} <small style="font-size: 0.8rem;">DH</small>
                                </div>
                            </div>

                            <button type="button" class="btn-add" onclick="addToCart({{ $prod->id }}, '{{ addslashes($prod->name) }}', {{ $discPrice }}, {{ $origPrice }}, '{{ $prod->code }}')">
                                <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                            </button>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: var(--text-secondary);">
                        <i class="fa-solid fa-boxes-stacked" style="font-size: 3rem; margin-bottom: 1rem; color: var(--gold); opacity: 0.4;"></i>
                        <p>Aucun produit n'est disponible actuellement.</p>
                    </div>
                @endforelse
            </div>

            <!-- Sticky Cart & Order Configuration Drawer -->
            <aside>
                <div class="order-drawer">
                    <h3 class="drawer-title">
                        <span><i class="fa-solid fa-bag-shopping" style="color: var(--gold);"></i> Ma Sélection VIP</span>
                        <span id="cart-count-badge" style="font-size: 0.8rem; background: rgba(212, 175, 55, 0.2); color: var(--gold-light); padding: 2px 8px; border-radius: 50px;">0 article</span>
                    </h3>

                    <form action="{{ route('catalog.special.order', $link->token) }}" method="POST" enctype="multipart/form-data" id="order-form">
                        @csrf
                        
                        <!-- Selected Cart Items Container -->
                        <div class="cart-items" id="cart-items-list">
                            <div id="cart-empty-msg" style="text-align: center; padding: 2rem 1rem; color: var(--text-secondary); font-size: 0.88rem;">
                                <i class="fa-solid fa-hand-pointer" style="font-size: 1.8rem; margin-bottom: 8px; display: block; color: var(--border-gold);"></i>
                                Choisissez un ou plusieurs projecteurs dans le catalogue pour composer votre commande.
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div style="border-top: 1px solid var(--border-color); padding-top: 12px;">
                            <div class="summary-row">
                                <span>Sous-total normal :</span>
                                <span id="summary-orig-total">0,00 DH</span>
                            </div>
                            <div class="summary-row" style="color: #10b981; font-weight: 600;">
                                <span>Remise VIP (-{{ (int)$discountRate }}%) :</span>
                                <span id="summary-discount">-0,00 DH</span>
                            </div>
                            <div class="summary-row summary-total">
                                <span>Total Privilège :</span>
                                <span id="summary-final-total">0,00 DH</span>
                            </div>
                        </div>

                        <!-- Dynamic Per-Projector Logo Configuration -->
                        <div class="units-section" id="units-section" style="display: none;">
                            <div class="units-section-title">
                                <i class="fa-solid fa-wand-magic-sparkles" style="color: var(--gold);"></i>
                                <span>Personnalisation des Logos par Projecteur</span>
                            </div>
                            <div id="units-container">
                                <!-- Populated dynamically by JS for each projector unit -->
                            </div>
                        </div>

                        <!-- Customization Notes -->
                        <div class="form-group-custom">
                            <label class="form-label-custom" for="global_notes">
                                <i class="fa-solid fa-pen-nib" style="color: var(--gold);"></i> Remarques globales (Optionnel)
                            </label>
                            <textarea name="global_notes" id="global_notes" rows="2" class="form-input-custom" placeholder="Instructions particulières pour la commande..."></textarea>
                        </div>

                        <!-- Delivery Confirmation -->
                        <div class="form-group-custom">
                            <label class="form-label-custom" for="phone">
                                <i class="fa-solid fa-phone" style="color: var(--gold);"></i> Téléphone de confirmation
                            </label>
                            <input type="text" name="phone" id="phone" class="form-input-custom" value="{{ $customer->phone }}" required>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom" for="delivery_address">
                                <i class="fa-solid fa-location-dot" style="color: var(--gold);"></i> Adresse de livraison
                            </label>
                            <input type="text" name="delivery_address" id="delivery_address" class="form-input-custom" value="{{ $customer->address }}" placeholder="Ville, quartier, adresse..." required>
                        </div>

                        <button type="submit" class="btn-checkout" id="btn-submit" disabled>
                            <i class="fa-solid fa-circle-check"></i> Valider ma commande (-{{ (int)$discountRate }}%)
                        </button>
                    </form>
                </div>
            </aside>

        </div>
    </main>

    <script>
        const hasPastLogo = {{ $pastLogoPath ? 'true' : 'false' }};
        const pastLogoUrl = "{{ $pastLogoUrl ?? '' }}";

        // Category Filter
        function filterCategory(catId, btn) {
            document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                if (catId === 'all' || card.getAttribute('data-category') === catId) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Countdown Timer
        @if($isInitialPeriod)
            let remainingSeconds = {{ $remainingSeconds }};
            function updateCountdown() {
                if (remainingSeconds <= 0) {
                    document.getElementById('timer-display').textContent = "Terminé";
                    return;
                }
                const days = Math.floor(remainingSeconds / 86400);
                const hours = Math.floor((remainingSeconds % 86400) / 3600);
                const minutes = Math.floor((remainingSeconds % 3600) / 60);
                const seconds = remainingSeconds % 60;

                let str = "";
                if (days > 0) str += days + "j ";
                str += (hours < 10 ? '0' : '') + hours + "h ";
                str += (minutes < 10 ? '0' : '') + minutes + "m ";
                str += (seconds < 10 ? '0' : '') + seconds + "s";

                document.getElementById('timer-display').textContent = str;
                remainingSeconds--;
            }
            updateCountdown();
            setInterval(updateCountdown, 1000);
        @endif

        // Cart State
        const cart = {};
        // Store user selections per unit index so they are preserved on qty updates
        const unitConfigs = {};

        function addToCart(id, name, unitPrice, origPrice, code) {
            if (cart[id]) {
                cart[id].quantity += 1;
            } else {
                cart[id] = {
                    id: id,
                    name: name,
                    unitPrice: unitPrice,
                    origPrice: origPrice,
                    code: code,
                    quantity: 1
                };
            }
            renderCart();
        }

        function changeQty(id, delta) {
            if (!cart[id]) return;
            cart[id].quantity += delta;
            if (cart[id].quantity <= 0) {
                delete cart[id];
            }
            renderCart();
        }

        function selectLogoSource(unitIdx, source) {
            unitConfigs[unitIdx] = unitConfigs[unitIdx] || {};
            unitConfigs[unitIdx].source = source;

            // Update radio buttons and active styling
            const unitCard = document.getElementById(`unit-card-${unitIdx}`);
            if (!unitCard) return;

            unitCard.querySelectorAll('.logo-opt-label').forEach(lbl => {
                const radio = lbl.querySelector('input[type="radio"]');
                if (radio && radio.value === source) {
                    radio.checked = true;
                    lbl.classList.add('active');
                } else {
                    lbl.classList.remove('active');
                }
            });

            // Toggle file input display
            const uploadWrap = document.getElementById(`unit-upload-${unitIdx}`);
            if (uploadWrap) {
                uploadWrap.style.display = (source === 'new_upload') ? 'block' : 'none';
            }
        }

        function renderCart() {
            const container = document.getElementById('cart-items-list');
            const emptyMsg = document.getElementById('cart-empty-msg');
            const submitBtn = document.getElementById('btn-submit');
            const badge = document.getElementById('cart-count-badge');
            const unitsSection = document.getElementById('units-section');
            const unitsContainer = document.getElementById('units-container');

            // Remove existing item rows
            container.querySelectorAll('.cart-item').forEach(el => el.remove());

            const itemKeys = Object.keys(cart);
            let totalQty = 0;
            let totalOrig = 0;
            let totalDisc = 0;
            const flatUnits = [];

            if (itemKeys.length === 0) {
                if (emptyMsg) emptyMsg.style.display = 'block';
                submitBtn.disabled = true;
                badge.textContent = "0 article";
                if (unitsSection) unitsSection.style.display = 'none';
                if (unitsContainer) unitsContainer.innerHTML = '';
            } else {
                if (emptyMsg) emptyMsg.style.display = 'none';
                submitBtn.disabled = false;

                itemKeys.forEach((key, idx) => {
                    const item = cart[key];
                    totalQty += item.quantity;
                    totalOrig += (item.quantity * item.origPrice);
                    totalDisc += (item.quantity * item.unitPrice);

                    for (let u = 0; u < item.quantity; u++) {
                        flatUnits.push({
                            id: item.id,
                            name: item.name,
                            code: item.code
                        });
                    }

                    const div = document.createElement('div');
                    div.className = 'cart-item';
                    div.innerHTML = `
                        <div class="cart-item-info">
                            <div class="cart-item-name">${item.name}</div>
                            <div class="cart-item-price">${(item.quantity * item.unitPrice).toLocaleString('fr-FR', {minimumFractionDigits: 2})} DH</div>
                            <input type="hidden" name="items[${idx}][product_id]" value="${item.id}">
                            <input type="hidden" name="items[${idx}][quantity]" value="${item.quantity}">
                        </div>
                        <div class="qty-controls">
                            <button type="button" class="qty-btn" onclick="changeQty(${item.id}, -1)">-</button>
                            <span class="qty-number">${item.quantity}</span>
                            <button type="button" class="qty-btn" onclick="changeQty(${item.id}, 1)">+</button>
                        </div>
                    `;
                    container.appendChild(div);
                });

                badge.textContent = `${totalQty} article${totalQty > 1 ? 's' : ''}`;

                // Render Per-Projector Units
                if (unitsSection) unitsSection.style.display = 'block';
                renderUnits(flatUnits);
            }

            const savings = Math.max(0, totalOrig - totalDisc);

            document.getElementById('summary-orig-total').textContent = totalOrig.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
            document.getElementById('summary-discount').textContent = '-' + savings.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
            document.getElementById('summary-final-total').textContent = totalDisc.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
        }

        function renderUnits(flatUnits) {
            const container = document.getElementById('units-container');
            if (!container) return;

            let html = '';
            flatUnits.forEach((unit, idx) => {
                const isFirst = (idx === 0);
                const currentConfig = unitConfigs[idx] || {};

                // Default selection
                let selectedSource = currentConfig.source;
                if (!selectedSource) {
                    if (isFirst) {
                        selectedSource = hasPastLogo ? 'past_logo' : 'new_upload';
                    } else {
                        selectedSource = 'same_as_first';
                    }
                    unitConfigs[idx] = { source: selectedSource };
                }

                html += `
                    <div class="unit-config-card" id="unit-card-${idx}">
                        <div class="unit-config-header">
                            <span><i class="fa-solid fa-projector"></i> Projecteur #${idx + 1} : ${unit.name}</span>
                            <input type="hidden" name="units[${idx}][product_id]" value="${unit.id}">
                        </div>

                        <div class="logo-options-group">
                `;

                if (!isFirst) {
                    html += `
                        <label class="logo-opt-label ${selectedSource === 'same_as_first' ? 'active' : ''}" onclick="selectLogoSource(${idx}, 'same_as_first')">
                            <input type="radio" name="units[${idx}][logo_source]" value="same_as_first" ${selectedSource === 'same_as_first' ? 'checked' : ''}>
                            <i class="fa-solid fa-link" style="color: var(--gold);"></i> Même logo que le 1er
                        </label>
                    `;
                }

                if (hasPastLogo) {
                    html += `
                        <label class="logo-opt-label ${selectedSource === 'past_logo' ? 'active' : ''}" onclick="selectLogoSource(${idx}, 'past_logo')">
                            <input type="radio" name="units[${idx}][logo_source]" value="past_logo" ${selectedSource === 'past_logo' ? 'checked' : ''}>
                            <i class="fa-solid fa-clock-rotate-left"></i> Ancien logo (1ère commande)
                        </label>
                    `;
                }

                html += `
                    <label class="logo-opt-label ${selectedSource === 'new_upload' ? 'active' : ''}" onclick="selectLogoSource(${idx}, 'new_upload')">
                        <input type="radio" name="units[${idx}][logo_source]" value="new_upload" ${selectedSource === 'new_upload' ? 'checked' : ''}>
                        <i class="fa-solid fa-cloud-arrow-up"></i> ${!isFirst ? 'Nouveau logo distinct' : 'Nouveau logo'}
                    </label>
                `;

                html += `</div>`;

                // Preview for past logo if selected
                if (hasPastLogo && selectedSource === 'past_logo') {
                    html += `
                        <div class="past-logo-preview">
                            <img src="${pastLogoUrl}" alt="Ancien logo">
                            <span>Utilise votre logo déjà enregistré dans notre système.</span>
                        </div>
                    `;
                }

                // File Upload input
                html += `
                    <div id="unit-upload-${idx}" style="display: ${selectedSource === 'new_upload' ? 'block' : 'none'}; margin-top: 8px;">
                        <input type="file" name="units[${idx}][logo_file]" class="form-input-custom" accept="image/*,.pdf,.svg">
                        <small style="color: var(--text-secondary); font-size: 0.72rem; display: block; margin-top: 2px;">
                            Téléchargez le fichier (PNG, JPG, PDF ou SVG) pour ce projecteur.
                        </small>
                    </div>
                `;

                // Unit notes
                html += `
                    <div style="margin-top: 8px;">
                        <input type="text" name="units[${idx}][notes]" class="form-input-custom" placeholder="Optionnel : Spécification (ex: lentille rotative, lumière blanc 6500K...)" style="font-size: 0.76rem; padding: 6px 10px;">
                    </div>
                </div>`;
            });

            container.innerHTML = html;
        }
    </script>
</body>
</html>
