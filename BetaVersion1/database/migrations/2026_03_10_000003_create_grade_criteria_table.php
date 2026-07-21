<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grade_criteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('section_id');
            $table->string('title');
            $table->integer('marks');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('grade_sections')->onDelete('cascade');
            $table->index(['grade_id', 'section_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_criteria');
    }
};
