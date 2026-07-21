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
        if (Schema::hasTable('tbl_college')) {
            Schema::table('tbl_college', function (Blueprint $table) {
                if (!Schema::hasColumn('tbl_college', 'password')) {
                    $table->string('password')->nullable()->after('email');
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
                if (Schema::hasColumn('tbl_college', 'password')) {
                    $table->dropColumn('password');
                }
            });
        }
    }
};
