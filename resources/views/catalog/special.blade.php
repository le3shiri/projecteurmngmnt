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
            --bg-primary: #0a0f1d;
            --bg-secondary: #111a2e;
            --bg-card: rgba(22, 33, 56, 0.75);
            --bg-card-hover: rgba(28, 43, 74, 0.95);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-gold: rgba(212, 175, 55, 0.35);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --gold: #d4af37;
            --gold-light: #f5d77f;
            --gold-gradient: linear-gradient(135deg, #d4af37 0%, #f59e0b 100%);
            --accent-cyan: #38bdf8;
            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.12);
            --radius-xl: 20px;
            --radius-lg: 14px;
            --radius-md: 10px;
            --shadow-subtle: 0 10px 25px rgba(0, 0, 0, 0.35);
            --shadow-glow: 0 0 25px rgba(212, 175, 55, 0.25);
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
            padding-bottom: 120px;
            overflow-x: hidden;
        }

        /* Top Navigation Bar */
        .top-nav {
            background: rgba(10, 15, 29, 0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 0.85rem 1.5rem;
        }
        .nav-inner {
            max-width: 1320px;
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
            max-height: 38px;
            object-fit: contain;
        }
        .nav-right-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .vip-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(212, 175, 55, 0.12);
            border: 1px solid var(--border-gold);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.82rem;
            color: var(--gold-light);
            font-weight: 600;
        }
        .cart-quick-btn {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-color);
            color: #fff;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.82rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .cart-quick-btn:hover {
            border-color: var(--gold);
            background: rgba(212, 175, 55, 0.15);
            color: var(--gold-light);
        }

        /* Main Container */
        .main-container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 1.8rem 1.5rem;
        }

        /* Hero Banner */
        .hero-banner {
            background: radial-gradient(circle at 85% 20%, rgba(212, 175, 55, 0.22) 0%, rgba(17, 26, 46, 0.95) 70%);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-xl);
            padding: 2.2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
        }
        .hero-banner::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 880px;
        }
        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.8rem;
            color: var(--gold-light);
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(212, 175, 55, 0.15);
            padding: 4px 12px;
            border-radius: 50px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }
        .hero-title {
            font-size: 2.3rem;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 0.75rem;
            background: linear-gradient(135deg, #ffffff 40%, #f5d77f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-desc {
            color: var(--text-secondary);
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 1.6rem;
        }

        /* Offer Highlights Strip */
        .offer-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 1.2rem;
            align-items: center;
            background: rgba(10, 15, 29, 0.75);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: var(--radius-lg);
            padding: 1rem 1.4rem;
        }
        .discount-pill {
            background: var(--gold-gradient);
            color: #0a0f1d;
            font-weight: 900;
            font-size: 1.25rem;
            padding: 8px 18px;
            border-radius: 8px;
            letter-spacing: -0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.35);
        }
        .countdown-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.92rem;
            background: rgba(255, 255, 255, 0.04);
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        .timer-unit {
            background: rgba(212, 175, 55, 0.15);
            border: 1px solid var(--border-gold);
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 1.15rem;
            color: var(--gold-light);
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        /* ========================================================
           WHY ADD A 2ND PROJECTOR SECTION (THE PSYCHOLOGICAL PUSH)
           ======================================================== */
        .multi-projector-why {
            background: linear-gradient(135deg, rgba(22, 33, 56, 0.6) 0%, rgba(17, 26, 46, 0.9) 100%);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: var(--radius-xl);
            padding: 2rem;
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
        }
        .why-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 1.6rem;
            flex-wrap: wrap;
            gap: 15px;
        }
        .why-title-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--accent-cyan);
            margin-bottom: 6px;
        }
        .why-title {
            font-size: 1.65rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.3;
        }
        .why-title span {
            color: var(--gold-light);
        }
        .why-badge-stat {
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: var(--accent-cyan);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.4rem;
            margin-bottom: 1.5rem;
        }
        @media (max-width: 900px) {
            .why-grid {
                grid-template-columns: 1fr;
            }
        }
        .why-card {
            background: rgba(10, 15, 29, 0.65);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.3rem;
            transition: transform 0.2s, border-color 0.2s;
            position: relative;
        }
        .why-card:hover {
            transform: translateY(-3px);
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        .why-card-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(212, 175, 55, 0.12);
            border: 1px solid rgba(212, 175, 55, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--gold-light);
            margin-bottom: 1rem;
        }
        .why-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }
        .why-card-desc {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }
        .why-card-pill {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
            margin-top: 10px;
        }

        /* Before/After Visibility Multiplier Banner */
        .visibility-multiplier-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(10, 15, 29, 0.85);
            border: 1px dashed rgba(212, 175, 55, 0.4);
            border-radius: var(--radius-md);
            padding: 1rem 1.4rem;
            flex-wrap: wrap;
            gap: 15px;
        }
        .multiplier-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .multiplier-tag {
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--gold-light);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .multiplier-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
        .multiplier-desc strong {
            color: #fff;
        }

        /* 3-Step Simple Roadmap */
        .steps-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        @media (max-width: 768px) {
            .steps-bar {
                grid-template-columns: 1fr;
            }
        }
        .step-item {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #0a0f1d;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.95rem;
        }
        .step-text h4 {
            font-size: 0.92rem;
            color: #fff;
            margin-bottom: 2px;
        }
        .step-text p {
            font-size: 0.78rem;
            color: var(--text-secondary);
        }

        /* Layout Grid */
        .catalog-layout {
            display: grid;
            grid-template-columns: 1fr 440px;
            gap: 2rem;
            align-items: start;
        }
        @media (max-width: 1080px) {
            .catalog-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Search & Filter Bar */
        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 1.5rem;
        }
        .category-filter {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .cat-btn {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .cat-btn:hover, .cat-btn.active {
            background: rgba(212, 175, 55, 0.15);
            color: var(--gold-light);
            border-color: var(--border-gold);
        }
        .search-box {
            position: relative;
            min-width: 240px;
        }
        .search-box input {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 8px 16px 8px 36px;
            color: #fff;
            font-size: 0.85rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-box input:focus {
            border-color: var(--gold);
        }
        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 1.5rem;
        }
        .product-card {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-5px);
            border-color: var(--border-gold);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.45), var(--shadow-glow);
        }
        .product-discount-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--gold-gradient);
            color: #0a0f1d;
            font-size: 0.8rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 50px;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .product-tag-popular {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(56, 189, 248, 0.2);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: var(--accent-cyan);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            z-index: 2;
            text-transform: uppercase;
        }
        .product-img-wrap {
            height: 200px;
            background: radial-gradient(circle at center, #152238 0%, #060b14 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }
        .product-img-wrap img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.5));
        }
        .product-card:hover .product-img-wrap img {
            transform: scale(1.08);
        }
        .product-body {
            padding: 1.3rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .product-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .product-cat {
            font-size: 0.75rem;
            color: var(--gold-light);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .product-ref {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-family: monospace;
        }
        .product-name {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #fff;
            line-height: 1.35;
        }
        .product-desc {
            font-size: 0.84rem;
            color: var(--text-secondary);
            line-height: 1.45;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-features-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 1rem;
        }
        .feature-pill {
            font-size: 0.72rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .price-section {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            padding-top: 12px;
            margin-bottom: 14px;
        }
        .price-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }
        .orig-price {
            text-decoration: line-through;
            color: var(--text-muted);
            font-size: 0.88rem;
        }
        .savings-tag {
            font-size: 0.75rem;
            color: var(--success);
            font-weight: 700;
            background: var(--success-bg);
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 2px;
        }
        .vip-price {
            color: var(--gold-light);
            font-size: 1.4rem;
            font-weight: 800;
            text-align: right;
            line-height: 1;
        }
        .vip-price small {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
        }
        .btn-add {
            width: 100%;
            background: rgba(212, 175, 55, 0.12);
            color: var(--gold-light);
            border: 1px solid var(--border-gold);
            padding: 11px;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.92rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        .btn-add:hover {
            background: var(--gold-gradient);
            color: #0a0f1d;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }

        /* Cart / Order Drawer */
        .order-drawer {
            background: var(--bg-card);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-xl);
            padding: 1.6rem;
            position: sticky;
            top: 85px;
            box-shadow: var(--shadow-subtle);
        }
        .drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.2rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }
        .drawer-title {
            font-size: 1.25rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
        }
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 250px;
            overflow-y: auto;
            margin-bottom: 1.2rem;
            padding-right: 4px;
        }
        .cart-item {
            background: rgba(10, 15, 29, 0.7);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.25s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .cart-item-info {
            flex-grow: 1;
        }
        .cart-item-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 2px;
        }
        .cart-item-price {
            font-size: 0.82rem;
            color: var(--gold-light);
            font-weight: 700;
        }
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.05);
            padding: 2px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }
        .qty-btn {
            background: transparent;
            border: none;
            color: #fff;
            width: 24px;
            height: 24px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.82rem;
            transition: background 0.15s;
        }
        .qty-btn:hover {
            background: var(--gold-light);
            color: #0a0f1d;
        }
        .qty-number {
            font-size: 0.88rem;
            font-weight: 800;
            min-width: 20px;
            text-align: center;
        }

        .summary-box {
            background: rgba(10, 15, 29, 0.6);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 12px;
            margin-bottom: 1.2rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }
        .summary-total {
            border-top: 1px dashed rgba(212, 175, 55, 0.35);
            padding-top: 10px;
            margin-top: 8px;
            font-size: 1.35rem;
            font-weight: 900;
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
            background: rgba(10, 15, 29, 0.75);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 12px;
            margin-bottom: 12px;
            position: relative;
        }
        .unit-config-card.active-unit {
            border-color: rgba(212, 175, 55, 0.4);
        }
        .unit-config-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.86rem;
            font-weight: 700;
            color: var(--gold-light);
            margin-bottom: 8px;
        }
        .logo-options-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 8px;
        }
        .logo-opt-label {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 0.8rem;
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
            background: rgba(212, 175, 55, 0.18);
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
            gap: 10px;
            background: #000;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            margin-top: 6px;
            font-size: 0.78rem;
            color: var(--text-secondary);
        }
        .past-logo-preview img {
            max-height: 38px;
            max-width: 55px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.05);
            padding: 2px;
            border-radius: 4px;
        }

        .form-group-custom {
            margin-top: 1rem;
        }
        .form-label-custom {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 5px;
        }
        .form-input-custom {
            width: 100%;
            background: rgba(10, 15, 29, 0.85);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 9px 12px;
            color: #fff;
            font-size: 0.86rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input-custom:focus {
            border-color: var(--gold);
        }

        .btn-checkout {
            width: 100%;
            background: var(--gold-gradient);
            color: #0a0f1d;
            border: none;
            padding: 15px;
            border-radius: var(--radius-md);
            font-weight: 900;
            font-size: 1.05rem;
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

        /* Trust & Security Badges */
        .trust-strip {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 1.2rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }
        .trust-item {
            font-size: 0.74rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .trust-item i {
            color: var(--gold);
        }

        /* Floating Mobile Checkout Bar */
        .mobile-bottom-bar {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(10, 15, 29, 0.96);
            backdrop-filter: blur(14px);
            border-top: 1px solid var(--border-gold);
            padding: 10px 16px;
            z-index: 99;
            box-shadow: 0 -10px 25px rgba(0,0,0,0.5);
        }
        @media (max-width: 1080px) {
            .mobile-bottom-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
            }
        }
        .mobile-bar-total {
            display: flex;
            flex-direction: column;
        }
        .mobile-bar-total span {
            font-size: 0.72rem;
            color: var(--text-secondary);
        }
        .mobile-bar-total strong {
            font-size: 1.15rem;
            color: var(--gold-light);
            font-weight: 800;
        }
        .mobile-bar-btn {
            background: var(--gold-gradient);
            color: #0a0f1d;
            border: none;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            font-weight: 800;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Toast notification */
        .toast-notify {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #111a2e;
            border: 1px solid var(--gold);
            color: #fff;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            z-index: 999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .toast-notify.show {
            transform: translateY(0);
            opacity: 1;
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
            <div class="nav-right-actions">
                <div class="vip-badge-top">
                    <i class="fa-solid fa-crown" style="color: var(--gold);"></i>
                    <span>Client Privilège : <strong>{{ $customer->name }}</strong></span>
                </div>
                <button type="button" class="cart-quick-btn" onclick="scrollToDrawer()">
                    <i class="fa-solid fa-bag-shopping" style="color: var(--gold);"></i>
                    <span id="nav-cart-count">0</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main-container">

        <!-- Hero Banner with Discount Status & Live Timer -->
        <section class="hero-banner">
            <div class="hero-content">
                <div class="hero-tag">
                    <i class="fa-solid fa-star"></i> Offre Fidélité & Réassort
                </div>
                <h1 class="hero-title">Ravi de vous revoir, {{ $customer->name }} !</h1>
                <p class="hero-desc">
                    Votre premier projecteur illumine déjà votre établissement. Profitez de votre statut client VIP pour étendre votre visibilité avec notre catalogue exclusif à tarif préférentiel.
                </p>

                <div class="offer-strip">
                    <div class="discount-pill">
                        <i class="fa-solid fa-bolt"></i> -{{ (int)$discountRate }}% DE REMISE VIP
                    </div>
                    @if($isInitialPeriod)
                        <div style="font-size: 0.92rem; color: #fff;">
                            <strong>Offre de Bienvenue 10 premiers jours :</strong> -11% sur tous les modèles !<br>
                            <span style="color: var(--text-secondary); font-size: 0.82rem;">Après cette période, vous gardez -5% permanent à vie.</span>
                        </div>
                        <div class="countdown-box" id="timer-box">
                            <span><i class="fa-regular fa-clock" style="color: var(--gold);"></i> Fin de l'offre -11% dans :</span>
                            <div class="timer-unit" id="timer-display">--j --h --m</div>
                        </div>
                    @else
                        <div style="font-size: 0.92rem; color: #fff;">
                            <strong>Remise VIP permanente à vie :</strong> -5% réservé à votre compte sur toute commande !
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- =========================================================
             STRATEGIC VISIBILITY SECTION (WHY A 2ND PROJECTOR IS KEY)
             ========================================================= -->
        <section class="multi-projector-why">
            <div class="why-header">
                <div>
                    <div class="why-title-badge">
                        <i class="fa-solid fa-lightbulb"></i> Stratégie de Croissance & Notoriété
                    </div>
                    <h2 class="why-title">
                        Pourquoi installer un <span>2ème Projecteur</span> pour votre établissement ?
                    </h2>
                </div>
                <div class="why-badge-stat">
                    <i class="fa-solid fa-chart-line"></i> +100% de visibilité captée
                </div>
            </div>

            <div class="why-grid">
                <!-- Angle 1 -->
                <div class="why-card">
                    <div class="why-card-icon">
                        <i class="fa-solid fa-arrows-left-right"></i>
                    </div>
                    <h3 class="why-card-title">1. Couvrez les 2 sens de votre rue</h3>
                    <p class="why-card-desc">
                        Un seul projecteur ne cible que les passants venant d'un côté. Avec un second projecteur orienté dans le sens opposé, aucun piéton ni véhicule ne peut rater votre enseigne.
                    </p>
                    <span class="why-card-pill">0 client manqué</span>
                </div>

                <!-- Angle 2 -->
                <div class="why-card">
                    <div class="why-card-icon">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <h3 class="why-card-title">2. Duo Extérieur Trottoir + Accueil Intérieur</h3>
                    <p class="why-card-desc">
                        Le 1er projecteur attire le flux de l'extérieur vers votre porte. Le 2ème crée une ambiance prestige au sol ou au mur de votre accueil ou comptoir intérieur.
                    </p>
                    <span class="why-card-pill">Expérience client premium</span>
                </div>

                <!-- Angle 3 -->
                <div class="why-card">
                    <div class="why-card-icon">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <h3 class="why-card-title">3. Logo Permanent + Promo ou QR Code</h3>
                    <p class="why-card-desc">
                        Dédiez votre premier projecteur à votre logo officiel, et le second pour projeter vos offres spéciales, menus, ou QR Code Instagram/WhatsApp pour gagner des abonnés.
                    </p>
                    <span class="why-card-pill">Conversion & Ventes directes</span>
                </div>
            </div>

            <!-- Multiplier Summary Strip -->
            <div class="visibility-multiplier-strip">
                <div class="multiplier-left">
                    <div class="multiplier-tag">
                        <i class="fa-solid fa-gem"></i> MULTIPLIEZ VOTRE IMPACT PAR 2
                    </div>
                    <div class="multiplier-desc">
                        Profitez de votre remise exclusive de <strong>-{{ (int)$discountRate }}%</strong> pour équiper votre 2ème point stratégique avec votre logo existant ou un nouveau logo !
                    </div>
                </div>
                <button type="button" class="btn-add" style="width: auto; padding: 10px 22px;" onclick="scrollToCatalog()">
                    <i class="fa-solid fa-arrow-down"></i> Découvrir les projecteurs éligibles
                </button>
            </div>
        </section>

        <!-- 3-Step Simple Roadmap -->
        <div class="steps-bar">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">
                    <h4>Choisissez votre projecteur</h4>
                    <p>Remise de -{{ (int)$discountRate }}% appliquée automatiquement</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">
                    <h4>Personnalisez vos logos</h4>
                    <p>Réutilisez votre logo ou téléchargez-en un nouveau</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">
                    <h4>Validation rapide en 30 sec</h4>
                    <p>Livraison rapide & confirmation sans tracas</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="filter-header" id="catalog-section">
            @if($categories->count() > 0)
                <div class="category-filter">
                    <button class="cat-btn active" onclick="filterCategory('all', this)">
                        <i class="fa-solid fa-border-all"></i> Tous ({{ $products->count() }})
                    </button>
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

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="catalog-search" placeholder="Rechercher un modèle..." oninput="searchProducts(this.value)">
            </div>
        </div>

        <div class="catalog-layout">
            
            <!-- Products Catalog Grid -->
            <div>
                <div class="products-grid" id="products-grid-container">
                    @forelse($products as $prod)
                        @php
                            $origPrice = (float) $prod->price;
                            $discPrice = round($origPrice * (1 - $discountRate / 100), 2);
                            $savings = round($origPrice - $discPrice, 2);
                        @endphp
                        <div class="product-card" data-category="cat-{{ $prod->category_id ?? 'none' }}" data-name="{{ strtolower($prod->name) }}" data-code="{{ strtolower($prod->code) }}">
                            <span class="product-discount-badge">
                                <i class="fa-solid fa-tag"></i> -{{ (int)$discountRate }}%
                            </span>
                            @if($loop->first || $loop->iteration == 2)
                                <span class="product-tag-popular">
                                    <i class="fa-solid fa-fire"></i> Best-seller
                                </span>
                            @endif

                            <div class="product-img-wrap">
                                @if($prod->image)
                                    <img src="{{ asset('public-storage/' . $prod->image) }}" alt="{{ $prod->name }}" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                                @else
                                    <i class="fa-solid fa-lightbulb" style="font-size: 3.5rem; color: var(--gold); opacity: 0.5;"></i>
                                @endif
                            </div>

                            <div class="product-body">
                                <div class="product-meta-row">
                                    <span class="product-cat">{{ $prod->category->name ?? 'Projecteur' }}</span>
                                    <span class="product-ref">Réf: {{ $prod->code }}</span>
                                </div>
                                <h3 class="product-name">{{ $prod->name }}</h3>
                                <p class="product-desc">{{ $prod->description ?? 'Projecteur haute définition pour projection de logo personnalisé en intérieur ou extérieur.' }}</p>
                                
                                <div class="product-features-pills">
                                    <span class="feature-pill"><i class="fa-solid fa-certificate"></i> Lentille HD</span>
                                    <span class="feature-pill"><i class="fa-solid fa-shield-halved"></i> Garanti 2 ans</span>
                                    <span class="feature-pill"><i class="fa-solid fa-rotate"></i> Rotation 360°</span>
                                </div>

                                <div class="price-section">
                                    <div class="price-row">
                                        <div>
                                            <span class="orig-price">{{ number_format($origPrice, 2, ',', ' ') }} DH</span>
                                            <div>
                                                <span class="savings-tag">Économie: {{ number_format($savings, 2, ',', ' ') }} DH</span>
                                            </div>
                                        </div>
                                        <div class="vip-price">
                                            {{ number_format($discPrice, 2, ',', ' ') }} <small>DH</small>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn-add" onclick="addToCart({{ $prod->id }}, '{{ addslashes($prod->name) }}', {{ $discPrice }}, {{ $origPrice }}, '{{ $prod->code }}')">
                                    <i class="fa-solid fa-cart-plus"></i> Ajouter à ma sélection
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
            </div>

            <!-- Sticky Cart & Order Configuration Drawer -->
            <aside>
                <div class="order-drawer" id="order-drawer-panel">
                    <div class="drawer-header">
                        <h3 class="drawer-title">
                            <i class="fa-solid fa-bag-shopping" style="color: var(--gold);"></i> Ma Sélection VIP
                        </h3>
                        <span id="cart-count-badge" style="font-size: 0.8rem; background: rgba(212, 175, 55, 0.15); border: 1px solid var(--border-gold); color: var(--gold-light); padding: 3px 10px; border-radius: 50px; font-weight: 700;">
                            0 article
                        </span>
                    </div>

                    <form action="{{ route('catalog.special.order', $link->token) }}" method="POST" enctype="multipart/form-data" id="order-form">
                        @csrf
                        
                        <!-- Selected Cart Items Container -->
                        <div class="cart-items" id="cart-items-list">
                            <div id="cart-empty-msg" style="text-align: center; padding: 2.2rem 1rem; color: var(--text-secondary); font-size: 0.88rem;">
                                <i class="fa-solid fa-cart-arrow-down" style="font-size: 2.2rem; margin-bottom: 10px; display: block; color: var(--gold); opacity: 0.6;"></i>
                                Cliquez sur <strong>"Ajouter à ma sélection"</strong> sur les projecteurs de votre choix pour composer votre commande.
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="summary-box">
                            <div class="summary-row">
                                <span>Sous-total normal :</span>
                                <span id="summary-orig-total">0,00 DH</span>
                            </div>
                            <div class="summary-row" style="color: var(--success); font-weight: 600;">
                                <span><i class="fa-solid fa-gift"></i> Remise Fidélité (-{{ (int)$discountRate }}%) :</span>
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
                                <i class="fa-solid fa-pen-to-square" style="color: var(--gold);"></i> Instructions pour la commande (Optionnel)
                            </label>
                            <textarea name="global_notes" id="global_notes" rows="2" class="form-input-custom" placeholder="Ex: Livraison souhaitée en début de semaine, lentille rotative..."></textarea>
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

                        <!-- Trust Badges -->
                        <div class="trust-strip">
                            <div class="trust-item">
                                <i class="fa-solid fa-truck-fast"></i> Livraison gratuite
                            </div>
                            <div class="trust-item">
                                <i class="fa-solid fa-shield-halved"></i> Garantie 2 ans
                            </div>
                            <div class="trust-item">
                                <i class="fa-solid fa-gem"></i> Lentille HD incluse
                            </div>
                            <div class="trust-item">
                                <i class="fa-solid fa-headset"></i> Support dédié
                            </div>
                        </div>
                    </form>
                </div>
            </aside>

        </div>
    </main>

    <!-- Mobile Sticky Checkout Bottom Bar -->
    <div class="mobile-bottom-bar">
        <div class="mobile-bar-total">
            <span>Total Privilège (-{{ (int)$discountRate }}%)</span>
            <strong id="mobile-bar-price">0,00 DH</strong>
        </div>
        <button type="button" class="mobile-bar-btn" onclick="scrollToDrawer()">
            <i class="fa-solid fa-bag-shopping"></i> Commander (<span id="mobile-cart-count">0</span>)
        </button>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notify" id="toast-notify">
        <i class="fa-solid fa-circle-check" style="color: var(--success); font-size: 1.2rem;"></i>
        <span id="toast-msg">Projecteur ajouté à votre sélection</span>
    </div>

    <script>
        const hasPastLogo = {{ $pastLogoPath ? 'true' : 'false' }};
        const pastLogoUrl = "{{ $pastLogoUrl ?? '' }}";

        // Navigation and Scroll Helpers
        function scrollToCatalog() {
            document.getElementById('catalog-section').scrollIntoView({ behavior: 'smooth' });
        }
        function scrollToDrawer() {
            const drawer = document.getElementById('order-drawer-panel');
            drawer.scrollIntoView({ behavior: 'smooth' });
        }

        // Show Toast
        function showToast(message) {
            const toast = document.getElementById('toast-notify');
            document.getElementById('toast-msg').textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 2500);
        }

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

        // Product Live Search
        function searchProducts(term) {
            const query = term.toLowerCase().trim();
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const code = card.getAttribute('data-code') || '';
                if (name.includes(query) || code.includes(query)) {
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
            showToast(`+1 ${name} ajouté au panier !`);
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
            const navBadge = document.getElementById('nav-cart-count');
            const mobileCount = document.getElementById('mobile-cart-count');
            const mobilePrice = document.getElementById('mobile-bar-price');
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
                if (navBadge) navBadge.textContent = "0";
                if (mobileCount) mobileCount.textContent = "0";
                if (mobilePrice) mobilePrice.textContent = "0,00 DH";
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

                const countText = `${totalQty} article${totalQty > 1 ? 's' : ''}`;
                badge.textContent = countText;
                if (navBadge) navBadge.textContent = `${totalQty}`;
                if (mobileCount) mobileCount.textContent = `${totalQty}`;

                // Render Per-Projector Units
                if (unitsSection) unitsSection.style.display = 'block';
                renderUnits(flatUnits);
            }

            const savings = Math.max(0, totalOrig - totalDisc);

            document.getElementById('summary-orig-total').textContent = totalOrig.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
            document.getElementById('summary-discount').textContent = '-' + savings.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
            document.getElementById('summary-final-total').textContent = totalDisc.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
            if (mobilePrice) {
                mobilePrice.textContent = totalDisc.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
            }
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
                    <div class="unit-config-card active-unit" id="unit-card-${idx}">
                        <div class="unit-config-header">
                            <span><i class="fa-solid fa-lightbulb" style="color: var(--gold);"></i> Projecteur #${idx + 1} : ${unit.name}</span>
                            <input type="hidden" name="units[${idx}][product_id]" value="${unit.id}">
                        </div>

                        <div class="logo-options-group">
                `;

                if (!isFirst) {
                    html += `
                        <label class="logo-opt-label ${selectedSource === 'same_as_first' ? 'active' : ''}" onclick="selectLogoSource(${idx}, 'same_as_first')">
                            <input type="radio" name="units[${idx}][logo_source]" value="same_as_first" ${selectedSource === 'same_as_first' ? 'checked' : ''}>
                            <i class="fa-solid fa-link" style="color: var(--gold);"></i> Même logo que le Projecteur 1
                        </label>
                    `;
                }

                if (hasPastLogo) {
                    html += `
                        <label class="logo-opt-label ${selectedSource === 'past_logo' ? 'active' : ''}" onclick="selectLogoSource(${idx}, 'past_logo')">
                            <input type="radio" name="units[${idx}][logo_source]" value="past_logo" ${selectedSource === 'past_logo' ? 'checked' : ''}>
                            <i class="fa-solid fa-clock-rotate-left" style="color: var(--accent-cyan);"></i> Utiliser mon logo actuel (1ère commande)
                        </label>
                    `;
                }

                html += `
                    <label class="logo-opt-label ${selectedSource === 'new_upload' ? 'active' : ''}" onclick="selectLogoSource(${idx}, 'new_upload')">
                        <input type="radio" name="units[${idx}][logo_source]" value="new_upload" ${selectedSource === 'new_upload' ? 'checked' : ''}>
                        <i class="fa-solid fa-cloud-arrow-up" style="color: var(--success);"></i> ${!isFirst ? 'Nouveau logo distinct' : 'Télécharger un nouveau logo'}
                    </label>
                `;

                html += `</div>`;

                // Preview for past logo if selected
                if (hasPastLogo && selectedSource === 'past_logo') {
                    html += `
                        <div class="past-logo-preview">
                            <img src="${pastLogoUrl}" alt="Ancien logo">
                            <span>Logo enregistré utilisé pour la fabrication de ce projecteur.</span>
                        </div>
                    `;
                }

                // File Upload input
                html += `
                    <div id="unit-upload-${idx}" style="display: ${selectedSource === 'new_upload' ? 'block' : 'none'}; margin-top: 8px;">
                        <input type="file" name="units[${idx}][logo_file]" class="form-input-custom" accept="image/*,.pdf,.svg">
                        <small style="color: var(--text-secondary); font-size: 0.72rem; display: block; margin-top: 3px;">
                            <i class="fa-solid fa-circle-info"></i> Formats acceptés : PNG haute résolution, JPG, SVG ou PDF vectoriel.
                        </small>
                    </div>
                `;

                // Unit notes
                html += `
                    <div style="margin-top: 8px;">
                        <input type="text" name="units[${idx}][notes]" class="form-input-custom" placeholder="Remarque pour ce projecteur (ex: rotation lente, couleur spéciale...)" style="font-size: 0.76rem; padding: 6px 10px;">
                    </div>
                </div>`;
            });

            container.innerHTML = html;
        }
    </script>
</body>
</html>
