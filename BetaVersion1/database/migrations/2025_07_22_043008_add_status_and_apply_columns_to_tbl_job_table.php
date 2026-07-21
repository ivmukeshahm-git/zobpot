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
        Schema::table('tbl_job', function (Blueprint $table) {
            $table->integer('status')
                ->default(1)
                ->comment('1-Active, 0-Draft, 2-Close')
                ->after('datetime'); // replace with actual column name if needed

            $table->integer('total_apply')
                ->nullable()
                ->after('status');

            $table->integer('remain_opening')
                ->nullable()
                ->after('total_apply');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_job', function (Blueprint $table) {
            //
        });
    }
};
