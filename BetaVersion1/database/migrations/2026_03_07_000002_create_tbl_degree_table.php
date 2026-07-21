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
        Schema::create('tbl_degree', function (Blueprint $table) {
            $table->id('degree_id');
            $table->unsignedBigInteger('degree_level_id');
            $table->string('degree_name');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('degree_level_id')->references('degree_level_id')->on('tbl_degree_level')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_degree');
    }
};
