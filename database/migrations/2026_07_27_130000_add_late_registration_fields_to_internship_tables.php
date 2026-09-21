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
            if (!Schema::hasColumn('tbl_internship', 'last_registration_date')) {
                $table->date('last_registration_date')->nullable()->after('application_deadline');
            }
            if (!Schema::hasColumn('tbl_internship', 'late_registration_fee')) {
                $table->decimal('late_registration_fee', 10, 2)->default(0)->after('registration_fees');
            }
        });

        Schema::table('tbl_internship_payment', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_internship_payment', 'registration_fee')) {
                $table->decimal('registration_fee', 10, 2)->default(0)->after('internship_id');
            }
            if (!Schema::hasColumn('tbl_internship_payment', 'late_registration_fee')) {
                $table->decimal('late_registration_fee', 10, 2)->default(0)->after('registration_fee');
            }
            if (!Schema::hasColumn('tbl_internship_payment', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0)->after('late_registration_fee');
            }
            if (!Schema::hasColumn('tbl_internship_payment', 'is_late_registration')) {
                $table->boolean('is_late_registration')->default(false)->after('total_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_internship', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_internship', 'last_registration_date')) {
                $table->dropColumn('last_registration_date');
            }
            if (Schema::hasColumn('tbl_internship', 'late_registration_fee')) {
                $table->dropColumn('late_registration_fee');
            }
        });

        Schema::table('tbl_internship_payment', function (Blueprint $table) {
            $columns = [];
            foreach (['registration_fee', 'late_registration_fee', 'subtotal', 'is_late_registration'] as $column) {
                if (Schema::hasColumn('tbl_internship_payment', $column)) {
                    $columns[] = $column;
                }
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
