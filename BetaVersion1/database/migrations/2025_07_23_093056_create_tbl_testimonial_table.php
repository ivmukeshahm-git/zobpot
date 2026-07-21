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
        Schema::create('tbl_testimonial', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('designation')->nullable();
            $table->text('description');
            $table->string('profile_img')->nullable(); // path to image
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_testimonial');
    }
};
