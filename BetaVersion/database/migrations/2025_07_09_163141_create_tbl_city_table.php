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
        Schema::create('tbl_city', function (Blueprint $table) {
            $table->bigIncrements('city_id');
            $table->unsignedBigInteger('state_id');
            $table->string('city_nm');
            $table->timestamps();
            $table->softDeletes();

            // // Foreign key constraint (optional but recommended)
            // $table->foreign('state_id')
            //     ->references('state_id')
            //     ->on('tbl_state')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_city');
    }
};
