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
        Schema::table('tbl_internship_tasks', function (Blueprint $table) {
            $table->text('task_feedback')->nullable()->default(null)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_internship_tasks', function (Blueprint $table) {
            $table->dropColumn('task_feedback');
        });
    }
};
