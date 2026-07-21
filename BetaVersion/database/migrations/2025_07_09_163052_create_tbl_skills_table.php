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
        Schema::create('tbl_skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('skill_nm');
            $table->timestamps();
            $table->softDeletes();

            // Optional: add foreign key constraints if category/subcategory tables exist
            // $table->foreign('category_id')->references('category_id')->on('tbl_category')->onDelete('cascade');
            // $table->foreign('sub_category_id')->references('sub_category_id')->on('tbl_sub_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_skills');
    }
};
