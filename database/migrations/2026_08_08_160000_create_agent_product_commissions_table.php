<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agent_product_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->decimal('commission', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'agent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_product_commissions');
    }
};
