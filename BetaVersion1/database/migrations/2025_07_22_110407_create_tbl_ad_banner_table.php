<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('tbl_ad_banner', function (Blueprint $table) {
            $table->id();
            $table->string('page_nm');
            $table->string('ad_link')->nullable();
            $table->string('img_nm')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->dateTime('datetime')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->softDeletes();    // <--- Soft delete support (adds 'deleted_at' column)
            $table->timestamps();     // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_ad_banner');
    }
};
