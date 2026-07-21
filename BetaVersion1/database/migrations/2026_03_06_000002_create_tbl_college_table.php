<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_college', function (Blueprint $table) {
            $table->id();
            $table->string('college_name');
            $table->unsignedBigInteger('university_id');
            $table->string('status')->default('pending')->comment('pending, approved, rejected');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('university_id')->references('id')->on('tbl_university')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_college');
    }
};
