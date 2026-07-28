<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('permission');
            $table->unique(['role', 'permission']);
            $table->timestamps();
        });

        // Seed default permissions
        $agentPermissions = [
            'view_dashboard',
            'view_customers',
            'manage_customers',
            'view_products',
            'view_orders',
            'manage_orders',
            'update_order_status',
            'view_prospects',
            'view_trainings',
        ];

        foreach ($agentPermissions as $perm) {
            \DB::table('role_permissions')->insert([
                'role' => 'agent',
                'permission' => $perm,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $supplierPermissions = [
            'view_products',
            'manage_products',
        ];

        foreach ($supplierPermissions as $perm) {
            \DB::table('role_permissions')->insert([
                'role' => 'supplier',
                'permission' => $perm,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
