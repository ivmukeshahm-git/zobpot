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
        Schema::table('tbl_ad_banner', function (Blueprint $table) {
            $table->tinyInteger('status')
                ->default(1)
                ->comment('1 = Active, 0 = Inactive')
                ->after('end_date'); // Adjust position as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_ad_banner', function (Blueprint $table) {
            //
        });
    }
};
