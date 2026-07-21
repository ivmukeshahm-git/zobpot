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
        Schema::create('tbl_resume', function (Blueprint $table) {
            $table->id('resume_id'); // Primary Key: Unique ID for each resume
            $table->unsignedBigInteger('user_id'); // Foreign Key: References users table
            $table->string('file_nm'); // Filename or path of the resume file
            $table->tinyInteger('resume_type')->comment('1: Uploaded Resume, 2: Resume Builder'); // Type of resume

            $table->timestamps(); // created_at and updated_at

            // Add foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_resume');
    }
};
