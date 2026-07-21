<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('criteria_id');
            $table->integer('marks')->default(0);
            $table->text('feedback')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=draft, 1=submitted');
            $table->timestamps();

            $table->foreign('internship_id')->references('id')->on('tbl_internship')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('criteria_id')->references('id')->on('grade_criteria')->onDelete('cascade');

            $table->unique(['internship_id', 'student_id', 'criteria_id'], 'intern_student_criteria_unique');
            $table->index(['internship_id', 'student_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_marks');
    }
};
