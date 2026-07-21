<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Grade;
use App\Models\GradeSection;
use App\Models\GradeCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ManageGradeController extends Controller
{
    /** Returns true if the request is from a college or college_staff guard */
    private function isCollegeLogin(): bool
    {
        return auth()->guard('college')->check() || auth()->guard('college_staff')->check();
    }

    /** Returns the authenticated college's primary ID (tbl_college.id) */
    private function getCollegeId(): ?int
    {
        if (auth()->guard('college')->check()) {
            return auth()->guard('college')->user()->id ?? null;
        }
        if (auth()->guard('college_staff')->check()) {
            return auth()->guard('college_staff')->user()->college_id ?? null;
        }
        return null;
    }
    /**
     * Display college list for grade management
     */
    public function index()
    {
        if ($this->isCollegeLogin()) {
            // college_staff: check ManageGrade-View permission
            if (auth()->guard('college_staff')->check()) {
                abort_unless(
                    auth()->guard('college_staff')->user()->can('ManageGrade-View'),
                    403, 'You do not have permission to manage grades.'
                );
            }
            $collegeId = $this->getCollegeId();
            abort_if(!$collegeId, 403, 'College not found.');
            // Redirect directly to their college grade page
            return redirect()->route('admin.manage-grade.add', $collegeId);
        }

        // Super admin: require Manage_Grade-Add permission
        abort_unless(auth()->user()->can('Manage_Grade-Add'), 403);

        $colleges = College::with('university')
            ->select('id', 'college_name', 'university_id', 'city', 'state', 'email', 'phone')
            ->where('status', 1)
            ->orderBy('college_name', 'asc')
            ->get();

        $this->logActivity('Accessed Manage Grade page');

        return view('admin.manage-grade.index', compact('colleges'));
    }

    /**
     * Show the add grade form for a specific college
     */
    public function add($id)
    {
        if ($this->isCollegeLogin()) {
            if (auth()->guard('college_staff')->check()) {
                abort_unless(
                    auth()->guard('college_staff')->user()->can('ManageGrade-View'),
                    403, 'You do not have permission to manage grades.'
                );
            }
            $collegeId = $this->getCollegeId();
            abort_if((int)$id !== (int)$collegeId, 403, 'Access denied.');
        } else {
            abort_unless(auth()->user()->can('Manage_Grade-Add'), 403);
        }

        $college = College::findOrFail($id);
        
        // Fetch only degrees selected for this college (stored in degree_ids JSON column)
        $degreeIds = $college->degree_ids ?? [];
        if (!is_array($degreeIds)) {
            $degreeIds = json_decode($degreeIds, true) ?: [];
        }
        $degreeIds = array_filter($degreeIds);

        if (empty($degreeIds)) {
            // No configured degrees for this college — return empty collection so dropdown shows only placeholder
            $courses = collect();
        } else {
            $courses = DB::table('tbl_degree')
                ->select('degree_id', 'degree_name')
                ->whereIn('degree_id', $degreeIds)
                ->whereNull('deleted_at')
                ->orderBy('degree_name', 'asc')
                ->get();
        }

        // Log activity
        $this->logActivity('Opened add grade form for college ID: ' . $id);

        return view('admin.manage-grade.add', compact('college', 'courses'));
    }

    /**
     * Fetch existing grade data for a college and course
     */
    public function fetchGradeData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'college_id' => 'required|integer|exists:tbl_college,id',
            'course_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if grade exists for this college and course
            $grade = Grade::with(['sections.criteria', 'criteria'])
                ->where('college_id', $request->college_id)
                ->where('course_id', $request->course_id)
                ->first();

            if (!$grade) {
                return response()->json([
                    'success' => false,
                    'message' => 'No existing grade data found'
                ]);
            }

            // Format the data for frontend
            $sections = [];
            foreach ($grade->sections as $section) {
                $sections[] = [
                    'id' => $section->id,
                    'title' => $section->title,
                    'marks' => $section->marks,
                ];
            }

            $criteria = [];
            foreach ($grade->criteria as $criterion) {
                $criteria[] = [
                    'id' => $criterion->id,
                    'section_id' => $criterion->section_id,
                    'title' => $criterion->title,
                    'marks' => $criterion->marks,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'grade_id' => $grade->id,
                    'total_marks' => $grade->total_marks,
                    'sections' => $sections,
                    'criteria' => $criteria,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch grade data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update grade configuration
     */
    public function store(Request $request)
    {
        if ($this->isCollegeLogin()) {
            if (auth()->guard('college_staff')->check()) {
                abort_unless(
                    auth()->guard('college_staff')->user()->can('ManageGrade-View'),
                    403, 'You do not have permission to manage grades.'
                );
            }
            $collegeId = $this->getCollegeId();
            abort_if((int)$request->college_id !== (int)$collegeId, 403, 'Access denied.');
        } else {
            abort_unless(auth()->user()->can('Manage_Grade-Add'), 403);
        }

        $validator = Validator::make($request->all(), [
            'grade_id' => 'nullable|integer|exists:grades,id',
            'college_id' => 'required|integer|exists:tbl_college,id',
            'course_id' => 'required|integer',
            'total_marks' => 'required|integer|min:1',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.marks' => 'required|integer|min:1',
            'criteria' => 'nullable|array',
            'criteria.*.section_index' => 'required|integer',
            'criteria.*.title' => 'required|string|max:255',
            'criteria.*.marks' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Check if updating existing grade
            if ($request->has('grade_id') && $request->grade_id) {
                $grade = Grade::findOrFail($request->grade_id);
                
                // Update grade record
                $grade->update([
                    'course_id' => $request->course_id,
                    'total_marks' => $request->total_marks,
                ]);

                // Delete existing sections and criteria
                $grade->criteria()->delete();
                $grade->sections()->delete();

                $logMessage = 'Updated grade configuration for college ID: ' . $request->college_id;
                $responseMessage = 'Grade updated successfully!';
            } else {
                // Create new grade record
                $grade = Grade::create([
                    'college_id' => $request->college_id,
                    'course_id' => $request->course_id,
                    'total_marks' => $request->total_marks,
                ]);

                $logMessage = 'Created grade configuration for college ID: ' . $request->college_id;
                $responseMessage = 'Grade created successfully!';
            }

            // Create/Recreate Grade Sections (Marks Entry)
            $sectionMap = []; // Map section index to section ID
            foreach ($request->sections as $index => $sectionData) {
                $section = GradeSection::create([
                    'grade_id' => $grade->id,
                    'title' => $sectionData['title'],
                    'marks' => $sectionData['marks'],
                ]);
                $sectionMap[$index] = $section->id;
            }

            // Create/Recreate Grade Criteria
            if ($request->has('criteria') && is_array($request->criteria)) {
                foreach ($request->criteria as $criterionData) {
                    $sectionIndex = $criterionData['section_index'];
                    if (isset($sectionMap[$sectionIndex])) {
                        GradeCriterion::create([
                            'grade_id' => $grade->id,
                            'section_id' => $sectionMap[$sectionIndex],
                            'title' => $criterionData['title'],
                            'marks' => $criterionData['marks'],
                        ]);
                    }
                }
            }

            DB::commit();

            // Log activity
            $this->logActivity($logMessage);

            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'grade_id' => $grade->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create grade: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show edit grade form
     */
    public function edit($id)
    {
        $grade = Grade::with(['sections.criteria'])->findOrFail($id);

        if ($this->isCollegeLogin()) {
            if (auth()->guard('college_staff')->check()) {
                abort_unless(
                    auth()->guard('college_staff')->user()->can('ManageGrade-View'),
                    403, 'You do not have permission to manage grades.'
                );
            }
            $collegeId = $this->getCollegeId();
            abort_if((int)$grade->college_id !== (int)$collegeId, 403, 'Access denied.');
        } else {
            abort_unless(auth()->user()->can('Manage_Grade-Add'), 403);
        }

        $college = College::findOrFail($grade->college_id);
        // Limit courses to those configured for this college
        $degreeIds = $college->degree_ids ?? [];
        if (!is_array($degreeIds)) {
            $degreeIds = json_decode($degreeIds, true) ?: [];
        }
        $degreeIds = array_filter($degreeIds);

        if (empty($degreeIds)) {
            $courses = collect();
        } else {
            $courses = DB::table('tbl_degree')
                ->select('degree_id', 'degree_name')
                ->whereIn('degree_id', $degreeIds)
                ->whereNull('deleted_at')
                ->orderBy('degree_name', 'asc')
                ->get();
        }

        // Log activity
        $this->logActivity('Opened edit grade form for configuration ID: ' . $id);

        return view('admin.manage-grade.edit', compact('grade', 'college', 'courses'));
    }

    /**
     * Update grade data
     */
    public function update(Request $request, $id)
    {
        if ($this->isCollegeLogin()) {
            if (auth()->guard('college_staff')->check()) {
                abort_unless(
                    auth()->guard('college_staff')->user()->can('ManageGrade-View'),
                    403, 'You do not have permission to manage grades.'
                );
            }
            // Verify the grade belongs to their college
            $gradeCheck = Grade::find($id);
            $collegeId = $this->getCollegeId();
            abort_if(!$gradeCheck || (int)$gradeCheck->college_id !== (int)$collegeId, 403, 'Access denied.');
        } else {
            abort_unless(auth()->user()->can('Manage_Grade-Add'), 403);
        }

        $validator = Validator::make($request->all(), [
            'course_id' => 'required|integer',
            'total_marks' => 'required|integer|min:1',
            'sections' => 'required|array|min:1',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.marks' => 'required|integer|min:1',
            'criteria' => 'nullable|array',
            'criteria.*.section_index' => 'required|integer',
            'criteria.*.title' => 'required|string|max:255',
            'criteria.*.marks' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $grade = Grade::findOrFail($id);

            // Update Grade Main Record
            $grade->update([
                'course_id' => $request->course_id,
                'total_marks' => $request->total_marks,
            ]);

            // Delete existing sections and criteria
            $grade->criteria()->delete();
            $grade->sections()->delete();

            // Recreate sections and criteria
            $sectionMap = [];
            foreach ($request->sections as $index => $sectionData) {
                $section = GradeSection::create([
                    'grade_id' => $grade->id,
                    'title' => $sectionData['title'],
                    'marks' => $sectionData['marks'],
                ]);
                $sectionMap[$index] = $section->id;
            }

            if ($request->has('criteria') && is_array($request->criteria)) {
                foreach ($request->criteria as $criterionData) {
                    $sectionIndex = $criterionData['section_index'];
                    if (isset($sectionMap[$sectionIndex])) {
                        GradeCriterion::create([
                            'grade_id' => $grade->id,
                            'section_id' => $sectionMap[$sectionIndex],
                            'title' => $criterionData['title'],
                            'marks' => $criterionData['marks'],
                        ]);
                    }
                }
            }

            DB::commit();

            // Log activity
            $this->logActivity('Updated grade configuration ID: ' . $id);

            return response()->json([
                'success' => true,
                'message' => 'Grade updated successfully!',
                'grade_id' => $grade->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update grade: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete grade
     */
    public function delete($id)
    {
        try {
            $grade = Grade::findOrFail($id);

            if ($this->isCollegeLogin()) {
                $collegeId = $this->getCollegeId();
                abort_if((int)$grade->college_id !== (int)$collegeId, 403, 'Access denied.');
            } else {
                abort_unless(auth()->user()->can('Manage_Grade-Add'), 403);
            }
            $grade->delete();

            // Log activity
            $this->logActivity('Deleted grade configuration ID: ' . $id);

            return response()->json([
                'success' => true,
                'message' => 'Grade deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete grade: ' . $e->getMessage()
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
