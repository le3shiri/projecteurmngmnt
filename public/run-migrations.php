<?php

use Illuminate\Support\Facades\Artisan;

define('LARAVEL_START', microtime(true));

// Load Composer autoloader
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    die("Vendor autoload not found.");
}

// Bootstrap Laravel Application
if (file_exists(__DIR__ . '/../bootstrap/app.php')) {
    $app = require_once __DIR__ . '/../bootstrap/app.php';
} elseif (file_exists(__DIR__ . '/bootstrap/app.php')) {
    $app = require_once __DIR__ . '/bootstrap/app.php';
} else {
    die("Bootstrap app file not found.");
}

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Exécution des Migrations - ProjetEUR</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; color: #f8fafc; padding: 2rem; }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 2rem; max-width: 800px; margin: 0 auto; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); }
        h1 { color: #f59e0b; margin-top: 0; font-size: 1.5rem; }
        pre { background: #090d16; border: 1px solid #1e293b; border-radius: 8px; padding: 1.25rem; color: #10b981; font-family: monospace; overflow-x: auto; white-space: pre-wrap; font-size: 0.9rem; }
        .badge { background: #10b98120; color: #10b981; border: 1px solid #10b98140; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class='card'>
        <h1><i class='fa-solid fa-database'></i> Assistant de Migration BDD Laravel</h1>
        <p>Exécution automatique des migrations sur la base de données de production...</p>
        <pre>";

try {
    echo "=== 1. EXECUTION DE PHP ARTISAN MIGRATE ===\n";
    Artisan::call('migrate', ['--force' => true]);
    echo Artisan::output();

    echo "\n=== 2. NETTOYAGE DU CACHE ET CONFIGURATION ===\n";
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    echo Artisan::output();

    echo "\n===========================================\n";
    echo "✓ SUCCÈS : Toutes les migrations ont été appliquées avec succès !\n";
} catch (\Throwable $e) {
    echo "\n-------------------------------------------\n";
    echo "❌ ERREUR LORS DE L'EXÉCUTION :\n";
    echo $e->getMessage() . "\n\n";
    echo "Fichier: " . $e->getFile() . " (Ligne " . $e->getLine() . ")\n";
}

echo "</pre>
        <p style='margin-top: 1.5rem; color: #94a3b8; font-size: 0.85rem;'>
            <em>Note de sécurité :</em> Une fois l'opération terminée, vous pouvez supprimer ce fichier du serveur.
        </p>
    </div>
</body>
</html>";
