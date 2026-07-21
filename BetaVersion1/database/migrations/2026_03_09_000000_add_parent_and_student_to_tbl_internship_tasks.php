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
            if (!Schema::hasColumn('tbl_internship_tasks', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('internship_id');
            }
            if (!Schema::hasColumn('tbl_internship_tasks', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable()->after('parent_id');
            }
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
            if (Schema::hasColumn('tbl_internship_tasks', 'student_id')) {
                $table->dropColumn('student_id');
            }
            if (Schema::hasColumn('tbl_internship_tasks', 'parent_id')) {
                $table->dropColumn('parent_id');
            }
        });
    }
};
