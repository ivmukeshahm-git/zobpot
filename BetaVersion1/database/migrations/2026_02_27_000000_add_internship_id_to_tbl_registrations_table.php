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
        Schema::table('tbl_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('internship_id')->nullable()->after('type');
            
            // Add foreign key constraint if needed
            // $table->foreign('internship_id')->references('id')->on('tbl_internship')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_registrations', function (Blueprint $table) {
            // Drop foreign key first if it exists
            // $table->dropForeign(['internship_id']);
            $table->dropColumn('internship_id');
        });
    }
};
