<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🕵️ Page Introuvable - 404</title>
    
    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #d4af37;
            --primary-glow: rgba(212, 175, 55, 0.4);
            --bg-dark: #0a0f1d;
            --card-bg: rgba(15, 23, 42, 0.85);
            --border-color: rgba(212, 175, 55, 0.2);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --warning: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: radial-gradient(circle at center, #1e1b4b 0%, #0a0f1d 70%, #030712 100%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.2) 0%, rgba(212, 175, 55, 0.1) 50%, transparent 70%);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: pulseGlow 6s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            0% { transform: scale(0.8) translate(-10%, -10%); }
            100% { transform: scale(1.2) translate(10%, 10%); }
        }

        .error-card {
            position: relative;
            z-index: 10;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            max-width: 680px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7), 0 0 40px rgba(212, 175, 55, 0.15);
            animation: popIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes popIn {
            0% { opacity: 0; transform: scale(0.9) translateY(20px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        .funny-icon-wrapper {
            position: relative;
            width: 130px;
            height: 130px;
            margin: 0 auto 1.5rem auto;
            background: rgba(245, 158, 11, 0.12);
            border: 2px dashed rgba(245, 158, 11, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: floatSlow 3s ease-in-out infinite alternate;
        }

        @keyframes floatSlow {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(-3deg); }
            100% { transform: translateY(0px) rotate(3deg); }
        }

        .funny-icon {
            font-size: 4rem;
            color: var(--warning);
        }

        .floating-badge {
            position: absolute;
            bottom: -5px;
            right: -5px;
            background: var(--warning);
            color: #000;
            font-size: 0.85rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.5);
        }

        .error-code {
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: var(--warning);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: inline-block;
            background: rgba(245, 158, 11, 0.1);
            padding: 4px 14px;
            border-radius: 30px;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .error-title {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 1.25rem;
            line-height: 1.2;
        }

        .aymane-box {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(245, 158, 11, 0.15) 100%);
            border: 2px solid var(--primary);
            border-radius: 16px;
            padding: 1.5rem 1.25rem;
            margin: 1.5rem 0;
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.2);
            position: relative;
            overflow: hidden;
        }

        .aymane-quote {
            font-size: 1.45rem;
            font-weight: 900;
            color: #fbbf24;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            line-height: 1.4;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .aymane-subtext {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 10px;
            line-height: 1.5;
        }

        .actions-row {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary-action {
            background: linear-gradient(135deg, var(--primary) 0%, #b89628 100%);
            color: #000;
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .btn-primary-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.6);
            color: #000;
        }

        .error-footer {
            margin-top: 2rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
    </style>
</head>
<body>

    <div class="ambient-glow"></div>

    <div class="error-card">
        
        <div class="funny-icon-wrapper">
            <i class="fa-solid fa-compass-drafting funny-icon"></i>
            <span class="floating-badge">404</span>
        </div>

        <div class="error-code">
            <i class="fa-solid fa-magnifying-glass"></i> PAGE INTROUVABLE
        </div>

        <h1 class="error-title">
            Malguiynash Had La Page ! 🧭
        </h1>

        <div class="aymane-box">
            <div class="aymane-quote">
                <span>🔥</span>
                <span>SIR HDR MEA AYMANE Y7ELIK HAD LMOUCHKIL</span>
                <span>🔥</span>
            </div>
            <div class="aymane-subtext">
                Had le lien ghaleT ola tefsa5 men le serveur...<br>
                <strong>Aymane</strong> ghadi yqad lik les routes o yreje3 lik l'accès ☕👨‍💻🚀
            </div>
        </div>

        <div class="actions-row">
            <a href="{{ url('/') }}" class="btn-action btn-primary-action">
                <i class="fa-solid fa-house"></i> Rje3 L Tableau de Bord
            </a>
        </div>

        <div class="error-footer">
            <i class="fa-solid fa-shield-halved"></i> CRM ProjectEUR Logo &bull; Support Technique: Aymane
        </div>

    </div>

</body>
</html>
