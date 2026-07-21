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
        Schema::table('tbl_college', function (Blueprint $table) {
            $table->string('college_code')->nullable()->after('college_name');
            $table->string('email')->nullable()->after('university_id');
            $table->string('phone')->nullable()->after('email');
            $table->string('website')->nullable()->after('phone');
            $table->string('established_year')->nullable()->after('website');
            $table->text('address')->nullable()->after('established_year');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('pincode')->nullable()->after('state');
            $table->string('logo')->nullable()->after('pincode');
            $table->text('reject_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_college', function (Blueprint $table) {
            $table->dropColumn([
                'college_code', 'email', 'phone', 'website',
                'established_year', 'address', 'city', 'state',
                'pincode', 'logo', 'reject_reason',
            ]);
        });
    }
};
