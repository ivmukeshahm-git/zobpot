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
        Schema::create('tbl_plan_pricing', function (Blueprint $table) {
            $table->bigIncrements('plan_id');
            $table->string('plan_name');
            $table->decimal('plan_price', 10, 2);
            $table->text('plan_description')->nullable();
            $table->string('plan_for');
            $table->text('benefits')->nullable();
            $table->string('plan_duration'); // e.g., 1, 3, 12
            $table->string('plan_time'); // e.g., month, year
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_plan_pricing');
    }
};
