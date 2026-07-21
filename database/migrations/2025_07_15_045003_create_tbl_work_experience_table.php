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
        Schema::create('tbl_work_experience', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('work_type_id');
            $table->unsignedBigInteger('user_id');
            $table->string('company');
            $table->boolean('working_status')->default(1); // 1 = working, 0 = not working
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('location');
            $table->unsignedBigInteger('job_type_id');
            $table->text('role_responsibility')->nullable();
            $table->timestamps();
            $table->softDeletes(); // For soft delete

            // Optional: Add foreign key constraints if needed
            // $table->foreign('work_type_id')->references('id')->on('tbl_work_types');
            // $table->foreign('job_type_id')->references('id')->on('tbl_job_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_work_experience');
    }
};
