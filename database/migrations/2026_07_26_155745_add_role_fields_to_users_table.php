<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'supplier', 'agent'])->default('agent')->after('email');
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('role');
            $table->string('phone')->nullable()->after('commission_rate');
            $table->boolean('is_active')->default(true)->after('phone');
            $table->string('access_code', 20)->nullable()->unique()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'commission_rate', 'phone', 'is_active', 'access_code']);
        });
    }
};
