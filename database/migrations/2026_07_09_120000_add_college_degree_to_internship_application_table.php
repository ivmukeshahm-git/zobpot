<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_internship_application', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_internship_application', 'college_id')) {
                $table->unsignedBigInteger('college_id')->nullable()->after('company_id');
            }
            if (!Schema::hasColumn('tbl_internship_application', 'degree_id')) {
                $table->unsignedBigInteger('degree_id')->nullable()->after('college_id');
            }
        });

        DB::statement('
            UPDATE tbl_internship_application ia
            INNER JOIN users u ON ia.user_id = u.id
            SET ia.college_id = u.college_id,
                ia.degree_id = u.degree_id
            WHERE ia.college_id IS NULL OR ia.degree_id IS NULL
        ');
    }

    public function down()
    {
        Schema::table('tbl_internship_application', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_internship_application', 'degree_id')) {
                $table->dropColumn('degree_id');
            }
            if (Schema::hasColumn('tbl_internship_application', 'college_id')) {
                $table->dropColumn('college_id');
            }
        });
    }
};
