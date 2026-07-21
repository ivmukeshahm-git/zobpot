<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblInternshipApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_internship_application', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Applicant user id');
            $table->unsignedBigInteger('internship_id')->nullable()->comment('Reference to internship');
            $table->unsignedBigInteger('company_id')->nullable()->comment('Company offering internship');

            $table->tinyInteger('complete_status')->default(0)->comment('0: pending, 1: completed');
            $table->timestamp('applied_on')->nullable()->comment('Datetime when application was submitted');

            $table->text('company_feedback')->nullable()->comment('Feedback from company');
            $table->text('college_feedback')->nullable()->comment('Feedback from college');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_internship_application');
    }
}
