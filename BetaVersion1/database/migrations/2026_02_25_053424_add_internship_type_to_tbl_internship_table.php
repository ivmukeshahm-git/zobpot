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
        Schema::table('tbl_internship', function (Blueprint $table) {
            $table->tinyInteger('internship_type')
                ->default(0)
                ->comment('0 = Default, 1 = With College, 2 = With Industry')
                ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            //
        });
    }
};
