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
        Schema::table('users', function (Blueprint $table) {
            // Add your desired columns here
            $table->string('personal_name')->nullable();
            $table->string('contact_person_nm')->nullable();
            $table->string('contact_person_phone_no')->nullable();
            $table->string('average_salary')->nullable();
            $table->string('company_size')->nullable();
            $table->string('company_since')->nullable();
            $table->string('personal_website')->nullable();
            $table->string('profile_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
