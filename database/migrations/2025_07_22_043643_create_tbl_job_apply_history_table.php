<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('tbl_job_apply_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('job_apply_id');
            $table->text('msg')->nullable();
            $table->dateTime('datetime')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            $table->softDeletes();

            // Optional: add foreign keys if needed
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('job_id')->references('id')->on('tbl_job')->onDelete('cascade');
            // $table->foreign('job_apply_id')->references('id')->on('tbl_job_apply')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_job_apply_history');
    }
};
