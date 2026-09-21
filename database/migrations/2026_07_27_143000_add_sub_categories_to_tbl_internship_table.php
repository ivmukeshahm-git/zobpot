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
        Schema::table('tbl_internship', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_internship', 'sub_categories')) {
                $table->json('sub_categories')->nullable()->after('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_internship', 'sub_categories')) {
                $table->dropColumn('sub_categories');
            }
        });
    }
};
