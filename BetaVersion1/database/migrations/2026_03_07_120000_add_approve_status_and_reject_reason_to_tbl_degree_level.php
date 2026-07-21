<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_degree_level', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_degree_level', 'approve_status')) {
                $table->tinyInteger('approve_status')->default(0)->comment('0:pending,1:approved,2:rejected')->after('degree_level_name');
            }
            if (!Schema::hasColumn('tbl_degree_level', 'reject_reason')) {
                $table->text('reject_reason')->nullable()->after('approve_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_degree_level', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_degree_level', 'reject_reason')) {
                $table->dropColumn('reject_reason');
            }
            if (Schema::hasColumn('tbl_degree_level', 'approve_status')) {
                $table->dropColumn('approve_status');
            }
        });
    }
};
