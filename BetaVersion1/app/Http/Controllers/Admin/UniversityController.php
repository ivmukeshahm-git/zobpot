<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UniversityController extends Controller
{
    public function index()
    {
        return view('admin.university.index');
    }

    public function getData(Request $request)
    {
        $status = (int) $request->get('status', 0);

        $data = University::where('status', $status)->orderBy('created_at', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d M Y') : '';
            })
            ->addColumn('reject_reason', function ($row) {
                return $row->reject_reason ?? '';
            })
            ->addColumn('action', function ($row) use ($status) {
                $user = auth()->user();
                $actions = '';
                if ($status == 0) {
                    if ($user->can('University-Approve')) { $actions .= '<button class="btn btn-approve" onclick="approveUniversity(' . $row->id . ', \'' . addslashes(e($row->university_name)) . '\')"><i class="bx bx-check"></i> Approve</button>'; }
                    if ($user->can('University-Reject')) { $actions .= '<button class="btn btn-reject" onclick="rejectUniversity(' . $row->id . ', \'' . addslashes(e($row->university_name)) . '\')"><i class="bx bx-x"></i> Reject</button>'; }
                    if ($user->can('University-Delete')) { $actions .= '<button class="btn btn-action btn-delete" onclick="deleteUniversity(' . $row->id . ')"><i class="bx bx-trash"></i> Delete</button>'; }
                } elseif ($status == 1) {
                    if ($user->can('University-Edit')) { $actions .= '<button class="btn btn-action btn-edit" onclick="editUniversity(' . $row->id . ')"><i class="bx bx-edit"></i> Edit</button>'; }
                    if ($user->can('University-Delete')) { $actions .= '<button class="btn btn-action btn-delete" onclick="deleteUniversity(' . $row->id . ')"><i class="bx bx-trash"></i> Delete</button>'; }
                } elseif ($status == 2) {
                    if ($user->can('University-Approve')) { $actions .= '<button class="btn btn-approve" onclick="approveUniversity(' . $row->id . ', \'' . addslashes(e($row->university_name)) . '\')"><i class="bx bx-check"></i> Approve</button>'; }
                    if ($user->can('University-Delete')) { $actions .= '<button class="btn btn-action btn-delete" onclick="deleteUniversity(' . $row->id . ')"><i class="bx bx-trash"></i> Delete</button>'; }
                }
                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'university_name' => 'required|string|max:255|unique:tbl_university,university_name',
            'status' => 'required|in:0,1,2',
        ]);

        University::create([
            'university_name' => $request->university_name,
            'status' => (int) $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'University created successfully!']);
    }

    public function edit($id)
    {
        $university = University::findOrFail($id);
        return response()->json(['success' => true, 'data' => $university]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'university_name' => 'required|string|max:255|unique:tbl_university,university_name,' . $id,
        ]);

        $university = University::findOrFail($id);
        $university->update([
            'university_name' => $request->university_name,
        ]);

        return response()->json(['success' => true, 'message' => 'University updated successfully!']);
    }

    public function approve(Request $request, $id)
    {
        $university = University::findOrFail($id);
        $university->update([
            'status' => 1,
            'reject_reason' => null,
        ]);

        // Also approve selected colleges
        $collegeIds = $request->input('college_ids', []);
        if (!empty($collegeIds)) {
            \App\Models\College::whereIn('id', $collegeIds)
                ->where('university_id', $id)
                ->update(['status' => 1, 'reject_reason' => null]);
        }

        return response()->json(['success' => true, 'message' => 'University approved successfully!']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:1000',
        ]);

        $university = University::findOrFail($id);
        $university->update([
            'status' => 2,
            'reject_reason' => $request->reject_reason,
        ]);

        return response()->json(['success' => true, 'message' => 'University rejected successfully!']);
    }

    public function checkExists(Request $request)
    {
        $name = $request->get('university_name', '');
        $universityId = $request->get('university_id', '');
        $exists = University::where('university_name', $name)->where('status', 1)->exists();

        // Fetch colleges under this university
        $colleges = \App\Models\College::where('university_id', $universityId)
            ->orderBy('college_name')
            ->get(['id', 'college_name', 'status']);

        return response()->json([
            'exists' => $exists,
            'colleges' => $colleges,
        ]);
    }

    public function destroy($id)
    {
        $university = University::findOrFail($id);
        $university->delete();

        return response()->json(['success' => true, 'message' => 'University deleted successfully!']);
    }

    public function getAll()
    {
        $universities = University::where('status', 1)
            ->orderBy('university_name', 'asc')
            ->get(['id', 'university_name']);

        return response()->json(['success' => true, 'data' => $universities]);
    }

    public function replaceUniversity(Request $request, $id)
    {
        $request->validate([
            'replace_with_id' => 'required|exists:tbl_university,id',
        ]);

        $oldUniversity = University::findOrFail($id);
        $replaceWithId = $request->replace_with_id;
        $collegeIds = $request->input('college_ids', []);

        // Move all colleges from old university to replacement university
        \App\Models\College::where('university_id', $id)
            ->update(['university_id' => $replaceWithId]);

        // Approve selected colleges
        if (!empty($collegeIds)) {
            \App\Models\College::whereIn('id', $collegeIds)
                ->where('university_id', $replaceWithId)
                ->update(['status' => 1, 'reject_reason' => null]);
        }

        // Delete the old university
        $oldUniversity->delete();

        return response()->json(['success' => true, 'message' => 'University replaced and colleges transferred successfully!']);
    }
}
