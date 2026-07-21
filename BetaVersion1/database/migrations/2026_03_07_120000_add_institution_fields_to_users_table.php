<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstitutionFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // store only integer values; all nullable by default
            $table->unsignedInteger('university_id')->nullable()->after('about');
            $table->unsignedInteger('college_id')->nullable()->after('university_id');
            $table->unsignedInteger('degree_level_id')->nullable()->after('college_id');
            $table->unsignedInteger('degree_id')->nullable()->after('degree_level_id');
            $table->unsignedInteger('major_id')->nullable()->after('degree_id');
            $table->unsignedInteger('semester')->nullable()->after('major_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'university_id',
                'college_id',
                'degree_level_id',
                'degree_id',
                'major_id',
                'semester',
            ]);
        });
    }
}
