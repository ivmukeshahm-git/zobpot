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
        Schema::create('tbl_education', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->unsignedBigInteger('user_id');
            $table->string('degree');
            $table->string('field_of_study')->nullable();
            $table->string('grade')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
             $table->softDeletes(); // <-- Adds `deleted_at` for soft delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_education');
    }
};
