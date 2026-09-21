<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_certificate_setting')) {
            return;
        }

        Schema::table('tbl_certificate_setting', function (Blueprint $table) {
            $columns = [
                'label_certificate_no',
                'label_duration',
                'label_period',
                'label_issue_date',
                'label_mode',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('tbl_certificate_setting', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('tbl_certificate_setting')) {
            return;
        }

        Schema::table('tbl_certificate_setting', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_certificate_setting', 'label_certificate_no')) {
                $table->string('label_certificate_no')->nullable();
            }
            if (!Schema::hasColumn('tbl_certificate_setting', 'label_duration')) {
                $table->string('label_duration')->nullable();
            }
            if (!Schema::hasColumn('tbl_certificate_setting', 'label_period')) {
                $table->string('label_period')->nullable();
            }
            if (!Schema::hasColumn('tbl_certificate_setting', 'label_issue_date')) {
                $table->string('label_issue_date')->nullable();
            }
            if (!Schema::hasColumn('tbl_certificate_setting', 'label_mode')) {
                $table->string('label_mode')->nullable();
            }
        });
    }
};
