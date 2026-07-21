<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Insert permission for web guard if not exists
        $exists = DB::table('permissions')->where('name', 'Assign-Internship')->where('guard_name', 'web')->exists();
        if (! $exists) {
            DB::table('permissions')->insert([
                'name' => 'Assign-Internship',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        DB::table('permissions')->where('name', 'Assign-Internship')->where('guard_name', 'web')->delete();
    }
};
