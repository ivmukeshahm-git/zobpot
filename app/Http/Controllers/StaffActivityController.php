<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffActivityController extends Controller
{
    public static function insertActivity($user_id,$msg)
    {
        DB::table('tbl_staff_activity')->insert([
            'user_id'      => $user_id,
            'msg'          => $msg,
            'current_path' => request()->fullUrl(),
            'datetime'     => now(),
        ]);
    }
}
