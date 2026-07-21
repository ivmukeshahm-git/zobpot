<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            $table->tinyInteger('college_pending_flag')
                  ->default(0)
                  ->after('college_complete_sts')
                  ->comment('1 = admin marked as pending for college marks entry');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            $table->dropColumn('college_pending_flag');
        });
    }
};
