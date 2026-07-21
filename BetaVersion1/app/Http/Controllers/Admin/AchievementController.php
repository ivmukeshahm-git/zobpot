<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\StaffActivityController;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AchievementData = Achievement::get();
        return view('admin.achievement.achievements', compact('AchievementData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update_achievements(Request $request)
    {
        $data = $request->input('achievements');

        if (!empty($data)) {
            foreach ($data as $item) {
                if (!empty($item['id'])) {
                    $achievement = Achievement::find($item['id']);
                    if ($achievement) {
                        $achievement->update([
                            'count' => $item['count'],
                            'title' => $item['title'],
                            'description' => $item['desc'],
                        ]);
                    }
                }
            }

            StaffActivityController::insertActivity(Auth::user()->id, 'Website Achievements updated successfully.');
            return response()->json([
                'status' => 1,
                'message' => 'Achievements updated successfully'
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'No data to update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
