<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            $table->tinyInteger('college_complete_sts')->default(0)->after('complete_status');
            $table->tinyInteger('company_complete_sts')->default(0)->after('college_complete_sts');
        });
    }

    public function down()
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            $table->dropColumn(['college_complete_sts', 'company_complete_sts']);
        });
    }
};
