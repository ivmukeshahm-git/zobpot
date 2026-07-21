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
        Schema::create('tbl_resume_builder', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->unsignedBigInteger('resume_id'); // Foreign key to tbl_resume

            $table->string('profile_img')->nullable(); // Path to profile image (optional)
            $table->string('full_name'); // Full name of the user
            $table->string('email'); // Email address
            $table->string('phone', 20); // Phone number
            $table->text('skills')->nullable(); // List of skills (can be JSON or comma-separated)
            $table->string('designation')->nullable(); // Job title/designation
            $table->text('summary')->nullable(); // Professional summary/about
            $table->text('experience')->nullable(); // Experience details
            $table->text('education')->nullable(); // Education details

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_resume_builder');
    }
};
