<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Modify users table role column to support string / media_buyer
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'agent'");
        } catch (\Exception $e) {
            // Fallback for SQLite or other drivers
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 50)->default('agent')->change();
            });
        }

        // 2. Insert initial role permissions for media_buyer
        $mediaBuyerPermissions = [
            'view_dashboard',
            'view_orders',
            'manage_orders',
            'view_customers',
            'manage_customers',
            'view_prospects',
            'manage_prospects',
            'view_products',
            'view_trainings',
        ];

        foreach ($mediaBuyerPermissions as $perm) {
            DB::table('role_permissions')->updateOrInsert(
                ['role' => 'media_buyer', 'permission' => $perm],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        DB::table('role_permissions')->where('role', 'media_buyer')->delete();
    }
};
