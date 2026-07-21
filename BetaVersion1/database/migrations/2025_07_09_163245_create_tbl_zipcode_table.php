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
        Schema::create('tbl_zipcode', function (Blueprint $table) {
            $table->bigIncrements('zipcode_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('area_id');
            $table->string('zipcode');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints (optional but recommended)
            // $table->foreign('state_id')->references('state_id')->on('tbl_state')->onDelete('cascade');
            // $table->foreign('city_id')->references('city_id')->on('tbl_city')->onDelete('cascade');
            // $table->foreign('area_id')->references('area_id')->on('tbl_area')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_zipcode');
    }
};
