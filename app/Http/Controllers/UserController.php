<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,supplier,agent,media_buyer',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'phone' => 'nullable|string',
            'access_code' => 'nullable|string|max:20|unique:users,access_code',
            'cin' => 'required_if:role,agent|nullable|string|max:30',
            'cin_recto' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'cin_verso' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'cin_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'engagement_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $accessCode = $request->access_code ?: strtoupper(Str::random(8));

        $cinRectoPath = null;
        if ($request->hasFile('cin_recto')) {
            $cinRectoPath = $request->file('cin_recto')->store('agent_docs', 'public');
        } elseif ($request->hasFile('cin_card')) {
            $cinRectoPath = $request->file('cin_card')->store('agent_docs', 'public');
        }

        $cinVersoPath = null;
        if ($request->hasFile('cin_verso')) {
            $cinVersoPath = $request->file('cin_verso')->store('agent_docs', 'public');
        }

        $engagementLetterPath = null;
        if ($request->hasFile('engagement_letter')) {
            $engagementLetterPath = $request->file('engagement_letter')->store('agent_docs', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'commission_rate' => $request->commission_rate ?? 0,
            'phone' => $request->phone,
            'password' => bcrypt(Str::random(16)),
            'access_code' => $accessCode,
            'is_active' => true,
            'cin' => $request->cin,
            'cin_card_path' => $cinRectoPath,
            'cin_recto_path' => $cinRectoPath,
            'cin_verso_path' => $cinVersoPath,
            'engagement_letter_path' => $engagementLetterPath,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès avec le code d\'accès : ' . $accessCode);
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,supplier,agent,media_buyer',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'phone' => 'nullable|string',
            'access_code' => 'required|string|max:20|unique:users,access_code,' . $user->id,
            'cin' => 'required_if:role,agent|nullable|string|max:30',
            'cin_recto' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'cin_verso' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'cin_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'engagement_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'commission_rate' => $request->commission_rate ?? 0,
            'phone' => $request->phone,
            'access_code' => $request->access_code,
            'cin' => $request->cin,
        ];

        if ($request->hasFile('cin_recto')) {
            if ($user->cin_recto_path) {
                Storage::disk('public')->delete($user->cin_recto_path);
            }
            $data['cin_recto_path'] = $request->file('cin_recto')->store('agent_docs', 'public');
            $data['cin_card_path'] = $data['cin_recto_path'];
        } elseif ($request->hasFile('cin_card')) {
            if ($user->cin_recto_path) {
                Storage::disk('public')->delete($user->cin_recto_path);
            }
            $data['cin_recto_path'] = $request->file('cin_card')->store('agent_docs', 'public');
            $data['cin_card_path'] = $data['cin_recto_path'];
        }

        if ($request->hasFile('cin_verso')) {
            if ($user->cin_verso_path) {
                Storage::disk('public')->delete($user->cin_verso_path);
            }
            $data['cin_verso_path'] = $request->file('cin_verso')->store('agent_docs', 'public');
        }

        if ($request->hasFile('engagement_letter')) {
            if ($user->engagement_letter_path) {
                Storage::disk('public')->delete($user->engagement_letter_path);
            }
            $data['engagement_letter_path'] = $request->file('engagement_letter')->store('agent_docs', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activé' : 'désactivé';
        return redirect()->route('users.index')->with('success', "Le compte de {$user->name} a été {$status}.");
    }

    public function permissionsIndex()
    {
        $modules = [
            'Tableau de Bord' => [
                'view_dashboard' => 'Accéder au tableau de bord'
            ],
            'Gestion Équipe / Agents' => [
                'manage_users' => 'Gérer les collaborateurs (Créer/Modifier/Activer)'
            ],
            'Base Clients' => [
                'view_customers' => 'Consulter la liste des clients',
                'manage_customers' => 'Créer/Modifier les clients',
                'delete_customers' => 'Supprimer les clients'
            ],
            'Catalogue Produits' => [
                'view_products' => 'Consulter le catalogue & stocks',
                'manage_products' => 'Créer/Modifier les fiches produits',
                'delete_products' => 'Supprimer des produits',
                'manage_categories' => 'Gérer les catégories de produits'
            ],
            'Commandes & Ventes' => [
                'view_orders' => 'Consulter la liste des commandes',
                'manage_orders' => 'Créer une nouvelle commande (vente)',
                'update_order_status' => 'Modifier le statut des commandes & encaisser les paiements',
                'delete_orders' => 'Supprimer des commandes (Réservé à l\'administrateur)'
            ],
            'Prospection Téléphonique' => [
                'view_prospects' => 'Accéder et appeler les prospects assignés',
                'manage_prospects' => 'Importer (CSV) et supprimer des campagnes de prospection'
            ],
            'Dépenses d\'Exploitation' => [
                'view_expenses' => 'Consulter la liste des dépenses',
                'manage_expenses' => 'Enregistrer et supprimer des dépenses'
            ],
            'Sessions de Formation' => [
                'view_trainings' => 'Consulter le planning des formations',
                'manage_trainings' => 'Créer et supprimer des sessions de formation'
            ],
            'Documents Importants (Société)' => [
                'view_documents' => 'Consulter la bibliothèque de documents officiels',
                'manage_documents' => 'Ajouter, modifier et supprimer des documents officiels'
            ],
            'Logistique & Expéditions (Fournisseur)' => [
                'view_logistics' => 'Accéder aux commandes logistiques et fiches d\'expédition'
            ]
        ];

        $roles = [
            'agent' => 'Agent Commercial',
            'media_buyer' => 'Media Buyer',
            'supplier' => 'Fournisseur'
        ];

        $currentPermissions = \DB::table('role_permissions')->get()->groupBy('role')->map(function ($items) {
            return $items->pluck('permission')->toArray();
        })->toArray();

        return view('users.permissions', compact('modules', 'roles', 'currentPermissions'));
    }

    public function permissionsUpdate(Request $request)
    {
        $roles = ['agent', 'media_buyer', 'supplier'];
        $permissionsInput = $request->input('permissions', []);

        \DB::transaction(function () use ($roles, $permissionsInput) {
            // Delete current role permissions for non-admin roles
            \DB::table('role_permissions')->whereIn('role', $roles)->delete();

            // Insert new permissions
            foreach ($permissionsInput as $role => $permissions) {
                if (in_array($role, $roles) && is_array($permissions)) {
                    foreach ($permissions as $permission) {
                        \DB::table('role_permissions')->insert([
                            'role' => $role,
                            'permission' => $permission,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('permissions.index')->with('success', 'Permissions des rôles mises à jour avec succès.');
    }
}
