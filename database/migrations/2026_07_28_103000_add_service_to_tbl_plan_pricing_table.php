<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_plan_pricing')) {
            return;
        }

        Schema::table('tbl_plan_pricing', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_plan_pricing', 'service')) {
                $table->string('service', 20)->default('none')->after('plan_for');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('tbl_plan_pricing')) {
            return;
        }

        Schema::table('tbl_plan_pricing', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_plan_pricing', 'service')) {
                $table->dropColumn('service');
            }
        });
    }
};
