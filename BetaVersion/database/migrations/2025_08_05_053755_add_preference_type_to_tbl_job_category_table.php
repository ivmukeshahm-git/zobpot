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
        Schema::table('tbl_job_category', function (Blueprint $table) {
            $table->string('preference_type')->nullable()->after('category_id'); // Replace 'existing_column_name' with the column after which you want to add this
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_job_category', function (Blueprint $table) {
            //
        });
    }
};
