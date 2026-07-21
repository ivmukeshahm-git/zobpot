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
            if (!Schema::hasColumn('tbl_internship', 'manage_task_status')) {
                $table->boolean('manage_task_status')->default(0)->after('final_amount')->comment('Enable task management for this internship');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_internship', 'manage_task_status')) {
                $table->dropColumn('manage_task_status');
            }
        });
    }
};
