<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToTblCollege extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tbl_college')) {
            Schema::table('tbl_college', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_college', 'role')) {
                    $table->string('role', 50)->nullable()->after('status')->comment('Role or type for college');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('tbl_college')) {
            Schema::table('tbl_college', function (Blueprint $table) {
                if (Schema::hasColumn('tbl_college', 'role')) {
                    $table->dropColumn('role');
                }
            });
        }
    }
}
