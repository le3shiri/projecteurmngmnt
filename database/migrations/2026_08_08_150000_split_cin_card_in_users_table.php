<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cin_recto_path')->nullable()->after('cin_card_path');
            $table->string('cin_verso_path')->nullable()->after('cin_recto_path');
        });

        // Copy existing cin_card_path data to cin_recto_path for backwards compatibility
        DB::statement("UPDATE users SET cin_recto_path = cin_card_path WHERE cin_card_path IS NOT NULL AND cin_recto_path IS NULL");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cin_recto_path', 'cin_verso_path']);
        });
    }
};
