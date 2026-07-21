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
       Schema::create('tbl_work_type', function (Blueprint $table) {
        $table->bigIncrements('work_type_id');
        $table->string('type_nm');
        $table->timestamps();
        $table->softDeletes(); // Enables soft delete functionality
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_work_type');
    }
};
