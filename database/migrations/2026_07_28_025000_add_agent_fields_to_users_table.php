<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cin')->nullable()->after('role');
            $table->string('cin_card_path')->nullable()->after('cin');
            $table->string('engagement_letter_path')->nullable()->after('cin_card_path');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cin', 'cin_card_path', 'engagement_letter_path']);
        });
    }
};
