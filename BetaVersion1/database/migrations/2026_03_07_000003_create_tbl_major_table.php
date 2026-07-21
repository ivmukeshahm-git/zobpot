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
        Schema::create('tbl_major', function (Blueprint $table) {
            $table->id('major_id');
            $table->unsignedBigInteger('degree_id');
            $table->string('major_name');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('degree_id')->references('degree_id')->on('tbl_degree')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_major');
    }
};
