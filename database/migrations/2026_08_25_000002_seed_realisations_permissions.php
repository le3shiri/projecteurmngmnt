<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Admins always get all permissions via User::hasPermission() — no rows needed.
        // Grant agents read access (view + store is guarded by view_realisations in middleware).
        $agentPermissions = ['view_realisations'];

        foreach ($agentPermissions as $permission) {
            DB::table('role_permissions')->updateOrInsert(
                ['role' => 'agent', 'permission' => $permission],
                ['role' => 'agent', 'permission' => $permission]
            );
        }
    }

    public function down(): void
    {
        DB::table('role_permissions')
            ->where('role', 'agent')
            ->whereIn('permission', ['view_realisations', 'manage_realisations'])
            ->delete();
    }
};
