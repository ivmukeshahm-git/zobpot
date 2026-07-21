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
        Schema::create('tbl_job', function (Blueprint $table) {
            $table->id('job_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('preference_type');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('job_title');
            $table->unsignedBigInteger('qualification_id')->nullable();
            $table->unsignedBigInteger('job_level_id')->nullable();
            $table->unsignedBigInteger('job_type_id')->nullable();
            $table->unsignedBigInteger('work_type_id')->nullable();
            $table->integer('number_of_openings')->default(1);
            $table->text('job_description')->nullable();
            $table->text('interviewer_address')->nullable();
            $table->unsignedBigInteger('experience_req_id')->nullable();
            $table->string('contact_no', 20)->nullable();
            $table->string('company_website')->nullable();
            $table->text('company_address')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('zipcode_id')->nullable();
            $table->string('hr_email')->nullable();
            $table->string('hr_contact_no', 20)->nullable();
            $table->string('skill_id')->nullable(); // Consider storing as comma-separated or use relation
            $table->dateTime('datetime')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_job');
    }
};
