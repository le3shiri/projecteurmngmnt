<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('category')->constrained('categories')->onDelete('set null');
        });

        // Migrate existing category string data to the new categories table
        $products = DB::table('products')->get();
        foreach ($products as $p) {
            if ($p->category) {
                $categoryName = trim($p->category);
                $category = DB::table('categories')->where('name', $categoryName)->first();
                
                if (!$category) {
                    $catId = DB::table('categories')->insertGetId([
                        'name' => $categoryName,
                        'slug' => Str::slug($categoryName),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $catId = $category->id;
                }

                DB::table('products')->where('id', $p->id)->update(['category_id' => $catId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
