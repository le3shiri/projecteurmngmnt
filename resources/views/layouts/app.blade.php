<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM') - CRM ProjetEUR</title>
    
    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>
<body>
    @auth
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                <span>ProjetEUR CRM</span>
            </a>
            
            <ul class="sidebar-menu">
                @if(auth()->user()->hasPermission('view_dashboard'))
                <li>
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ Route::is('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                @endif

                <!-- Admin specific user management & permissions -->
                @if(auth()->user()->hasPermission('manage_users'))
                <li>
                    <a href="{{ route('users.index') }}" class="sidebar-link {{ Route::is('users.*') && !Route::is('permissions.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <span>Équipe / Agents</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('permissions.index') }}" class="sidebar-link {{ Route::is('permissions.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Permissions & Rôles</span>
                    </a>
                </li>
                @endif

                <!-- Customers -->
                @if(auth()->user()->hasPermission('view_customers'))
                <li>
                    <a href="{{ route('customers.index') }}" class="sidebar-link {{ Route::is('customers.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Clients</span>
                    </a>
                </li>
                @endif

                <!-- Catalog Products -->
                @if(auth()->user()->hasPermission('view_products'))
                <li>
                    <a href="{{ route('products.index') }}" class="sidebar-link {{ Route::is('products.*') && !Route::is('categories.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box-open"></i>
                        <span>Catalogue & Stock</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermission('manage_categories'))
                <li>
                    <a href="{{ route('categories.index') }}" class="sidebar-link {{ Route::is('categories.*') ? 'active' : '' }}" style="padding-left: 2.25rem; font-size: 0.85rem;">
                        <i class="fa-solid fa-folder-tree" style="font-size: 0.8rem; opacity: 0.8;"></i>
                        <span>Catégories Produits</span>
                    </a>
                </li>
                @endif

                <!-- Orders -->
                @if(auth()->user()->hasPermission('view_orders'))
                <li>
                    <a href="{{ route('orders.index') }}" class="sidebar-link {{ Route::is('orders.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Ventes & Commandes</span>
                    </a>
                </li>
                @endif

                {{-- Supplier Dispatching Dashboard (Disabled)
                @if(auth()->user()->hasPermission('view_logistics'))
                <li>
                    <a href="{{ route('supplier.index') }}" class="sidebar-link {{ Route::is('supplier.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                        <span>Commandes Fournisseur</span>
                    </a>
                </li>
                @endif
                --}}

                <!-- Prospects / Dialer lists -->
                @if(auth()->user()->hasPermission('view_prospects'))
                <li>
                    <a href="{{ route('prospects.index') }}" class="sidebar-link {{ Route::is('prospects.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-phone-volume"></i>
                        <span>Appels Prospects</span>
                    </a>
                </li>
                @endif

                <!-- Expenses -->
                @if(auth()->user()->hasPermission('view_expenses'))
                <li>
                    <a href="{{ route('expenses.index') }}" class="sidebar-link {{ Route::is('expenses.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-wallet"></i>
                        <span>Dépenses</span>
                    </a>
                </li>
                @endif

                <!-- Trainings resources -->
                @if(auth()->user()->hasPermission('view_trainings'))
                <li>
                    <a href="{{ route('trainings.index') }}" class="sidebar-link {{ Route::is('trainings.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Espace Formation</span>
                    </a>
                </li>
                @endif

                <!-- Company Important Documents -->
                @if(auth()->user()->hasPermission('view_documents'))
                <li>
                    <a href="{{ route('company_documents.index') }}" class="sidebar-link {{ Route::is('company_documents.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-folder-closed"></i>
                        <span>Documents Importants</span>
                    </a>
                </li>
                @endif
            </ul>

            <!-- Sidebar footer -->
            <div class="sidebar-footer">
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">
                        {{ auth()->user()->role }}
                        @if(auth()->user()->isAgent())
                            ({{ auth()->user()->commission_rate }}% Comm)
                        @endif
                    </span>
                    <span class="user-role" style="font-size: 0.7rem; color: var(--text-secondary);">
                        Code: {{ auth()->user()->access_code }}
                    </span>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm" style="width: 100%;">
                        <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Panel -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @else
        @yield('content')
    @endauth

    @yield('scripts')
</body>
</html>
