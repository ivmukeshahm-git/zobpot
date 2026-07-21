<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManageGradeController extends Controller
{
    /**
     * Display the manage grade listing page
     */
    public function index()
    {
        // In production, fetch colleges from database
        // $colleges = DB::table('colleges')
        //     ->join('universities', 'colleges.university_id', '=', 'universities.id')
        //     ->select('colleges.*', 'universities.name as university_name')
        //     ->orderBy('colleges.name', 'asc')
        //     ->get();

        // Log activity
        $this->logActivity('Accessed Manage Grade page');

        return view('admin.manage-grade.index');
    }

    /**
     * Show the add grade form for a specific college
     */
    public function addGrade($id)
    {
        // In production, fetch college details
        // $college = DB::table('colleges')
        //     ->join('universities', 'colleges.university_id', '=', 'universities.id')
        //     ->where('colleges.id', $id)
        //     ->select('colleges.*', 'universities.name as university_name')
        //     ->first();

        // if (!$college) {
        //     return redirect()->route('admin.manage-grade.index')
        //         ->with('error', 'College not found');
        // }

        // Fetch existing grade configuration if any
        // $existingGrade = DB::table('grade_configurations')
        //     ->where('college_id', $id)
        //     ->first();

        // Log activity
        $this->logActivity('Opened add grade form for college ID: ' . $id);

        return view('admin.manage-grade.add-grade', [
            'college_id' => $id
        ]);
    }

    /**
     * Store grade configuration
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'college_id' => 'required|integer',
                'course_id' => 'required|string',
                'total_marks' => 'required|numeric|min:0',
                'marks_sections' => 'required|array|min:1',
                'grade_criteria' => 'required|array|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // In production, save to database
            // DB::beginTransaction();

            // try {
            //     // Save main grade configuration
            //     $gradeConfig = DB::table('grade_configurations')->insertGetId([
            //         'college_id' => $request->college_id,
            //         'course_id' => $request->course_id,
            //         'total_marks' => $request->total_marks,
            //         'created_by' => Auth::id(),
            //         'created_at' => now(),
            //         'updated_at' => now()
            //     ]);

            //     // Save marks sections
            //     foreach ($request->marks_sections as $section) {
            //         DB::table('grade_marks_sections')->insert([
            //             'grade_config_id' => $gradeConfig,
            //             'title' => $section['title'],
            //             'marks' => $section['marks'],
            //             'created_at' => now(),
            //             'updated_at' => now()
            //         ]);
            //     }

            //     // Save grade criteria
            //     foreach ($request->grade_criteria as $criterion) {
            //         DB::table('grade_criteria')->insert([
            //             'grade_config_id' => $gradeConfig,
            //             'section_id' => $criterion['section_id'],
            //             'title' => $criterion['title'],
            //             'type' => $criterion['type'],
            //             'marks' => $criterion['marks'],
            //             'created_at' => now(),
            //             'updated_at' => now()
            //         ]);
            //     }

            //     DB::commit();

                // Log activity
                $this->logActivity('Created grade configuration for college ID: ' . $request->college_id);

                return response()->json([
                    'success' => true,
                    'message' => 'Grade configuration saved successfully'
                ]);

            // } catch (\Exception $e) {
            //     DB::rollback();
            //     throw $e;
            // }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving grade configuration: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the edit grade form
     */
    public function edit($id)
    {
        // In production, fetch grade configuration
        // $gradeConfig = DB::table('grade_configurations')
        //     ->where('id', $id)
        //     ->first();

        // if (!$gradeConfig) {
        //     return redirect()->route('admin.manage-grade.index')
        //         ->with('error', 'Grade configuration not found');
        // }

        // $marksSections = DB::table('grade_marks_sections')
        //     ->where('grade_config_id', $id)
        //     ->get();

        // $gradeCriteria = DB::table('grade_criteria')
        //     ->where('grade_config_id', $id)
        //     ->get();

        // Log activity
        $this->logActivity('Opened edit grade form for configuration ID: ' . $id);

        return view('admin.manage-grade.edit', [
            'grade_id' => $id
        ]);
    }

    /**
     * Update grade configuration
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|string',
                'total_marks' => 'required|numeric|min:0',
                'marks_sections' => 'required|array|min:1',
                'grade_criteria' => 'required|array|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // In production, update in database
            // DB::beginTransaction();

            // try {
            //     // Update main grade configuration
            //     DB::table('grade_configurations')
            //         ->where('id', $id)
            //         ->update([
            //             'course_id' => $request->course_id,
            //             'total_marks' => $request->total_marks,
            //             'updated_by' => Auth::id(),
            //             'updated_at' => now()
            //         ]);

            //     // Delete existing sections and criteria
            //     DB::table('grade_marks_sections')->where('grade_config_id', $id)->delete();
            //     DB::table('grade_criteria')->where('grade_config_id', $id)->delete();

            //     // Save new marks sections
            //     foreach ($request->marks_sections as $section) {
            //         DB::table('grade_marks_sections')->insert([
            //             'grade_config_id' => $id,
            //             'title' => $section['title'],
            //             'marks' => $section['marks'],
            //             'created_at' => now(),
            //             'updated_at' => now()
            //         ]);
            //     }

            //     // Save new grade criteria
            //     foreach ($request->grade_criteria as $criterion) {
            //         DB::table('grade_criteria')->insert([
            //             'grade_config_id' => $id,
            //             'section_id' => $criterion['section_id'],
            //             'title' => $criterion['title'],
            //             'type' => $criterion['type'],
            //             'marks' => $criterion['marks'],
            //             'created_at' => now(),
            //             'updated_at' => now()
            //         ]);
            //     }

            //     DB::commit();

                // Log activity
                $this->logActivity('Updated grade configuration ID: ' . $id);

                return response()->json([
                    'success' => true,
                    'message' => 'Grade configuration updated successfully'
                ]);

            // } catch (\Exception $e) {
            //     DB::rollback();
            //     throw $e;
            // }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating grade configuration: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log admin activity
     */
    private function logActivity($description)
    {
        try {
            DB::table('staff_activities')->insert([
                'user_id' => Auth::id(),
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail the main operation
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}
