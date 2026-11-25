<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (! Schema::hasColumn('pages', 'intro')) {
                $table->json('intro')->nullable()->after('description');
            }
            if (! Schema::hasColumn('pages', 'image')) {
                $table->string('image')->nullable()->after('intro');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            foreach (['intro', 'image'] as $column) {
                if (Schema::hasColumn('pages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
