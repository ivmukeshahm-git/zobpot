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
       Schema::table('tbl_state', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->after('state_name')->nullable();

            // Optional: Add foreign key constraint if you have a `tbl_country` table
            // $table->foreign('country_id')->references('country_id')->on('tbl_country')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_state', function (Blueprint $table) {
            //
        });
    }
};
