<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Espace Privilège VIP - Projecteur LOGO</title>
    
    <!-- Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #060913;
            --bg-secondary: #0c1222;
            --bg-card: rgba(15, 23, 42, 0.78);
            --bg-card-hover: rgba(23, 35, 62, 0.95);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-gold: rgba(234, 179, 8, 0.35);
            --border-gold-bright: rgba(250, 204, 21, 0.7);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --gold: #eab308;
            --gold-light: #fef08a;
            --gold-accent: #f59e0b;
            --gold-gradient: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            --gold-glow-gradient: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(217, 119, 6, 0.05) 100%);
            --accent-cyan: #38bdf8;
            --cyan-glow: rgba(56, 189, 248, 0.25);
            --success: #10b981;
            --success-light: #34d399;
            --success-bg: rgba(16, 185, 129, 0.14);
            --danger: #ef4444;
            --radius-2xl: 24px;
            --radius-xl: 18px;
            --radius-lg: 14px;
            --radius-md: 10px;
            --shadow-subtle: 0 10px 30px rgba(0, 0, 0, 0.45);
            --shadow-glow: 0 0 35px rgba(234, 179, 8, 0.25);
            --shadow-cyan-glow: 0 0 30px rgba(56, 189, 248, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1, h2, h3, h4, .brand-logo, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            background-image: 
                radial-gradient(circle at 15% 10%, rgba(56, 189, 248, 0.07) 0%, transparent 45%),
                radial-gradient(circle at 85% 25%, rgba(234, 179, 8, 0.09) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 60%);
            background-attachment: fixed;
            color: var(--text-primary);
            min-height: 100vh;
            padding-bottom: 120px;
            overflow-x: hidden;
            line-height: 1.5;
        }



        /* Top Navigation Bar */
        .top-nav {
            background: rgba(6, 9, 19, 0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 0.85rem 1.5rem;
            transition: all 0.3s;
        }
        .nav-inner {
            max-width: 1360px;
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
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.4));
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
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.16) 0%, rgba(217, 119, 6, 0.08) 100%);
            border: 1px solid var(--border-gold);
            padding: 7px 16px;
            border-radius: 50px;
            font-size: 0.82rem;
            color: var(--gold-light);
            font-weight: 700;
            box-shadow: 0 2px 12px rgba(234, 179, 8, 0.15);
        }
        .vip-badge-top .crown-icon {
            color: #facc15;
            animation: pulseCrown 2s infinite ease-in-out;
        }
        @keyframes pulseCrown {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 2px #facc15); }
            50% { transform: scale(1.18); filter: drop-shadow(0 0 8px #facc15); }
        }
        .cart-quick-btn {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-color);
            color: #fff;
            padding: 7px 16px;
            border-radius: 50px;
            font-size: 0.84rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .cart-quick-btn:hover {
            border-color: var(--gold);
            background: rgba(234, 179, 8, 0.16);
            color: var(--gold-light);
            transform: translateY(-1px);
        }

        /* Main Container */
        .main-container {
            max-width: 1360px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Hero Banner - High Luxury Conversion Focus */
        .hero-banner {
            background: 
                radial-gradient(circle at 90% 20%, rgba(234, 179, 8, 0.22) 0%, transparent 60%),
                radial-gradient(circle at 10% 80%, rgba(56, 189, 248, 0.15) 0%, transparent 60%),
                linear-gradient(135deg, rgba(17, 26, 46, 0.95) 0%, rgba(10, 15, 29, 0.98) 100%);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-2xl);
            padding: 2.6rem 2.8rem;
            margin-bottom: 2.2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5), var(--shadow-glow);
        }
        @media (max-width: 768px) {
            .hero-banner {
                padding: 1.8rem 1.4rem;
            }
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 980px;
        }
        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1rem;
            color: var(--gold-light);
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            background: rgba(234, 179, 8, 0.15);
            padding: 5px 14px;
            border-radius: 50px;
            border: 1px solid rgba(234, 179, 8, 0.4);
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.15);
        }
        .hero-title {
            font-size: 2.6rem;
            font-weight: 900;
            line-height: 1.18;
            margin-bottom: 0.9rem;
            color: #ffffff;
            letter-spacing: -0.5px;
        }
        .hero-title .highlight-name {
            background: linear-gradient(135deg, #ffffff 30%, #fef08a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: underline decoration-gold decoration-2;
            text-underline-offset: 6px;
        }
        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.95rem;
            }
        }
        .hero-desc {
            color: var(--text-secondary);
            font-size: 1.08rem;
            line-height: 1.65;
            margin-bottom: 1.8rem;
            max-width: 820px;
        }
        .hero-desc strong {
            color: #fff;
        }

        /* Offer Highlights Strip & Countdown */
        .offer-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            background: rgba(8, 12, 24, 0.88);
            border: 1px solid rgba(234, 179, 8, 0.4);
            border-radius: var(--radius-xl);
            padding: 1.2rem 1.6rem;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.6);
        }
        .discount-pill-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .discount-pill {
            background: var(--gold-gradient);
            color: #060913;
            font-weight: 900;
            font-size: 1.45rem;
            padding: 10px 22px;
            border-radius: var(--radius-md);
            letter-spacing: -0.5px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(234, 179, 8, 0.45);
            animation: pulseGlow 2.5s infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 4px 20px rgba(234, 179, 8, 0.45); }
            50% { box-shadow: 0 4px 30px rgba(250, 204, 21, 0.7); }
        }
        .discount-pill i {
            font-size: 1.3rem;
        }
        .discount-details {
            font-size: 0.94rem;
            color: #fff;
            line-height: 1.4;
        }
        .discount-details strong {
            color: var(--gold-light);
            font-size: 1.05rem;
        }
        .discount-details span {
            color: var(--text-secondary);
            font-size: 0.82rem;
            display: block;
        }
        .countdown-box {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.92rem;
            background: rgba(255, 255, 255, 0.04);
            padding: 8px 16px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
        }
        @media (max-width: 992px) {
            .countdown-box {
                margin-left: 0;
                width: 100%;
                justify-content: space-between;
            }
        }
        .timer-unit {
            background: rgba(234, 179, 8, 0.18);
            border: 1px solid var(--border-gold-bright);
            padding: 5px 12px;
            border-radius: 6px;
            font-family: 'Outfit', monospace;
            font-size: 1.25rem;
            color: var(--gold-light);
            font-weight: 800;
            letter-spacing: 1px;
            box-shadow: 0 0 10px rgba(234, 179, 8, 0.25);
        }

        /* 4 VIP Perks Free Strip */
        .vip-perks-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 1.4rem;
        }
        @media (max-width: 992px) {
            .vip-perks-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 540px) {
            .vip-perks-strip {
                grid-template-columns: 1fr;
            }
        }
        .vip-perk-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: var(--radius-md);
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }
        .vip-perk-card:hover {
            border-color: rgba(234, 179, 8, 0.4);
            background: rgba(234, 179, 8, 0.06);
            transform: translateY(-2px);
        }
        .vip-perk-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(234, 179, 8, 0.15);
            color: var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            border: 1px solid rgba(234, 179, 8, 0.25);
        }
        .vip-perk-text h5 {
            font-size: 0.85rem;
            color: #fff;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .vip-perk-text span {
            font-size: 0.74rem;
            color: var(--success-light);
            font-weight: 700;
            display: block;
        }

        /* ========================================================
           WHY ADD A 2ND PROJECTOR SECTION (THE PSYCHOLOGICAL PUSH)
           ======================================================== */
        .multi-projector-why {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(10, 15, 29, 0.95) 100%);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: var(--radius-2xl);
            padding: 2.4rem;
            margin-bottom: 2.8rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4), var(--shadow-cyan-glow);
        }
        @media (max-width: 768px) {
            .multi-projector-why {
                padding: 1.6rem 1.2rem;
            }
        }
        .why-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 1.8rem;
            flex-wrap: wrap;
            gap: 15px;
        }
        .why-title-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--accent-cyan);
            margin-bottom: 6px;
        }
        .why-title {
            font-size: 1.85rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.25;
            letter-spacing: -0.3px;
        }
        .why-title span {
            background: linear-gradient(135deg, #fef08a 0%, #eab308 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .why-badge-stat {
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: var(--accent-cyan);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.2);
        }
        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.6rem;
            margin-bottom: 1.8rem;
        }
        @media (max-width: 992px) {
            .why-grid {
                grid-template-columns: 1fr;
            }
        }
        .why-card {
            background: rgba(8, 12, 24, 0.85);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
        }
        .why-card:hover {
            transform: translateY(-6px);
            border-color: rgba(234, 179, 8, 0.6);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.5), 0 0 25px rgba(234, 179, 8, 0.2);
        }
        .why-card-media {
            height: 210px;
            width: 100%;
            position: relative;
            overflow: hidden;
            background: #000;
            cursor: pointer;
        }
        .why-card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .why-card:hover .why-card-media img {
            transform: scale(1.08);
        }
        .why-card-media-tag {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(6, 9, 19, 0.88);
            border: 1px solid var(--border-gold);
            color: var(--gold-light);
            font-size: 0.74rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            backdrop-filter: blur(6px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.5);
        }
        .why-card-discount-tag {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--gold-gradient);
            color: #060913;
            font-size: 0.72rem;
            font-weight: 900;
            padding: 3px 9px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            text-transform: uppercase;
        }
        .why-card-media-zoom {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            opacity: 0;
            transition: opacity 0.2s, transform 0.2s;
            transform: scale(0.8);
        }
        .why-card-media:hover .why-card-media-zoom {
            opacity: 1;
            transform: scale(1);
        }
        .why-card-body {
            padding: 1.4rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .why-card-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
            line-height: 1.3;
        }
        .why-card-desc {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.55;
            margin-bottom: 14px;
        }
        .why-card-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .why-card-pill {
            font-size: 0.75rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            background: rgba(16, 185, 129, 0.16);
            color: var(--success-light);
            border: 1px solid rgba(16, 185, 129, 0.35);
        }
        .why-card-cta {
            font-size: 0.8rem;
            color: var(--gold-light);
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: gap 0.2s;
        }
        .why-card-cta:hover {
            gap: 8px;
            color: #fff;
        }

        /* Multiplier Summary Strip */
        .visibility-multiplier-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(8, 12, 24, 0.92);
            border: 1px dashed rgba(234, 179, 8, 0.45);
            border-radius: var(--radius-lg);
            padding: 1.2rem 1.6rem;
            flex-wrap: wrap;
            gap: 15px;
        }
        .multiplier-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .multiplier-tag {
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--gold-light);
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }
        .multiplier-desc {
            font-size: 0.92rem;
            color: var(--text-secondary);
            line-height: 1.45;
        }
        .multiplier-desc strong {
            color: #fff;
        }

        /* ========================================================
           ANIMATED REALISATIONS SHOWCASE (INFINITE MARQUEE)
           ======================================================== */
        .showcase-section {
            margin-bottom: 2.8rem;
        }
        .showcase-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 1.2rem;
            flex-wrap: wrap;
            gap: 12px;
        }
        .showcase-title-wrap h3 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .showcase-title-wrap p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-top: 4px;
        }
        .realisations-marquee-wrap {
            position: relative;
            overflow: hidden;
            padding: 14px 0;
            mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
        }
        .realisations-track {
            display: flex;
            gap: 1.5rem;
            width: max-content;
            animation: scrollMarquee 45s linear infinite;
        }
        .realisations-marquee-wrap:hover .realisations-track {
            animation-play-state: paused;
        }
        @keyframes scrollMarquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-50% - 0.75rem)); }
        }
        .realisation-thumb-card {
            width: 260px;
            height: 320px;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        .realisation-thumb-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: var(--gold);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.6), 0 0 25px rgba(234, 179, 8, 0.3);
        }
        .realisation-img-container {
            height: 220px;
            width: 100%;
            overflow: hidden;
            position: relative;
            background: #000;
        }
        .realisation-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .realisation-thumb-card:hover .realisation-img-container img {
            transform: scale(1.1);
        }
        .realisation-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(6, 9, 19, 0.88);
            border: 1px solid var(--border-gold);
            color: var(--gold-light);
            font-size: 0.72rem;
            font-weight: 800;
            padding: 3px 9px;
            border-radius: 4px;
            backdrop-filter: blur(4px);
        }
        .realisation-hover-hint {
            position: absolute;
            inset: 0;
            background: rgba(6, 9, 19, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.25s;
        }
        .realisation-thumb-card:hover .realisation-hover-hint {
            opacity: 1;
        }
        .zoom-btn-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #060913;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 6px 16px rgba(0,0,0,0.5);
            transform: scale(0.85);
            transition: transform 0.2s;
        }
        .realisation-thumb-card:hover .zoom-btn-circle {
            transform: scale(1);
        }
        .realisation-thumb-body {
            padding: 10px 14px;
            background: rgba(8, 12, 24, 0.95);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .realisation-thumb-title {
            font-size: 0.94rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .realisation-thumb-cat {
            font-size: 0.78rem;
            color: var(--text-secondary);
        }

        /* 3-Step Simple Roadmap */
        .steps-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.2rem;
            margin-bottom: 2.4rem;
        }
        @media (max-width: 768px) {
            .steps-bar {
                grid-template-columns: 1fr;
            }
        }
        .step-item {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.1rem 1.3rem;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.2s ease;
        }
        .step-item:hover {
            border-color: rgba(234, 179, 8, 0.4);
            background: rgba(23, 35, 62, 0.6);
        }
        .step-num {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #060913;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(234, 179, 8, 0.3);
        }
        .step-text h4 {
            font-size: 0.95rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 2px;
        }
        .step-text p {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Layout Grid */
        .catalog-layout {
            display: grid;
            grid-template-columns: 1fr 450px;
            gap: 2.2rem;
            align-items: start;
        }
        @media (max-width: 1120px) {
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
            gap: 14px;
            margin-bottom: 1.6rem;
            padding-bottom: 1.2rem;
            border-bottom: 1px solid var(--border-color);
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
            padding: 9px 18px;
            border-radius: 50px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .cat-btn:hover, .cat-btn.active {
            background: rgba(234, 179, 8, 0.16);
            color: var(--gold-light);
            border-color: var(--border-gold-bright);
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.15);
        }
        .search-box {
            position: relative;
            min-width: 260px;
        }
        .search-box input {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 9px 18px 9px 40px;
            color: #fff;
            font-size: 0.88rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-box input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.2);
        }
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(285px, 1fr));
            gap: 1.8rem;
        }
        .product-card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }
        .product-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-gold-bright);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.55), var(--shadow-glow);
        }
        .product-discount-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: var(--gold-gradient);
            color: #060913;
            font-size: 0.85rem;
            font-weight: 900;
            padding: 5px 12px;
            border-radius: 50px;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            gap: 5px;
            letter-spacing: -0.2px;
        }
        .product-tag-popular {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(56, 189, 248, 0.2);
            border: 1px solid rgba(56, 189, 248, 0.5);
            color: var(--accent-cyan);
            font-size: 0.74rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            z-index: 2;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .product-img-wrap {
            height: 220px;
            background: radial-gradient(circle at center, #1b2842 0%, #060b14 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }
        /* Visual Light Cone Effect behind projector */
        .product-img-wrap::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, rgba(234, 179, 8, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            transition: all 0.4s ease;
        }
        .product-card:hover .product-img-wrap::after {
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(234, 179, 8, 0.35) 0%, transparent 70%);
        }
        .product-img-wrap img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.4s ease;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.6));
            position: relative;
            z-index: 1;
        }
        .product-card:hover .product-img-wrap img {
            transform: scale(1.09) rotate(-1deg);
        }
        .product-body {
            padding: 1.4rem;
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
            font-size: 0.78rem;
            color: var(--gold-light);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .product-ref {
            font-size: 0.74rem;
            color: var(--text-muted);
            font-family: monospace;
            background: rgba(255, 255, 255, 0.05);
            padding: 2px 6px;
            border-radius: 4px;
        }
        .product-name {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 6px;
            color: #fff;
            line-height: 1.35;
        }
        .product-desc {
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 1.1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-features-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 1.2rem;
        }
        .feature-pill {
            font-size: 0.74rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .feature-pill i {
            color: var(--gold);
        }

        /* Dual Price Container with Striking Contrast */
        .price-section {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            padding-top: 14px;
            margin-bottom: 16px;
            background: rgba(6, 9, 19, 0.4);
            padding: 12px;
            border-radius: var(--radius-md);
        }
        .price-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }
        .orig-price-label {
            font-size: 0.72rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
        }
        .orig-price {
            text-decoration: line-through;
            color: #ef4444;
            font-size: 0.95rem;
            font-weight: 700;
            opacity: 0.85;
        }
        .savings-tag {
            font-size: 0.78rem;
            color: var(--success-light);
            font-weight: 800;
            background: var(--success-bg);
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 5px;
        }
        .vip-price-wrap {
            text-align: right;
        }
        .vip-price-label {
            font-size: 0.72rem;
            color: var(--gold-light);
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .vip-price {
            background: linear-gradient(135deg, #ffffff 20%, #fef08a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.65rem;
            font-weight: 900;
            line-height: 1;
            font-family: 'Outfit', sans-serif;
        }
        .vip-price small {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--gold-light);
            -webkit-text-fill-color: var(--gold-light);
        }
        .free-lens-mention {
            font-size: 0.74rem;
            color: var(--gold-light);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
        }

        .btn-add {
            width: 100%;
            background: rgba(234, 179, 8, 0.12);
            color: var(--gold-light);
            border: 1px solid var(--border-gold);
            padding: 12px;
            border-radius: var(--radius-md);
            font-weight: 800;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .btn-add:hover {
            background: var(--gold-gradient);
            color: #060913;
            border-color: transparent;
            box-shadow: 0 6px 20px rgba(234, 179, 8, 0.45);
            transform: translateY(-2px);
        }

        /* Cart / Order Drawer */
        .order-drawer {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-2xl);
            padding: 1.8rem;
            position: sticky;
            top: 90px;
            box-shadow: 0 16px 45px rgba(0, 0, 0, 0.5), var(--shadow-glow);
        }
        .drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.2rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 14px;
        }
        .drawer-title {
            font-size: 1.35rem;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
        }
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 260px;
            overflow-y: auto;
            margin-bottom: 1.2rem;
            padding-right: 4px;
        }
        .cart-item {
            background: rgba(8, 12, 24, 0.8);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeIn 0.25s ease-out;
            transition: border-color 0.2s;
        }
        .cart-item:hover {
            border-color: rgba(234, 179, 8, 0.4);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .cart-item-info {
            flex-grow: 1;
        }
        .cart-item-name {
            font-size: 0.92rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 2px;
        }
        .cart-item-price {
            font-size: 0.86rem;
            color: var(--gold-light);
            font-weight: 800;
        }
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.06);
            padding: 3px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        .qty-btn {
            background: transparent;
            border: none;
            color: #fff;
            width: 26px;
            height: 26px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 800;
            transition: background 0.15s;
        }
        .qty-btn:hover {
            background: var(--gold);
            color: #060913;
        }
        .qty-number {
            font-size: 0.92rem;
            font-weight: 800;
            min-width: 24px;
            text-align: center;
        }

        /* Savings Live Meter in Drawer */
        .savings-meter-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(6, 78, 59, 0.25) 100%);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: var(--radius-md);
            padding: 12px 14px;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .savings-meter-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .savings-meter-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.25);
            color: var(--success-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }
        .savings-meter-title {
            font-size: 0.78rem;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
        }
        .savings-meter-amount {
            font-size: 1.15rem;
            font-weight: 900;
            color: var(--success-light);
            font-family: 'Outfit', sans-serif;
        }

        .summary-box {
            background: rgba(8, 12, 24, 0.7);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 14px;
            margin-bottom: 1.2rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin-bottom: 7px;
        }
        .summary-row.gift-row {
            color: var(--gold-light);
            font-size: 0.82rem;
            font-weight: 600;
        }
        .summary-total {
            border-top: 1px dashed rgba(234, 179, 8, 0.45);
            padding-top: 12px;
            margin-top: 10px;
            font-size: 1.45rem;
            font-weight: 900;
            color: #fff;
            font-family: 'Outfit', sans-serif;
        }
        .summary-total span:last-child {
            background: linear-gradient(135deg, #ffffff 20%, #fef08a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Units Logo Customization Cards */
        .units-section {
            margin-top: 1.2rem;
            border-top: 1px solid var(--border-color);
            padding-top: 1.2rem;
        }
        .units-section-title {
            font-size: 0.98rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .unit-config-card {
            background: rgba(8, 12, 24, 0.85);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 14px;
            margin-bottom: 12px;
            position: relative;
        }
        .unit-config-card.active-unit {
            border-color: rgba(234, 179, 8, 0.45);
        }
        .unit-config-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.88rem;
            font-weight: 800;
            color: var(--gold-light);
            margin-bottom: 10px;
        }
        .logo-options-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 8px;
        }
        .logo-opt-label {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 0.82rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }
        .logo-opt-label:hover {
            border-color: var(--border-gold);
            color: #fff;
            background: rgba(255, 255, 255, 0.07);
        }
        .logo-opt-label.active {
            background: rgba(234, 179, 8, 0.18);
            border-color: var(--gold);
            color: var(--gold-light);
            font-weight: 700;
        }
        .logo-opt-label input[type="radio"] {
            display: none;
        }
        .past-logo-preview {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #000;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid rgba(234, 179, 8, 0.35);
            margin-top: 8px;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }
        .past-logo-preview img {
            max-height: 42px;
            max-width: 60px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.05);
            padding: 3px;
            border-radius: 4px;
        }

        .form-group-custom {
            margin-top: 1rem;
        }
        .form-label-custom {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
        }
        .form-input-custom {
            width: 100%;
            background: rgba(8, 12, 24, 0.9);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 14px;
            color: #fff;
            font-size: 0.88rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input-custom:focus {
            border-color: var(--gold);
            box-shadow: 0 0 12px rgba(234, 179, 8, 0.25);
        }

        .btn-checkout {
            width: 100%;
            background: var(--gold-gradient);
            color: #060913;
            border: none;
            padding: 16px;
            border-radius: var(--radius-md);
            font-weight: 900;
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 1.4rem;
            box-shadow: 0 8px 25px rgba(234, 179, 8, 0.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            letter-spacing: -0.2px;
        }
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(234, 179, 8, 0.55);
        }
        .btn-checkout:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .reassurance-checks {
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 0.78rem;
            color: var(--text-secondary);
        }
        .reassurance-check-item {
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .reassurance-check-item i {
            color: var(--success-light);
            font-size: 0.85rem;
        }

        /* Trust & Security Badges */
        .trust-strip {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 1.4rem;
            padding-top: 1.2rem;
            border-top: 1px solid var(--border-color);
        }
        .trust-item {
            font-size: 0.76rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
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
            background: rgba(6, 9, 19, 0.96);
            backdrop-filter: blur(16px);
            border-top: 1px solid var(--border-gold);
            padding: 12px 18px;
            z-index: 99;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.6);
        }
        @media (max-width: 1120px) {
            .mobile-bottom-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
            }
        }
        .mobile-bar-total {
            display: flex;
            flex-direction: column;
        }
        .mobile-bar-total span {
            font-size: 0.74rem;
            color: var(--text-secondary);
        }
        .mobile-bar-total strong {
            font-size: 1.25rem;
            color: var(--gold-light);
            font-weight: 900;
            font-family: 'Outfit', sans-serif;
        }
        .mobile-bar-btn {
            background: var(--gold-gradient);
            color: #060913;
            border: none;
            padding: 12px 22px;
            border-radius: var(--radius-md);
            font-weight: 900;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(234, 179, 8, 0.4);
        }

        /* Toast notification */
        .toast-notify {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #0f172a;
            border: 1px solid var(--gold);
            color: #fff;
            padding: 14px 22px;
            border-radius: var(--radius-md);
            box-shadow: 0 12px 35px rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.92rem;
            font-weight: 600;
            z-index: 999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .toast-notify.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Lightbox Modal */
        .lightbox-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            backdrop-filter: blur(12px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .lightbox-modal.active {
            display: flex;
        }
        .lightbox-content {
            background: #0f172a;
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-2xl);
            max-width: 720px;
            width: 100%;
            overflow: hidden;
            position: relative;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
            animation: fadeIn 0.25s ease-out;
        }
        .lightbox-close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: background 0.2s;
        }
        .lightbox-close:hover {
            background: var(--gold);
            color: #000;
        }
        .lightbox-img-wrap {
            height: 400px;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .lightbox-img-wrap img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .lightbox-info {
            padding: 1.6rem;
        }
        .lightbox-tag {
            font-size: 0.78rem;
            color: var(--gold-light);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
        }
        .lightbox-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
        }
        .lightbox-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.55;
            margin-bottom: 1.2rem;
        }
    </style>
