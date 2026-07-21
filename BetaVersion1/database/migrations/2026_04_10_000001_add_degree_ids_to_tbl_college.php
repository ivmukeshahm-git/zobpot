<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add degree_ids (JSON) column to tbl_college.
     * Stores an array of degree IDs associated with the college.
     */
    public function up(): void
    {
        Schema::table('tbl_college', function (Blueprint $table) {
            // Nullable so existing rows are not affected
            $table->json('degree_ids')->nullable()->after('university_id');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_college', function (Blueprint $table) {
            $table->dropColumn('degree_ids');
        });
    }
};
