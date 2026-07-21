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
            $table->string('job_timing')->nullable()->after('experience_req_id'); // adjust position if needed
            $table->string('age')->nullable()->after('job_timing');
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
