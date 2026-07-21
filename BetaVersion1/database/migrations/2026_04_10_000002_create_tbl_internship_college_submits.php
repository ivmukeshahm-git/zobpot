<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_internship_college_submits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->unsignedBigInteger('college_id');
            $table->unsignedBigInteger('course_id');   // degree_id
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique(['internship_id', 'college_id', 'course_id'], 'unique_internship_college_course');
            $table->foreign('internship_id')->references('id')->on('tbl_internship')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_internship_college_submits');
    }
};
