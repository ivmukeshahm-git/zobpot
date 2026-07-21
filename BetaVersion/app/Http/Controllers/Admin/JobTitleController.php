<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobTitle;

class JobTitleController extends Controller
{
    /**
     * Display a listing of job titles.
     */
    public function index()
    {
        $data = JobTitle::orderBy('id', 'DESC')->get();
        return view('admin.jobtitle.index', compact('data'));
    }

    /**
     * Store a newly created title.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_name' => 'nullable|string|max:255'
        ]);

        JobTitle::create([
            'title_name' => $request->title_name
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Job Title Added Successfully'
        ]);
    }

    /**
     * Fetch single row for edit.
     */
    public function edit($id)
    {
        $row = JobTitle::find($id);

        if (!$row) {
            return response()->json(['status' => 0, 'message' => 'Title not found']);
        }

        return response()->json(['status' => 1, 'data' => $row]);
    }

    /**
     * Update the title.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title_name' => 'nullable|string|max:255'
        ]);

        $row = JobTitle::find($id);

        if (!$row) {
            return response()->json([
                'status' => 0,
                'message' => 'Title not found'
            ]);
        }

        $row->update([
            'title_name' => $request->title_name
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Job Title Updated Successfully'
        ]);
    }
    public function GetTableData(Request $request)
    {
        $data = JobTitle::orderBy('title_name', 'ASC');

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-warning rounded-pill btn-icon  edit-title-btn me-1">
                        <i class="tf-icons bx bx-edit-alt bx-18px"></i>
                    </button>
                    <button class="btn btn-sm btn-danger rounded-pill btn-icon delete-title-btn">
                        <i class="tf-icons bx bx-trash bx-18px"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }



    /**
     * Soft delete the title.
     */
    public function destroy($id)
    {
        $row = JobTitle::find($id);

        if (!$row) {
            return response()->json([
                'status' => 0,
                'message' => 'Title not found'
            ]);
        }

        $row->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Job Title Deleted Successfully'
        ]);
    }
}
