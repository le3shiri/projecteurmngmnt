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

// Auth Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Guest fallback
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated Routes
Route::middleware(['role'])->group(function () {
    
    // Common Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view_dashboard');

    // Customers
    Route::middleware(['permission:view_customers'])->group(function () {
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });
    Route::middleware(['permission:manage_customers'])->group(function () {
        Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
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
    Route::middleware(['permission:view_orders'])->group(function () {
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/pdf/{type}', [OrderController::class, 'downloadPdf'])->name('orders.pdf');
    });
    Route::middleware(['permission:manage_orders'])->group(function () {
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    });
    Route::middleware(['permission:update_order_status'])->group(function () {
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders/{order}/payment', [OrderController::class, 'addPayment'])->name('orders.addPayment');
    });

    // Trainings
    Route::middleware(['permission:view_trainings'])->group(function () {
        Route::get('trainings', [TrainingController::class, 'index'])->name('trainings.index');
    });
    Route::middleware(['permission:manage_trainings'])->group(function () {
        Route::post('trainings', [TrainingController::class, 'store'])->name('trainings.store');
        Route::delete('trainings/{training}', [TrainingController::class, 'destroy'])->name('trainings.destroy');
    });

    // Prospects
    Route::middleware(['permission:view_prospects'])->group(function () {
        Route::get('prospects', [ProspectController::class, 'index'])->name('prospects.index');
        Route::get('prospects/{file}', [ProspectController::class, 'show'])->name('prospects.show');
        Route::get('prospects/{file}/dialer', [ProspectController::class, 'dialer'])->name('prospects.dialer');
        Route::post('prospects/{prospect}/update', [ProspectController::class, 'updateProspect'])->name('prospects.update');
    });
    Route::middleware(['permission:manage_prospects'])->group(function () {
        Route::post('prospects/upload', [ProspectController::class, 'storeFile'])->name('prospects.upload');
        Route::delete('prospects/{file}/delete', [ProspectController::class, 'destroyFile'])->name('prospects.destroyFile');
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
});
