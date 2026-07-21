<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_university', function (Blueprint $table) {
            $table->id();
            $table->string('university_name');
            $table->string('status')->default('pending')->comment('pending, approved, rejected');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_university');
    }
};
