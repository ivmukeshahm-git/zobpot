<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $permissions = [
            'CollegeDashboard-View',
            'CollegeInternship-View',
            'CollegeInternship-ViewStudents',
            'CollegeInternship-AssignStaff',
            'CollegeStudents-View',
            'CollegeStudents-ViewProfile',
            'CollegeStaff-View',
            'CollegeStaff-Add',
            'CollegeStaff-Edit',
            'CollegeStaff-Delete',
            'CollegeRoles-View',
            'CollegeRoles-Add',
            'CollegeRoles-Edit',
            'CollegeRoles-Delete',
        ];

        $now = now();
        foreach ($permissions as $perm) {
            DB::table('permissions')->insertOrIgnore([
                'name' => $perm,
                'guard_name' => 'college_staff',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down()
    {
        DB::table('permissions')->where('guard_name', 'college_staff')->delete();
    }
};
