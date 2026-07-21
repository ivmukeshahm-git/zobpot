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
        Schema::create('tbl_round_complete', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('round_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('job_id');
            $table->string('hr_name')->nullable();
            $table->string('hr_contact_no')->nullable();
            $table->string('hr_email')->nullable();
            $table->string('interview_address')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->dateTime('complete_datetime')->nullable();
            $table->tinyInteger('status')->default(0); // default status 0
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
        Schema::dropIfExists('tbl_round_complete');
    }
};
