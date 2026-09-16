<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚨 Robla F Système - 500 Erreur</title>
    
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
            --danger: #ef4444;
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

        /* Ambient Glow Background */
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.2) 0%, rgba(212, 175, 55, 0.1) 50%, transparent 70%);
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

        /* Funny Animated Avatar / Icon */
        .funny-icon-wrapper {
            position: relative;
            width: 130px;
            height: 130px;
            margin: 0 auto 1.5rem auto;
            background: rgba(239, 68, 68, 0.12);
            border: 2px dashed rgba(239, 68, 68, 0.5);
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
            color: var(--danger);
            animation: headShake 2.5s infinite ease-in-out;
        }

        @keyframes headShake {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(-10deg); }
            40% { transform: rotate(10deg); }
            60% { transform: rotate(-5deg); }
            80% { transform: rotate(5deg); }
        }

        .floating-badge {
            position: absolute;
            bottom: -5px;
            right: -5px;
            background: #ef4444;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.5);
            animation: bounce 1.5s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        .error-code {
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: var(--danger);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: inline-block;
            background: rgba(239, 68, 68, 0.1);
            padding: 4px 14px;
            border-radius: 30px;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .error-title {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 1.25rem;
            line-height: 1.2;
        }

        /* The Main Highlighted Moroccan Darija Message */
        .aymane-box {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(239, 68, 68, 0.15) 100%);
            border: 2px solid var(--primary);
            border-radius: 16px;
            padding: 1.5rem 1.25rem;
            margin: 1.5rem 0;
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.2);
            position: relative;
            overflow: hidden;
        }

        .aymane-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { left: -100%; }
            50%, 100% { left: 100%; }
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

        .btn-secondary-action {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-secondary-action:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            color: #fff;
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
        
        <!-- Funny Icon with Fire/Screaming Robot -->
        <div class="funny-icon-wrapper">
            <i class="fa-solid fa-fire-burner funny-icon"></i>
            <span class="floating-badge">🚨 OUPS!</span>
        </div>

        <div class="error-code">
            <i class="fa-solid fa-triangle-exclamation"></i> ERREUR SYSTÈME / BASE DE DONNÉES
        </div>

        <h1 class="error-title">
            Waq3at Chi Robla F Le Système ! 💥
        </h1>

        <!-- The Hilarious Requested Box -->
        <div class="aymane-box">
            <div class="aymane-quote">
                <span>🔥</span>
                <span>SIR HDR MEA AYMANE Y7ELIK HAD LMOUCHKIL</span>
                <span>🔥</span>
            </div>
            <div class="aymane-subtext">
                Chi requête SQL mabghatch doz ola chi bug tkhle9 f le code...<br>
                <strong>Aymane</strong> houwa l'ingénieur li 3endo le mot de passe siri bach y3teq l'mouqif ☕👨‍💻🚀
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="actions-row">
            <a href="{{ url('/') }}" class="btn-action btn-primary-action">
                <i class="fa-solid fa-house"></i> Rje3 L Tableau de Bord
            </a>
            <button onclick="window.location.reload();" class="btn-action btn-secondary-action">
                <i class="fa-solid fa-rotate-right"></i> 3awed Jarreb (Refresh)
            </button>
        </div>

        <div class="error-footer">
            <i class="fa-solid fa-shield-halved"></i> CRM ProjectEUR Logo &bull; Support Technique: Aymane
        </div>

    </div>

</body>
</html>
