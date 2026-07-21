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
        Schema::create('tbl_company_branches', function (Blueprint $table) {
            $table->id('branch_id');
            $table->unsignedBigInteger('user_id');
            $table->string('company_nm');
            $table->text('company_address');
            $table->boolean('status')->default(1);
            $table->softDeletes(); // For soft deletes
            $table->timestamps();

            // Optional: Foreign key constraint (if you want to link with users table)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_branches');
    }
};
