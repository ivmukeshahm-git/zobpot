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
        Schema::table('tbl_blog', function (Blueprint $table) {
            $table->dateTime('datetime')->nullable()->after('status');
            // You can adjust 'after' based on column position if needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_blog', function (Blueprint $table) {
            //
        });
    }
};
