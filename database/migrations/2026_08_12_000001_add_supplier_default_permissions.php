<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $supplierPermissions = [
            'view_dashboard',
            'view_logistics',
            'view_orders',
            'view_products',
        ];

        foreach ($supplierPermissions as $perm) {
            DB::table('role_permissions')->updateOrInsert(
                ['role' => 'supplier', 'permission' => $perm],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        DB::table('role_permissions')->where('role', 'supplier')->whereIn('permission', ['view_logistics', 'view_orders'])->delete();
    }
};
