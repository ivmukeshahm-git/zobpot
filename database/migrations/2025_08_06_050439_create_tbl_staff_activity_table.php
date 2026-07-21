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
        Schema::create('tbl_staff_activity', function (Blueprint $table) {
            $table->bigIncrements('activity_id');
            $table->unsignedBigInteger('user_id');
            $table->text('msg');
            $table->string('current_path')->nullable();
            $table->dateTime('datetime')->useCurrent();

            // Add foreign key if user_id references users table
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_staff_activity');
    }
};