</head>
<body>

    @php
        // Curated Top-Tier Realisations from public/realisations/
        $curatedRealisations = [
            [
                'img' => asset('realisations/RealisationDHL.jpg'),
                'title' => 'DHL Express',
                'category' => 'Enseigne & Services Internationaux',
                'tag' => 'Trottoir Nocturne HD',
                'desc' => 'Projection haute puissance offrant une visibilité nette et lumineuse à plus de 40 mètres.'
            ],
            [
                'img' => asset('realisations/RealisationSushiCraft.jpg'),
                'title' => 'Sushi Craft',
                'category' => 'Gastronomie & Lounge',
                'tag' => 'Rue Passante & Piétons',
                'desc' => 'Capte le regard des passants venant des 2 côtés de la rue avec un contraste parfait sur le sol.'
            ],
            [
                'img' => asset('realisations/RealisationCasaDeHakimi.jpg'),
                'title' => 'Casa De Hakimi',
                'category' => 'Restaurant & Café Prestige',
                'tag' => 'Façade & Entrée Principale',
                'desc' => 'Mise en valeur haut de gamme qui valorise immédiatement la devanture de l\'établissement.'
            ],
            [
                'img' => asset('realisations/RealisationTheFrenchTacos.jpg'),
                'title' => 'The French Tacos',
                'category' => 'Fast Casual',
                'tag' => 'Projection Sol Trottoir',
                'desc' => 'Multiplie le flux de clients grâce à une présence lumineuse incontournable dès la tombée de la nuit.'
            ],
            [
                'img' => asset('realisations/RealisationStreetFood.jpg'),
                'title' => 'Street Food',
                'category' => 'Restauration Urbaine',
                'tag' => 'Double Sens Trottoir',
                'desc' => 'Attire les piétons en continu avant même qu\'ils n\'arrivent devant la porte du restaurant.'
            ],
            [
                'img' => asset('realisations/RealisationBijouterieHicham.jpg'),
                'title' => 'Bijouterie Hicham',
                'category' => 'Luxe & Bijouterie',
                'tag' => 'Élégance & Standing',
                'desc' => 'Projection fine et raffinée renforçant le positionnement prestige de la boutique.'
            ],
            [
                'img' => asset('realisations/RealisationMarisco.jpg'),
                'title' => 'Marisco Restaurant',
                'category' => 'Gastronomie de la Mer',
                'tag' => 'Grand Angle Lumineux',
                'desc' => 'Lentille optique gravée haute précision offrant une luminosité vive même sous l\'éclairage public.'
            ],
            [
                'img' => asset('realisations/RealisationOptiqueFrance.jpg'),
                'title' => 'Optique France',
                'category' => 'Santé & Optique',
                'tag' => 'Boutique & Retail',
                'desc' => 'Repérage visuel instantané qui démarque le magasin de tous ses concurrents alentours.'
            ],
            [
                'img' => asset('realisations/RealisationTopGym.jpg'),
                'title' => 'Top Gym Club',
                'category' => 'Sport & Fitness Club',
                'tag' => 'Impact & Dynamisme',
                'desc' => 'Projection énergique et moderne incitant naturellement les nouveaux adhérents à entrer.'
            ],
            [
                'img' => asset('realisations/RealisationInwiMoney.jpg'),
                'title' => 'Inwi Money',
                'category' => 'Point de Vente & Réseau',
                'tag' => 'Signalétique Forte',
                'desc' => 'Excellente visibilité au sol guidant les usagers directement vers l\'entrée de l\'agence.'
            ],
        ];
    @endphp



    <!-- Top Navigation -->
    <header class="top-nav">
        <div class="nav-inner">
            <a href="#" class="brand-logo">
                <img src="{{ asset('logo.png') }}" alt="Projecteur LOGO" onerror="this.style.display='none'; document.getElementById('alt-logo-text').style.display='block';">
                <span id="alt-logo-text" style="display: none; font-weight: 900; font-size: 1.25rem; color: var(--gold);">PROJECTEUR LOGO</span>
            </a>
            <div class="nav-right-actions">
                <div class="vip-badge-top">
                    <i class="fa-solid fa-crown crown-icon"></i>
                    <span>Client Privilège : <strong>{{ $customer->name }}</strong></span>
                </div>
                <button type="button" class="cart-quick-btn" onclick="scrollToDrawer()">
                    <i class="fa-solid fa-bag-shopping" style="color: var(--gold);"></i>
                    <span>Panier (<strong id="nav-cart-count">0</strong>)</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main-container">

        <!-- Hero Banner with Discount Status & Live Timer -->
        <section class="hero-banner">
            <div class="hero-content">
                <div class="hero-tag">
                    <i class="fa-solid fa-gem"></i> Offre Fidélité & Réassort Client Certifié
                </div>
                <h1 class="hero-title">
                    Ravi de vous revoir, <span class="highlight-name">{{ $customer->name }}</span> !
                </h1>
                <p class="hero-desc">
                    Votre premier projecteur illumine déjà votre établissement avec succès. En tant que <strong>Client Fidèle</strong>, profitez de votre tarif préférentiel exclusif pour décupler votre visibilité avec un <strong>2ème projecteur stratégique</strong>.
                </p>

                <!-- Offer Strip with Massive Discount Sensation -->
                <div class="offer-strip">
                    <div class="discount-pill-wrap">
                        <div class="discount-pill">
                            <i class="fa-solid fa-bolt-lightning"></i> -{{ (int)$discountRate }}% IMMÉDIAT
                        </div>
                        <div class="discount-details">
                            @if($isInitialPeriod)
                                <strong>Offre Spéciale Bienvenue (10 premiers jours)</strong>
                                <span>Remise maximale de -11% sur tout le catalogue. Vous conserverez ensuite -5% à vie.</span>
                            @else
                                <strong>Remise Permanente Compte Client VIP</strong>
                                <span>Tarif privilège de -5% appliqué à vie sur toutes vos commandes de réassort.</span>
                            @endif
                        </div>
                    </div>

                    @if($isInitialPeriod)
                        <div class="countdown-box" id="timer-box">
                            <div>
                                <i class="fa-regular fa-clock" style="color: var(--gold);"></i> 
                                <span style="font-size: 0.8rem; color: var(--text-secondary); display: block;">Fin de l'offre -11% dans :</span>
                            </div>
                            <div class="timer-unit" id="timer-display">--j --h --m</div>
                        </div>
                    @endif
                </div>

                <!-- 4 VIP Free Perks Included (450 DH Value) -->
                <div class="vip-perks-strip">
                    <div class="vip-perk-card">
                        <div class="vip-perk-icon"><i class="fa-solid fa-gem"></i></div>
                        <div class="vip-perk-text">
                            <h5>Lentille HD Sur-Mesure</h5>
                            <span>OFFERTE (Valeur 350 DH)</span>
                        </div>
                    </div>
                    <div class="vip-perk-card">
                        <div class="vip-perk-icon"><i class="fa-solid fa-truck-fast"></i></div>
                        <div class="vip-perk-text">
                            <h5>Livraison Partout au Maroc</h5>
                            <span>GRATUITE (Valeur 100 DH)</span>
                        </div>
                    </div>
                    <div class="vip-perk-card">
                        <div class="vip-perk-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="vip-perk-text">
                            <h5>Garantie Constructeur</h5>
                            <span>2 Ans Inclus</span>
                        </div>
                    </div>
                    <div class="vip-perk-card">
                        <div class="vip-perk-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <div class="vip-perk-text">
                            <h5>Assistance & BAT Graphique</h5>
                            <span>Validation avant fabrication</span>
                        </div>
                    </div>
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
                    <i class="fa-solid fa-chart-line"></i> +100% de visibilité piétonne captée
                </div>
            </div>

            <div class="why-grid">
                <!-- Angle 1 with Generated 3D/Photo Render -->
                <div class="why-card">
                    <div class="why-card-media" onclick="openLightbox('{{ asset('images/arguments/argument1_double_flux.jpg') }}', 'Couvrez les 2 sens de votre rue', 'Deux projecteurs installés en duo couvrant simultanément les deux directions de circulation piétonne et routière pour ne manquer aucun passant.')">
                        <img src="{{ asset('images/arguments/argument1_double_flux.jpg') }}" alt="Couvrez les 2 sens de votre rue">
                        <div class="why-card-discount-tag"><i class="fa-solid fa-tag"></i> Éligible -{{ (int)$discountRate }}%</div>
                        <div class="why-card-media-tag"><i class="fa-solid fa-arrows-left-right"></i> Trottoir 2 Sens 360°</div>
                        <div class="why-card-media-zoom"><i class="fa-solid fa-expand"></i></div>
                    </div>
                    <div class="why-card-body">
                        <h3 class="why-card-title">1. Couvrez les 2 sens de votre rue</h3>
                        <p class="why-card-desc">
                            Un seul projecteur ne cible que les passants venant d'un côté. Avec un second projecteur orienté dans le sens opposé, aucun piéton ni véhicule ne peut rater votre enseigne.
                        </p>
                        <div class="why-card-footer">
                            <span class="why-card-pill"><i class="fa-solid fa-check"></i> 0 client manqué</span>
                            <span class="why-card-cta" onclick="scrollToCatalog()">Voir les modèles <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Angle 2 with Generated 3D/Photo Render -->
                <div class="why-card">
                    <div class="why-card-media" onclick="openLightbox('{{ asset('images/arguments/argument2_exterieur_interieur.jpg') }}', 'Duo Extérieur Trottoir + Accueil Intérieur', 'Une projection extérieure sur trottoir pour attirer le flux depuis la rue, et une projection intérieure prestigieuse au sol du hall d\'accueil ou du comptoir.')">
                        <img src="{{ asset('images/arguments/argument2_exterieur_interieur.jpg') }}" alt="Extérieur et Intérieur">
                        <div class="why-card-discount-tag"><i class="fa-solid fa-tag"></i> Éligible -{{ (int)$discountRate }}%</div>
                        <div class="why-card-media-tag"><i class="fa-solid fa-store"></i> Dehors + Dedans</div>
                        <div class="why-card-media-zoom"><i class="fa-solid fa-expand"></i></div>
                    </div>
                    <div class="why-card-body">
                        <h3 class="why-card-title">2. Duo Extérieur Trottoir + Accueil Intérieur</h3>
                        <p class="why-card-desc">
                            Le 1er projecteur attire le flux de l'extérieur vers votre porte. Le 2ème crée une ambiance prestige au sol ou au mur de votre accueil, salle d'attente ou comptoir.
                        </p>
                        <div class="why-card-footer">
                            <span class="why-card-pill"><i class="fa-solid fa-star"></i> Expérience client VIP</span>
                            <span class="why-card-cta" onclick="scrollToCatalog()">Voir les modèles <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Angle 3 with Generated 3D/Photo Render -->
                <div class="why-card">
                    <div class="why-card-media" onclick="openLightbox('{{ asset('images/arguments/argument3_logo_promo_qr.jpg') }}', 'Logo Permanent + Promo ou QR Code', 'Un projecteur pour graver votre marque officielle, et un second pour afficher un QR code géant scannable par smartphone ou vos offres promos du moment.')">
                        <img src="{{ asset('images/arguments/argument3_logo_promo_qr.jpg') }}" alt="Logo et Promo QR Code">
                        <div class="why-card-discount-tag"><i class="fa-solid fa-tag"></i> Éligible -{{ (int)$discountRate }}%</div>
                        <div class="why-card-media-tag"><i class="fa-solid fa-qrcode"></i> Marque & Promos QR</div>
                        <div class="why-card-media-zoom"><i class="fa-solid fa-expand"></i></div>
                    </div>
                    <div class="why-card-body">
                        <h3 class="why-card-title">3. Logo Permanent + Promo ou QR Code</h3>
                        <p class="why-card-desc">
                            Dédiez votre premier projecteur à votre logo officiel, et le second pour projeter vos offres spéciales, menus, ou QR Code Instagram/WhatsApp pour gagner des abonnés.
                        </p>
                        <div class="why-card-footer">
                            <span class="why-card-pill"><i class="fa-solid fa-arrow-trend-up"></i> Ventes directes & Réseaux</span>
                            <span class="why-card-cta" onclick="scrollToCatalog()">Voir les modèles <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Multiplier Summary Strip -->
            <div class="visibility-multiplier-strip">
                <div class="multiplier-left">
                    <div class="multiplier-tag">
                        <i class="fa-solid fa-gem" style="color: var(--gold);"></i> DOUBLEZ VOTRE IMPACT VISUEL
                    </div>
                    <div class="multiplier-desc">
                        Profitez de votre remise exclusive de <strong>-{{ (int)$discountRate }}%</strong> et de vos <strong>450 DH d'avantages offerts</strong> pour équiper votre 2ème point dès aujourd'hui !
                    </div>
                </div>
                <button type="button" class="btn-add" style="width: auto; padding: 12px 26px;" onclick="scrollToCatalog()">
                    <i class="fa-solid fa-arrow-down"></i> Découvrir les projecteurs éligibles
                </button>
            </div>
        </section>

        <!-- =========================================================
             ANIMATED REALISATIONS SHOWCASE (INFINITE MARQUEE)
             ========================================================= -->
        <section class="showcase-section">
            <div class="showcase-header">
                <div class="showcase-title-wrap">
                    <h3>
                        <i class="fa-solid fa-camera-retro" style="color: var(--gold);"></i>
                        Exemples de Réalisations chez nos Clients au Maroc
                    </h3>
                    <p>Découvrez la puissance et la netteté des projections réalisées chez des enseignes prestigieuses (Survolez pour mettre en pause & cliquez pour agrandir)</p>
                </div>
                <div style="font-size: 0.82rem; color: var(--gold-light); display: flex; align-items: center; gap: 8px; font-weight: 700;">
                    <i class="fa-solid fa-hand-pointer"></i> Cliquez pour agrandir
                </div>
            </div>

            <div class="realisations-marquee-wrap">
                <div class="realisations-track">
                    <!-- Set 1 -->
                    @foreach($curatedRealisations as $item)
                        <div class="realisation-thumb-card" onclick="openLightbox('{{ $item['img'] }}', '{{ addslashes($item['title']) }}', '{{ addslashes($item['desc']) }}')">
                            <div class="realisation-img-container">
                                <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" loading="lazy">
                                <div class="realisation-badge">{{ $item['tag'] }}</div>
                                <div class="realisation-hover-hint">
                                    <div class="zoom-btn-circle"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                                </div>
                            </div>
                            <div class="realisation-thumb-body">
                                <div class="realisation-thumb-title">{{ $item['title'] }}</div>
                                <div class="realisation-thumb-cat">{{ $item['category'] }}</div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Set 2 (for seamless infinite loop) -->
                    @foreach($curatedRealisations as $item)
                        <div class="realisation-thumb-card" onclick="openLightbox('{{ $item['img'] }}', '{{ addslashes($item['title']) }}', '{{ addslashes($item['desc']) }}')">
                            <div class="realisation-img-container">
                                <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" loading="lazy">
                                <div class="realisation-badge">{{ $item['tag'] }}</div>
                                <div class="realisation-hover-hint">
                                    <div class="zoom-btn-circle"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                                </div>
                            </div>
                            <div class="realisation-thumb-body">
                                <div class="realisation-thumb-title">{{ $item['title'] }}</div>
                                <div class="realisation-thumb-cat">{{ $item['category'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 3-Step Simple Roadmap -->
        <div class="steps-bar">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">
                    <h4>Choisissez vos modèles</h4>
                    <p>Remise de -{{ (int)$discountRate }}% déduite automatiquement</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">
                    <h4>Associez vos logos</h4>
                    <p>Réutilisez votre logo actuel ou transmettez-en un nouveau</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">
                    <h4>Validation express</h4>
                    <p>Paiement sécurisé à la livraison après contrôle</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="filter-header" id="catalog-section">
            @if($categories->count() > 0)
                <div class="category-filter">
                    <button class="cat-btn active" onclick="filterCategory('all', this)">
                        <i class="fa-solid fa-border-all"></i> Tous les modèles ({{ $products->count() }})
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
                <input type="text" id="catalog-search" placeholder="Rechercher par puissance, référence..." oninput="searchProducts(this.value)">
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

                            $code = strtoupper($prod->code ?? '');
                            $name = $prod->name ?? '';

                            // Product badges & highlights
                            $subBadge = 'Projecteur LED Pro';
                            $pills = [
                                ['icon' => 'fa-certificate', 'text' => 'Lentille HD Gravée Offerte'],
                                ['icon' => 'fa-shield-halved', 'text' => 'Garanti 2 ans'],
                                ['icon' => 'fa-droplet', 'text' => 'IP65 Étanche'],
                            ];

                            if (strpos($code, '25W-ENC') !== false) {
                                $subBadge = 'Encastrable & Discret';
                                $pills = [
                                    ['icon' => 'fa-bolt', 'text' => '25W LED Cree'],
                                    ['icon' => 'fa-expand', 'text' => 'Encastrable Plafond'],
                                    ['icon' => 'fa-ruler', 'text' => 'Portée jusqu\'à 5m'],
                                    ['icon' => 'fa-droplet', 'text' => 'IP65 Étanche'],
                                ];
                            } elseif (strpos($code, '25W-FIX') !== false) {
                                $subBadge = 'Compact & Polyvalent';
                                $pills = [
                                    ['icon' => 'fa-bolt', 'text' => '25W LED HD'],
                                    ['icon' => 'fa-arrows-to-dot', 'text' => 'Façade ou Trottoir'],
                                    ['icon' => 'fa-ruler', 'text' => 'Portée jusqu\'à 5m'],
                                    ['icon' => 'fa-droplet', 'text' => 'IP65 Étanche'],
                                ];
                            } elseif (strpos($code, '35W-FIX') !== false) {
                                $subBadge = 'Portée 8m · Équilibré';
                                $pills = [
                                    ['icon' => 'fa-bolt', 'text' => '35W LED Pure'],
                                    ['icon' => 'fa-gem', 'text' => 'Optique Quartz'],
                                    ['icon' => 'fa-ruler', 'text' => 'Portée jusqu\'à 8m'],
                                    ['icon' => 'fa-droplet', 'text' => 'IP65 Étanche'],
                                ];
                            } elseif (strpos($code, '35W-ROT') !== false) {
                                $subBadge = 'Rotation Dynamique 360°';
                                $pills = [
                                    ['icon' => 'fa-rotate', 'text' => 'Rotation 360° Fluide'],
                                    ['icon' => 'fa-bolt', 'text' => '35W LED HD'],
                                    ['icon' => 'fa-ruler', 'text' => 'Portée jusqu\'à 8m'],
                                    ['icon' => 'fa-volume-xmark', 'text' => 'Moteur Silencieux'],
                                ];
                            } elseif (strpos($code, '55W-FIX') !== false) {
                                $subBadge = 'Best-Seller Haute Puissance';
                                $pills = [
                                    ['icon' => 'fa-sun', 'text' => '55W Haute Puissance'],
                                    ['icon' => 'fa-ruler', 'text' => 'Portée jusqu\'à 15m'],
                                    ['icon' => 'fa-clock', 'text' => 'Durée 30 000h'],
                                    ['icon' => 'fa-droplet', 'text' => 'IP65 Tout Temps'],
                                ];
                            } elseif (strpos($code, '55W-ROT') !== false) {
                                $subBadge = 'Haut de Gamme · Télécommandé';
                                $pills = [
                                    ['icon' => 'fa-tower-broadcast', 'text' => 'Télécommande Sans Fil'],
                                    ['icon' => 'fa-rotate', 'text' => 'Rotation 360° Pilotable'],
                                    ['icon' => 'fa-sun', 'text' => '55W Haute Puissance'],
                                    ['icon' => 'fa-ruler', 'text' => 'Portée jusqu\'à 15m'],
                                ];
                            }

                            // Determine image URL
                            $imgUrl = asset('logo.png');
                            if ($prod->image) {
                                if (str_starts_with($prod->image, 'images/') || str_starts_with($prod->image, 'realisations/')) {
                                    $imgUrl = asset($prod->image);
                                } else {
                                    $imgUrl = asset('public-storage/' . $prod->image);
                                }
                            }
                        @endphp
                        <div class="product-card" data-category="cat-{{ $prod->category_id ?? 'none' }}" data-name="{{ strtolower($prod->name) }}" data-code="{{ strtolower($prod->code) }}">
                            <span class="product-discount-badge">
                                <i class="fa-solid fa-tag"></i> -{{ (int)$discountRate }}% VIP
                            </span>
                            <span class="product-tag-popular">
                                <i class="fa-solid fa-star"></i> {{ $subBadge }}
                            </span>

                            <div class="product-img-wrap">
                                <img src="{{ $imgUrl }}" alt="{{ $prod->name }}" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                            </div>

                            <div class="product-body">
                                <div class="product-meta-row">
                                    <span class="product-cat">{{ $prod->category_id == 1 ? 'Gamme 25W' : ($prod->category_id == 2 ? 'Gamme 35W' : 'Gamme 55W') }}</span>
                                    <span class="product-ref">Réf: {{ $prod->code }}</span>
                                </div>
                                <h3 class="product-name">{{ $prod->name }}</h3>
                                <p class="product-desc">{{ $prod->description }}</p>
                                
                                <div class="product-features-pills">
                                    @foreach($pills as $pill)
                                        <span class="feature-pill"><i class="fa-solid {{ $pill['icon'] }}"></i> {{ $pill['text'] }}</span>
                                    @endforeach
                                </div>

                                <div class="price-section">
                                    <div class="price-row">
                                        <div>
                                            <span class="orig-price-label">Prix Public</span>
                                            <div>
                                                <span class="orig-price">{{ number_format($origPrice, 2, ',', ' ') }} DH</span>
                                            </div>
                                            <div class="savings-tag">
                                                <i class="fa-solid fa-circle-check"></i> Économie : {{ number_format($savings, 2, ',', ' ') }} DH
                                            </div>
                                        </div>
                                        <div class="vip-price-wrap">
                                            <span class="vip-price-label">Tarif Privilège</span>
                                            <div class="vip-price">
                                                {{ number_format($discPrice, 2, ',', ' ') }} <small>DH</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="free-lens-mention">
                                        <i class="fa-solid fa-gift"></i> Lentille en verre gravée sur mesure offerte & livraison incluse
                                    </div>
                                </div>

                                <button type="button" class="btn-add" onclick="addToCart({{ $prod->id }}, '{{ addslashes($prod->name) }}', {{ $discPrice }}, {{ $origPrice }}, '{{ $prod->code }}')">
                                    <i class="fa-solid fa-cart-plus"></i> Ajouter au panier (-{{ (int)$discountRate }}%)
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: var(--text-secondary);">
                            <i class="fa-solid fa-boxes-stacked" style="font-size: 3.5rem; margin-bottom: 1rem; color: var(--gold); opacity: 0.4;"></i>
                            <p style="font-size: 1.1rem;">Aucun produit n'est disponible actuellement.</p>
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
                        <span id="cart-count-badge" style="font-size: 0.82rem; background: rgba(234, 179, 8, 0.18); border: 1px solid var(--border-gold-bright); color: var(--gold-light); padding: 4px 12px; border-radius: 50px; font-weight: 800;">
                            0 article
                        </span>
                    </div>

                    <form action="{{ route('catalog.special.order', $link->token) }}" method="POST" enctype="multipart/form-data" id="order-form">
                        @csrf
                        
                        <!-- Selected Cart Items Container -->
                        <div class="cart-items" id="cart-items-list">
                            <div id="cart-empty-msg" style="text-align: center; padding: 2.4rem 1rem; color: var(--text-secondary); font-size: 0.9rem;">
                                <i class="fa-solid fa-cart-arrow-down" style="font-size: 2.4rem; margin-bottom: 12px; display: block; color: var(--gold); opacity: 0.6;"></i>
                                Cliquez sur <strong>"Ajouter au panier"</strong> sur les projecteurs de votre choix pour profiter de vos avantages VIP.
                            </div>
                        </div>

                        <!-- Savings Live Counter Widget -->
                        <div class="savings-meter-card" id="savings-meter-widget" style="display: none;">
                            <div class="savings-meter-left">
                                <div class="savings-meter-icon"><i class="fa-solid fa-piggy-bank"></i></div>
                                <div>
                                    <div class="savings-meter-title">Total Économisé</div>
                                    <div class="savings-meter-amount" id="meter-total-savings">0,00 DH</div>
                                </div>
                            </div>
                            <span style="font-size: 0.72rem; background: rgba(16, 185, 129, 0.2); color: var(--success-light); font-weight: 800; padding: 3px 8px; border-radius: 4px;">
                                Remise VIP active
                            </span>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="summary-box">
                            <div class="summary-row">
                                <span>Sous-total public :</span>
                                <span id="summary-orig-total">0,00 DH</span>
                            </div>
                            <div class="summary-row" style="color: var(--success-light); font-weight: 700;">
                                <span><i class="fa-solid fa-gift"></i> Remise Spéciale (-{{ (int)$discountRate }}%) :</span>
                                <span id="summary-discount">-0,00 DH</span>
                            </div>
                            <div class="summary-row gift-row">
                                <span><i class="fa-solid fa-check"></i> Gravure Laser HD Sur-Mesure :</span>
                                <span style="color: var(--success-light); font-weight: 700;">OFFERTE (350 DH)</span>
                            </div>
                            <div class="summary-row gift-row">
                                <span><i class="fa-solid fa-check"></i> Livraison Sécurisée Maroc :</span>
                                <span style="color: var(--success-light); font-weight: 700;">GRATUITE (100 DH)</span>
                            </div>
                            <div class="summary-row summary-total">
                                <span>Total Net à Régler :</span>
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
                                <i class="fa-solid fa-pen-to-square" style="color: var(--gold);"></i> Instructions pour votre commande (Optionnel)
                            </label>
                            <textarea name="global_notes" id="global_notes" rows="2" class="form-input-custom" placeholder="Ex: Souhait d'orientation de la lentille, horaire de livraison préféré..."></textarea>
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
                                <i class="fa-solid fa-location-dot" style="color: var(--gold);"></i> Adresse de livraison au Maroc
                            </label>
                            <input type="text" name="delivery_address" id="delivery_address" class="form-input-custom" value="{{ $customer->address }}" placeholder="Ville, quartier, adresse..." required>
                        </div>

                        <button type="submit" class="btn-checkout" id="btn-submit" disabled>
                            <i class="fa-solid fa-circle-check"></i> Valider ma commande (-{{ (int)$discountRate }}%)
                        </button>

                        <!-- Reassurance Checklist below Checkout Button -->
                        <div class="reassurance-checks">
                            <div class="reassurance-check-item">
                                <i class="fa-solid fa-circle-check"></i> Aucun paiement immédiat — Règlement à la livraison
                            </div>
                            <div class="reassurance-check-item">
                                <i class="fa-solid fa-circle-check"></i> Contrôle et validation du Bon À Tirer (BAT) avant gravure
                            </div>
                            <div class="reassurance-check-item">
                                <i class="fa-solid fa-circle-check"></i> Test technique et vérification de conformité avant expédition
                            </div>
                        </div>

                        <!-- Trust Badges Strip -->
                        <div class="trust-strip">
                            <div class="trust-item">
                                <i class="fa-solid fa-truck-fast"></i> Livraison gratuite
                            </div>
                            <div class="trust-item">
                                <i class="fa-solid fa-shield-halved"></i> Garantie 2 ans
                            </div>
                            <div class="trust-item">
                                <i class="fa-solid fa-gem"></i> Lentille HD offerte
                            </div>
                            <div class="trust-item">
                                <i class="fa-solid fa-headset"></i> Support technique dédié
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
            <i class="fa-solid fa-bag-shopping"></i> Finaliser (<span id="mobile-cart-count">0</span>)
        </button>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notify" id="toast-notify">
        <i class="fa-solid fa-circle-check" style="color: var(--success-light); font-size: 1.3rem;"></i>
        <span id="toast-msg">Projecteur ajouté à votre sélection</span>
    </div>

    <!-- Lightbox Modal for Realisations -->
    <div class="lightbox-modal" id="lightbox-modal" onclick="closeLightbox(event)">
        <div class="lightbox-content" onclick="event.stopPropagation()">
            <button type="button" class="lightbox-close" onclick="closeLightboxDirect()"><i class="fa-solid fa-times"></i></button>
            <div class="lightbox-img-wrap">
                <img id="lightbox-img" src="" alt="">
            </div>
            <div class="lightbox-info">
                <div class="lightbox-tag" id="lightbox-tag">Projet Client Réel</div>
                <h4 class="lightbox-title" id="lightbox-title">Client</h4>
                <p class="lightbox-desc" id="lightbox-desc">Détails de la projection.</p>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 12px;">
                    <span style="font-size: 0.82rem; color: var(--gold-light); font-weight: 700;">
                        <i class="fa-solid fa-certificate"></i> Lentille gravée haute définition offerte
                    </span>
                    <button type="button" class="btn-add" style="width: auto; padding: 8px 18px; font-size: 0.85rem;" onclick="closeLightboxDirect(); scrollToCatalog();">
                        <i class="fa-solid fa-cart-plus"></i> Choisir mon modèle (-{{ (int)$discountRate }}%)
                    </button>
                </div>
            </div>
        </div>
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

        // Lightbox Functions
        function openLightbox(src, title, desc, tag) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-title').textContent = title || 'Réalisation Projecteur LOGO';
            document.getElementById('lightbox-desc').textContent = desc || 'Installation réelle réalisée au Maroc avec nos projecteurs haute luminosité.';
            document.getElementById('lightbox-tag').textContent = tag || 'Projet Client Réel';
            document.getElementById('lightbox-modal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeLightbox(event) {
            if (event.target === document.getElementById('lightbox-modal')) {
                closeLightboxDirect();
            }
        }
        function closeLightboxDirect() {
            document.getElementById('lightbox-modal').classList.remove('active');
            document.body.style.overflow = '';
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
            const savingsWidget = document.getElementById('savings-meter-widget');
            const meterSavings = document.getElementById('meter-total-savings');

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
                if (savingsWidget) savingsWidget.style.display = 'none';
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

            if (totalQty > 0) {
                if (savingsWidget) {
                    savingsWidget.style.display = 'flex';
                    // Total savings includes direct discount + (450 DH gifts)
                    const totalCustomerAdvantage = savings + (totalQty * 350) + 100;
                    meterSavings.textContent = savings.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
                }
            } else {
                if (savingsWidget) savingsWidget.style.display = 'none';
            }

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
                        <i class="fa-solid fa-cloud-arrow-up" style="color: var(--success-light);"></i> ${!isFirst ? 'Nouveau logo distinct' : 'Télécharger un nouveau logo'}
                    </label>
                `;

                html += `</div>`;

                // Preview for past logo if selected
                if (hasPastLogo && selectedSource === 'past_logo') {
                    html += `
                        <div class="past-logo-preview">
                            <img src="${pastLogoUrl}" alt="Ancien logo">
                            <span>Logo enregistré utilisé pour la fabrication de votre 1er projecteur.</span>
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