<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default accounts
        \App\Models\User::create([
            'name' => 'Directeur Admin',
            'email' => 'admin@projecteur.com',
            'role' => 'admin',
            'commission_rate' => 0.00,
            'phone' => '0611223344',
            'password' => bcrypt('admin123'),
            'access_code' => 'ADMIN01',
            'is_active' => true,
        ]);

        $agent = \App\Models\User::create([
            'name' => 'Agent Commercial Maroc',
            'email' => 'agent@projecteur.com',
            'role' => 'agent',
            'commission_rate' => 15.00, // 15% custom commission
            'phone' => '0622334455',
            'password' => bcrypt('agent123'),
            'access_code' => 'AGENT01',
            'is_active' => true,
        ]);

        \App\Models\User::create([
            'name' => 'Chef de Dépôt Fournisseur',
            'email' => 'supplier@projecteur.com',
            'role' => 'supplier',
            'commission_rate' => 0.00,
            'phone' => '0633445566',
            'password' => bcrypt('supplier123'),
            'access_code' => 'FOURN01',
            'is_active' => true,
        ]);

        // 2. Create sample clients
        $client1 = \App\Models\Customer::create([
            'name' => 'Café Fleur de Lys',
            'phone' => '0699887766',
            'email' => 'contact@cafefleur.ma',
            'company' => 'Café Fleur S.A.R.L',
            'address' => 'Avenue Mohammed V, Appt 12, Rabat',
            'notes' => 'Intéressé par projection extérieure rotative',
        ]);

        $client2 = \App\Models\Customer::create([
            'name' => 'Hôtel Atlas Marrakech',
            'phone' => '0522445566',
            'email' => 'front@atlasmarrakech.com',
            'company' => 'Hotels Atlas Group',
            'address' => 'Hivernage, Boulevard El Yarmouk, Marrakech',
            'notes' => 'Demande de logo étanche IP67 haute luminosité',
        ]);

        \App\Models\Product::create([
            'code' => 'PROJ-LED20W',
            'name' => 'Projecteur Logo LED 20W (Intérieur)',
            'description' => 'Idéal pour projections courtes distances sur sol ou mur. Optique rotative incluse.',
            'category' => 'Intérieur',
            'price' => 1200.00,
            'prix_fournisseur' => 400.00,
            'commission_agent' => 100.00,
            'stock' => 15,
        ]);
 
        \App\Models\Product::create([
            'code' => 'PROJ-LED50W',
            'name' => 'Projecteur Logo LED 50W (Extérieur/Étanche)',
            'description' => 'Projecteur extérieur puissant IP65 avec lentille rotative de précision pour logos nets.',
            'category' => 'Extérieur',
            'price' => 2400.00,
            'prix_fournisseur' => 900.00,
            'commission_agent' => 200.00,
            'stock' => 8,
        ]);
 
        \App\Models\Product::create([
            'code' => 'PROJ-LED100W',
            'name' => 'Projecteur Logo LED 100W (Ultra Puissant)',
            'description' => 'Usage extérieur longue portée (jusqu\'à 30 mètres). Idéal façades de bâtiments et évènementiel.',
            'category' => 'Extérieur',
            'price' => 4500.00,
            'prix_fournisseur' => 1800.00,
            'commission_agent' => 400.00,
            'stock' => 3,
        ]);
 
        \App\Models\Product::create([
            'code' => 'LENT-ROT',
            'name' => 'Lentille Rotative Standard rechange',
            'description' => 'Focale de rechange standard pour projecteurs 20W et 50W.',
            'category' => 'Accessoires',
            'price' => 250.00,
            'prix_fournisseur' => 80.00,
            'commission_agent' => 20.00,
            'stock' => 30,
        ]);
    }
}
