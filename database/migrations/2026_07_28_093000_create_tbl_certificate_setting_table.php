<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tbl_certificate_setting')) {
            Schema::create('tbl_certificate_setting', function (Blueprint $table) {
                $table->id();
                $table->string('cert_type', 20)->unique(); // company | college
                $table->string('brand_title')->nullable();
                $table->string('heading')->nullable();
                $table->string('subtitle')->nullable();
                $table->string('badge_label')->nullable();
                $table->string('certify_text')->nullable();
                $table->string('student_of_text')->nullable();
                $table->string('pursuing_text')->nullable();
                $table->string('completed_text')->nullable();
                $table->string('conducted_by_text')->nullable();
                $table->string('association_text')->nullable();
                $table->string('awarded_by_text')->nullable();
                $table->text('disclaimer_text')->nullable();
                $table->string('left_signatory_role')->nullable();
                $table->string('platform_director_name')->nullable();
                $table->string('platform_director_role')->nullable();
                $table->string('seal_line1')->nullable();
                $table->string('seal_line2')->nullable();
                $table->timestamps();
            });
        }

        $now = now();
        $defaults = [
            [
                'cert_type' => 'company',
                'brand_title' => 'ZobPot Internship Portal',
                'heading' => 'Certificate',
                'subtitle' => 'Of Internship Completion',
                'badge_label' => 'Company Certificate',
                'certify_text' => 'This is to certify that',
                'student_of_text' => null,
                'pursuing_text' => null,
                'completed_text' => 'has successfully completed the internship programme',
                'conducted_by_text' => 'conducted by',
                'association_text' => null,
                'awarded_by_text' => null,
                'disclaimer_text' => 'The intern has demonstrated dedication, professionalism and satisfactory performance throughout the internship duration.',
                'left_signatory_role' => 'Authorized Company Signatory',
                'platform_director_name' => 'ZobPot',
                'platform_director_role' => 'Platform Director',
                'seal_line1' => 'OFFICIAL',
                'seal_line2' => 'SEAL',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'cert_type' => 'college',
                'brand_title' => 'ZobPot Internship Portal',
                'heading' => 'Certificate',
                'subtitle' => 'Of Internship Completion',
                'badge_label' => 'College Certificate',
                'certify_text' => 'This is to certify that',
                'student_of_text' => 'a student of',
                'pursuing_text' => 'pursuing',
                'completed_text' => 'has successfully completed the internship programme',
                'conducted_by_text' => null,
                'association_text' => 'in association with',
                'awarded_by_text' => 'and is hereby awarded this certificate by',
                'disclaimer_text' => 'The intern has demonstrated dedication, professionalism and satisfactory performance throughout the internship duration.',
                'left_signatory_role' => 'College Authorized Signatory',
                'platform_director_name' => 'ZobPot',
                'platform_director_role' => 'Platform Director',
                'seal_line1' => 'OFFICIAL',
                'seal_line2' => 'SEAL',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($defaults as $row) {
            $exists = DB::table('tbl_certificate_setting')->where('cert_type', $row['cert_type'])->exists();
            if (!$exists) {
                DB::table('tbl_certificate_setting')->insert($row);
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('tbl_certificate_setting');
    }
};
