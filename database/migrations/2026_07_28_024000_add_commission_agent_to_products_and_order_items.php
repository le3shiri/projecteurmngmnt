<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('commission_agent', 10, 2)->default(0)->after('prix_fournisseur');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('commission_agent', 10, 2)->default(0)->after('prix_fournisseur');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('commission_agent');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('commission_agent');
        });
    }
};
