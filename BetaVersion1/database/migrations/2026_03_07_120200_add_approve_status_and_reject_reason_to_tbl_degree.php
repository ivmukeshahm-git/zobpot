<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_degree', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_degree', 'approve_status')) {
                $table->tinyInteger('approve_status')->default(0)->comment('0:pending,1:approved,2:rejected')->after('degree_name');
            }
            if (!Schema::hasColumn('tbl_degree', 'reject_reason')) {
                $table->text('reject_reason')->nullable()->after('approve_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_degree', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_degree', 'reject_reason')) {
                $table->dropColumn('reject_reason');
            }
            if (Schema::hasColumn('tbl_degree', 'approve_status')) {
                $table->dropColumn('approve_status');
            }
        });
    }
};
