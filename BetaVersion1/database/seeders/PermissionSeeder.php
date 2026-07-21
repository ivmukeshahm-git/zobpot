<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Internship
            'Internship-Add',
            'Internship-Edit',
            'Internship-Delete',
            'Internship-Approve',
            'Internship-Reject',
            'Internship-View',

            // College
            'College-Add',
            'College-Edit',
            'College-Delete',
            'College-Approve',
            'College-Reject',
            'College-View',

            // University
            'University-Add',
            'University-Edit',
            'University-Delete',
            'University-Approve',
            'University-Reject',

            // Degree Level
            'Degree_Level-Add',
            'Degree_Level-Edit',
            'Degree_Level-Delete',
            'Degree_Level-Approve',
            'Degree_Level-Reject',

            // Degrees
            'Degrees-Add',
            'Degrees-Edit',
            'Degrees-Delete',
            'Degrees-Approve',
            'Degrees-Reject',

            // Major
            'Major-Add',
            'Major-Edit',
            'Major-Delete',
            'Major-Approve',
            'Major-Reject',

            // Dashboard
            'Dashboard-New_Internship_Requests',

            // Manage Grade
            'Manage_Grade-Add',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
