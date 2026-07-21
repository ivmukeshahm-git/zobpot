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
         Schema::create('tbl_area', function (Blueprint $table) {
        $table->bigIncrements('area_id');
        $table->unsignedBigInteger('state_id');
        $table->unsignedBigInteger('city_id');
        $table->string('area_nm');
        $table->timestamps();
        $table->softDeletes();

        // Foreign key constraints
        // $table->foreign('state_id')->references('state_id')->on('tbl_state')->onDelete('cascade');
        // $table->foreign('city_id')->references('city_id')->on('tbl_city')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_area');
    }
};
