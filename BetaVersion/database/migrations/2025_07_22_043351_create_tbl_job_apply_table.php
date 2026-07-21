<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('tbl_job_apply', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('user_id');

            $table->text('description')->nullable();
            $table->string('file_nm')->nullable()->comment('Uploaded file: image/pdf/doc/docx');

            $table->tinyInteger('status')->default(0)->comment('0 = Pending, 1 = Accepted, 2 = Rejected');
            $table->dateTime('datetime')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamps();
            $table->softDeletes();

            // Optional: add foreign keys if needed
            // $table->foreign('job_id')->references('id')->on('tbl_job')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_job_apply');
    }
};
