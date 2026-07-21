<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_marks', function (Blueprint $table) {
            // Add snapshot columns for future-proof data consistency
            $table->string('criteria_name')->nullable()->after('criteria_id');
            $table->integer('max_marks')->default(0)->after('criteria_name');

            // Remove feedback column — feedback now lives in tbl_internship_application
            if (Schema::hasColumn('internship_marks', 'feedback')) {
                $table->dropColumn('feedback');
            }
        });
    }

    public function down(): void
    {
        Schema::table('internship_marks', function (Blueprint $table) {
            $table->text('feedback')->nullable()->after('marks');

            if (Schema::hasColumn('internship_marks', 'criteria_name')) {
                $table->dropColumn('criteria_name');
            }
            if (Schema::hasColumn('internship_marks', 'max_marks')) {
                $table->dropColumn('max_marks');
            }
        });
    }
};
