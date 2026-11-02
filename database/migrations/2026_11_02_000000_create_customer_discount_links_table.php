<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_discount_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('token', 64)->unique();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('first_agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('discount_initial', 5, 2)->default(11.00);
            $table->decimal('discount_permanent', 5, 2)->default(5.00);
            $table->unsignedInteger('initial_duration_days')->default(10);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('source')->nullable()->after('notes');
            $table->decimal('discount_rate', 5, 2)->nullable()->after('source');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('discount_rate');
            $table->foreignId('customer_discount_link_id')->nullable()->after('discount_amount')->constrained('customer_discount_links')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_discount_link_id']);
            $table->dropColumn(['customer_discount_link_id', 'discount_amount', 'discount_rate', 'source']);
        });

        Schema::dropIfExists('customer_discount_links');
    }
};

