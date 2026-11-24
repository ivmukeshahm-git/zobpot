<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_internship', 'platform_service_charge')) {
                $table->decimal('platform_service_charge', 10, 2)->default(0)->after('final_amount');
            }
        });

        Schema::table('tbl_internship_payment', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_internship_payment', 'platform_service_charge')) {
                $table->decimal('platform_service_charge', 10, 2)->default(0)->after('gst_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_internship', 'platform_service_charge')) {
                $table->dropColumn('platform_service_charge');
            }
        });

        Schema::table('tbl_internship_payment', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_internship_payment', 'platform_service_charge')) {
                $table->dropColumn('platform_service_charge');
            }
        });
    }
};
