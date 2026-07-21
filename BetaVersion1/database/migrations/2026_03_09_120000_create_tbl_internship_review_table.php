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
        Schema::create('tbl_internship_review', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('internship_id')->index();
            $table->unsignedBigInteger('student_id')->index();
            $table->tinyInteger('star')->unsigned();
            $table->text('review')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamp('write_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_internship_review');
    }
};
