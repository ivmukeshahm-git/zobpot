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
        Schema::create('tbl_internship_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->dateTime('date_time')->nullable()->comment('Date & Time for the task');
            $table->string('day', 50)->nullable()->comment('Day of the week (e.g., Monday)');
            $table->string('module_title')->comment('Module/Task Title');
            $table->text('module_description')->nullable()->comment('Module and Task Description');
            $table->string('upload_file')->nullable()->comment('Uploaded file path');
            $table->date('last_submission_date')->nullable()->comment('Last date for submission');
            $table->string('online_link')->nullable()->comment('Online link for task');
            $table->boolean('is_final_assignment')->default(0)->comment('1 = Final Assignment/Report, 0 = Regular Task');
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('internship_id')
                  ->references('id')
                  ->on('tbl_internship')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_internship_tasks');
    }
};
