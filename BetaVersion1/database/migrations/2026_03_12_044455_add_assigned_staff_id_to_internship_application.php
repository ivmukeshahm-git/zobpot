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
        Schema::table('tbl_internship_application', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_staff_id')->nullable()->after('college_feedback');
            $table->foreign('assigned_staff_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_internship_application', function (Blueprint $table) {
            $table->dropForeign(['assigned_staff_id']);
            $table->dropColumn('assigned_staff_id');
        });
    }
};
