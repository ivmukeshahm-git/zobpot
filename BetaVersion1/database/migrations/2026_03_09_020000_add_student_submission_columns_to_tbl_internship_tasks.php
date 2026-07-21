<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('student_submit_file', 250)->nullable()->after('is_final_assignment');
            $table->text('student_submit_description')->nullable()->after('student_submit_file');
            $table->string('student_submit_project_link', 250)->nullable()->after('student_submit_description');
            // Use CURRENT_DATE as default for submit_on when supported by DB
            $table->date('submit_on')->nullable()->default(DB::raw('CURRENT_DATE'))->after('student_submit_project_link');
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
            $table->dropColumn(['student_submit_file', 'student_submit_description', 'student_submit_project_link', 'submit_on']);
        });
    }
};
