<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobCategory;
use App\Models\Jobsubcategory;
use App\Models\Skills;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\StaffActivityController;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Category = JobCategory::get();
        return view('admin.skill.skill', compact('Category'));
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Skills::select([
                'tbl_skills.id',
                'tbl_skills.category_id',
                'tbl_skills.sub_category_id',
                'tbl_skills.skill_nm',
                'tbl_job_category.category_nm',
                'tbl_sub_category.sub_category_nm'
            ])
                ->join('tbl_job_category', 'tbl_job_category.category_id', '=', 'tbl_skills.category_id')
                ->join('tbl_sub_category', 'tbl_sub_category.sub_category_id', '=', 'tbl_skills.sub_category_id');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('skills', function ($row) {
                    $skills = explode(',', $row->skill_nm);
                    $badges = '';
                    foreach ($skills as $skill) {
                        $badges .= '<span class="badge bg-secondary me-2 mb-2">' . trim($skill) . '</span>';
                    }
                    return $badges;
                })
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('Skills-Edit')) {
                        $actions .= '
           <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>
        ';
                    }

                    if (auth()->user()->can('Skills-Delete')) {
                        $actions .= '
             <button type="button" class="btn delete-skill-btn btn-sm rounded-pill btn-icon btn-danger">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('category_nm', function ($query, $keyword) {
                    $query->where('tbl_job_category.category_nm', 'like', "%$keyword%");
                })
                ->filterColumn('sub_category_nm', function ($query, $keyword) {
                    $query->where('tbl_sub_category.sub_category_nm', 'like', "%$keyword%");
                })
                ->filterColumn('skills', function ($query, $keyword) {
                    $query->where('tbl_skills.skill_nm', 'like', "%$keyword%");
                })
                ->rawColumns(['skills', 'action']) // tell DataTables these columns have HTML
                ->make(true);
        }

        return abort(403, 'Unauthorized access.');
    }

    public function get_sub_category(Request $request)
    {
        $category_id = $request->input('category_id');

        // Fetch all subcategories where category_id matches
        $subcategories = Jobsubcategory::where('category_id', $category_id)->get();

        if ($subcategories->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No subcategories found for this category.'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Subcategories fetched successfully.',
            'data' => $subcategories
        ], 200);
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
        $validated = $request->validate([
            'category_id'     => 'required|exists:tbl_job_category,category_id',
            'sub_category_id' => 'required|exists:tbl_sub_category,sub_category_id',
            'skills'          => 'required', // can be string or array
        ]);

        try {
            $category_id = $validated['category_id'];
            $sub_category_id = $validated['sub_category_id'];
            $skills = $request->input('skills');

            // If it's an array (from a multi-select or checkboxes), implode into comma string
            if (is_array($skills)) {
                $skills = implode(',', array_map('trim', $skills));
            }
            if (is_string($skills)) {
                $skills = trim($skills);
            }

            $insertedSkill = Skills::create([
                'category_id'     => $category_id,
                'sub_category_id' => $sub_category_id,
                'skill_nm'        => $skills, // this will now be a proper string
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Skills Added Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Skills saved successfully.',
                'data'    => $insertedSkill
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to save skills.',
                'error'   => $e->getMessage()
            ], 500);
        }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id'     => 'required|exists:tbl_job_category,category_id',
            'sub_category_id' => 'required|exists:tbl_sub_category,sub_category_id',
            'skills'          => 'required', // can be string or array
        ]);

        try {
            $category_id     = $request->input('category_id');
            $sub_category_id = $request->input('sub_category_id');
            $skills          = $request->input('skills');

            // If it's an array, convert to string
            if (is_array($skills)) {
                $skills = implode(',', array_map('trim', $skills));
            }

            if (is_string($skills)) {
                $skills = trim($skills);
            }

            // Find the existing record
            $skill = Skills::findOrFail($id);

            // Update fields
            $skill->update([
                'category_id'     => $category_id,
                'sub_category_id' => $sub_category_id,
                'skill_nm'        => $skills,
            ]);

            
            StaffActivityController::insertActivity(Auth::user()->id, 'Skills Update Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Skills updated successfully.',
                'data'    => $skill
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to update skills.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Skills = Skills::findOrFail($id);

        if (!$Skills) {
            return response()->json([
                'status' => 0,
                'message' => 'Skill not found.',
            ]);
        }

        $Skills->delete(); // If using soft deletes, this marks it deleted

        StaffActivityController::insertActivity(Auth::user()->id, 'Skills Delete Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Skill deleted successfully.',
        ]);
    }
}
