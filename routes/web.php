<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyDocumentController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\RealisationController;

// Auth Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Guest fallback
Route::get('/', function () {
    return redirect()->route('login');
});

// Temporary Route to Fix Hostinger Storage Symlink (by converting it to a real directory)
Route::get('/fix-storage', function () {
    try {
        // Manually delete configuration and route cache files to force refresh
        $cacheFiles = [
            base_path('bootstrap/cache/config.php'),
            base_path('bootstrap/cache/routes-v7.php'),
            base_path('bootstrap/cache/services.php'),
            base_path('bootstrap/cache/packages.php'),
            base_path('bootstrap/cache/events.php'),
        ];
        
        $cleared = [];
        foreach ($cacheFiles as $file) {
            if (file_exists($file)) {
                @unlink($file);
                $cleared[] = basename($file);
            }
        }

        $storageLink = base_path('public-storage');
        $targetFolder = storage_path('app/public');

        if (file_exists($storageLink) || is_link($storageLink)) {
            if (is_link($storageLink)) {
                unlink($storageLink);
            } else {
                @unlink($storageLink);
                if (file_exists($storageLink) && is_dir($storageLink)) {
                    @rename($storageLink, $storageLink . '_backup_' . time());
                }
            }
        }

        if (!file_exists($storageLink)) {
            mkdir($storageLink, 0755, true);
        }

        $copyDir = function ($src, $dst) use (&$copyDir) {
            if (!is_dir($src))
                return;
            @mkdir($dst, 0755, true);
            $dir = opendir($src);
            while (($file = readdir($dir)) !== false) {
                if ($file != '.' && $file != '..') {
                    if (is_dir($src . '/' . $file)) {
                        $copyDir($src . '/' . $file, $dst . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
            closedir($dir);
        };

        if (is_dir($targetFolder)) {
            $copyDir($targetFolder, $storageLink);
        }

        // If public_html/storage is a broken symlink, delete it so Apache doesn't block requests
        $brokenPublicStorage = base_path('storage');
        if (is_link($brokenPublicStorage)) {
            @unlink($brokenPublicStorage);
        }

        $diagnostics = [
            'DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
            'base_path' => base_path(),
            'public-storage_path' => base_path('public-storage'),
            'storage_path_app_public' => storage_path('app/public'),
            'public-storage_exists' => file_exists(base_path('public-storage')) ? 'Yes' : 'No',
            'public-storage_is_dir' => is_dir(base_path('public-storage')) ? 'Yes' : 'No',
            'config_disks_public_root' => config('filesystems.disks.public.root'),
            'resolved_public_disk_path' => \Illuminate\Support\Facades\Storage::disk('public')->path(''),
        ];

        return response()->json([
            'message' => 'Le stockage a été converti en dossier public-storage et tous les fichiers existants ont été copiés avec succès !',
            'diagnostics' => $diagnostics
        ], 200, [], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        return 'Erreur : ' . $e->getMessage();
    }
});

// Authenticated Routes
Route::middleware(['role'])->group(function () {

    // Common Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view_dashboard');

    // Customers
    Route::middleware(['permission:manage_customers'])->group(function () {
        Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });
    Route::middleware(['permission:view_customers'])->group(function () {
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });

    // Products
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:manage_products');
    Route::middleware(['permission:view_products'])->group(function () {
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    });
    Route::middleware(['permission:manage_products'])->group(function () {
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    });
    Route::middleware(['permission:delete_products'])->group(function () {
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Categories
    Route::middleware(['permission:manage_categories'])->group(function () {
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // Orders
    Route::middleware(['permission:manage_orders'])->group(function () {
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    });
    Route::middleware(['permission:view_orders,view_logistics'])->group(function () {
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/pdf/{type}', [OrderController::class, 'downloadPdf'])->name('orders.pdf');
        Route::get('orders/{order}/document/{type}/edit', [OrderController::class, 'editDocument'])->name('orders.document.edit');
        Route::post('orders/{order}/document/{type}/generate', [OrderController::class, 'generateCustomDocumentPdf'])->name('orders.document.generate');
    });
    Route::middleware(['permission:update_order_status'])->group(function () {
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders/{order}/payment', [OrderController::class, 'addPayment'])->name('orders.addPayment');
        Route::post('orders/{order}/shipping-ticket', [OrderController::class, 'uploadShippingTicket'])->name('orders.shippingTicket');
        Route::delete('orders/{order}/shipping-ticket', [OrderController::class, 'deleteShippingTicket'])->name('orders.deleteShippingTicket');
    });
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Trainings
    Route::middleware(['permission:view_trainings'])->group(function () {
        Route::get('trainings', [TrainingController::class, 'index'])->name('trainings.index');
    });
    Route::middleware(['permission:manage_trainings'])->group(function () {
        Route::post('trainings', [TrainingController::class, 'store'])->name('trainings.store');
        Route::delete('trainings/{training}', [TrainingController::class, 'destroy'])->name('trainings.destroy');
    });

    // Prospects
    Route::middleware(['permission:manage_prospects'])->group(function () {
        Route::get('prospects/upload', function () {
            return redirect()->route('prospects.index');
        });
        Route::post('prospects/upload', [ProspectController::class, 'storeFile'])->name('prospects.upload');
        Route::delete('prospects/{file}/delete', [ProspectController::class, 'destroyFile'])->name('prospects.destroyFile');
    });
    Route::middleware(['permission:view_prospects'])->group(function () {
        Route::get('prospects', [ProspectController::class, 'index'])->name('prospects.index');
        Route::get('prospects/{file}', [ProspectController::class, 'show'])->name('prospects.show');
        Route::get('prospects/{file}/dialer', [ProspectController::class, 'dialer'])->name('prospects.dialer');
        Route::post('prospects/{prospect}/update', [ProspectController::class, 'updateProspect'])->name('prospects.update');
        Route::post('prospects/{prospect}', [ProspectController::class, 'updateProspect']);
    });

    // Team / Collaborators
    Route::middleware(['permission:manage_users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');

        // Permissions settings UI
        Route::get('permissions', [UserController::class, 'permissionsIndex'])->name('permissions.index');
        Route::post('permissions', [UserController::class, 'permissionsUpdate'])->name('permissions.update');
    });

    // Expenses
    Route::middleware(['permission:view_expenses'])->group(function () {
        Route::get('expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    });
    Route::middleware(['permission:manage_expenses'])->group(function () {
        Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    });

    // Logistics / Supplier Orders
    Route::middleware(['permission:view_logistics'])->group(function () {
        Route::get('supplier/orders', [SupplierController::class, 'index'])->name('supplier.index');
        Route::post('supplier/orders/{supplierOrder}/status', [SupplierController::class, 'updateStatus'])->name('supplier.status');
    });

    // Company Important Documents
    Route::middleware(['permission:view_documents'])->group(function () {
        Route::get('company-documents', [CompanyDocumentController::class, 'index'])->name('company_documents.index');
    });
    Route::middleware(['permission:manage_documents'])->group(function () {
        Route::post('company-documents', [CompanyDocumentController::class, 'store'])->name('company_documents.store');
        Route::put('company-documents/{companyDocument}', [CompanyDocumentController::class, 'update'])->name('company_documents.update');
        Route::delete('company-documents/{companyDocument}', [CompanyDocumentController::class, 'destroy'])->name('company_documents.destroy');
    });

    // Commissions & Rémunérations
    Route::middleware(['permission:view_commissions,view_dashboard'])->group(function () {
        Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
        Route::get('commissions/agent/{user}', [CommissionController::class, 'showAgentCommissions'])->name('commissions.show');
    });
    Route::middleware(['permission:manage_users'])->group(function () {
        Route::post('commissions/{commission}/pay', [CommissionController::class, 'markAsPaid'])->name('commissions.pay');
        Route::post('commissions/{commission}/pending', [CommissionController::class, 'markAsPending'])->name('commissions.unpay');
        Route::post('commissions/agent/{user}/pay-all', [CommissionController::class, 'payAllAgentPending'])->name('commissions.pay_all');
    });

    // Nos Réalisations — Media Gallery
    Route::middleware(['permission:view_realisations'])->group(function () {
        Route::get('realisations', [RealisationController::class, 'index'])->name('realisations.index');
        Route::get('realisations/{realisation}/download', [RealisationController::class, 'download'])->name('realisations.download');
    });
    // Add: admin + agent with add_realisations
    Route::middleware(['permission:view_realisations'])->group(function () {
        Route::post('realisations', [RealisationController::class, 'store'])->name('realisations.store');
    });
    // Edit + Delete: admin / manage_realisations only
    Route::middleware(['permission:manage_realisations'])->group(function () {
        Route::put('realisations/{realisation}', [RealisationController::class, 'update'])->name('realisations.update');
        Route::delete('realisations/{realisation}', [RealisationController::class, 'destroy'])->name('realisations.destroy');
    });
});

// Standalone Web Migration Runner Route
Route::get('/migrate-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        return "<h2 style='color:#10b981; font-family: sans-serif;'>✓ Migrations effectuées avec succès !</h2><pre style='background:#0f172a; color:#fff; padding:15px; border-radius:8px;'>{$output}</pre>";
    } catch (\Throwable $e) {
        return "<h2 style='color:#ef4444; font-family: sans-serif;'>❌ Erreur de migration :</h2><pre style='background:#0f172a; color:#ef4444; padding:15px; border-radius:8px;'>{$e->getMessage()}</pre>";
    }
});
