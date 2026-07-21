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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('contact_no')->nullable();
            $table->string('city_id')->nullable();
            $table->string('state_id')->nullable();
            $table->unsignedBigInteger('zipcode_id')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('skills_id')->nullable();
            $table->text('company_desc')->nullable();
            $table->text('about')->nullable();
            $table->unsignedBigInteger('preference_type')->nullable()->comment('1: Skill 2: Non-Skill');
            $table->tinyInteger('verify_status')->default(0); // 0 = unverified, 1 = verified
            $table->string('profile_type')->nullable(); // e.g., admin, user
            $table->tinyInteger('active_status')->default(1); // 1 = active, 0 = inactive
            // $table->string('role')->default('User');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // Add soft delete support
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
