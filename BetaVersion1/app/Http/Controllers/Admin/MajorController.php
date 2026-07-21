<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Degree;
use App\Models\DegreeLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MajorController extends Controller
{
    public function index()
    {
        $degreeLevels = DegreeLevel::orderBy('degree_level_name')->get();
        return view('admin.degrees.major', compact('degreeLevels'));
    }

    public function getData(Request $request)
    {
        $data = Major::with('degree.degreeLevel')->orderBy('created_at', 'desc');

        if ($request->has('approve_status') && $request->approve_status !== '') {
            $data->where('approve_status', $request->approve_status);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('degree_name', function ($row) {
                return $row->degree ? $row->degree->degree_name : 'N/A';
            })
            ->addColumn('degree_level_name', function ($row) {
                return $row->degree && $row->degree->degreeLevel
                    ? $row->degree->degreeLevel->degree_level_name : 'N/A';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d F Y') : '';
            })
            ->addColumn('action', function ($row) {
                $user = auth()->user();
                $btn = '';
                if ($user->can('Major-Edit')) { $btn .= '<button type="button" class="btn btn-primary btn-sm me-1" onclick="editItem(' . $row->major_id . ')"><i class="bx bx-edit"></i></button>'; }

                if ($row->approve_status == 0) {
                    if ($user->can('Major-Approve')) { $btn .= '<button type="button" class="btn-approve btn-sm me-1" onclick="openApproveModal(' . $row->major_id . ', \'' . addslashes($row->major_name) . '\')"><i class="bx bx-check"></i></button>'; }
                    if ($user->can('Major-Reject')) { $btn .= '<button type="button" class="btn-reject btn-sm me-1" onclick="openRejectModal(' . $row->major_id . ', \'' . addslashes($row->major_name) . '\')"><i class="bx bx-x"></i></button>'; }
                } elseif ($row->approve_status == 1) {
                    if ($user->can('Major-Reject')) { $btn .= '<button type="button" class="btn-reject btn-sm me-1" onclick="openRejectModal(' . $row->major_id . ', \'' . addslashes($row->major_name) . '\')"><i class="bx bx-x"></i></button>'; }
                } else {
                    if ($user->can('Major-Approve')) { $btn .= '<button type="button" class="btn-approve btn-sm me-1" onclick="openApproveModal(' . $row->major_id . ', \'' . addslashes($row->major_name) . '\')"><i class="bx bx-check"></i></button>'; }
                }

                if ($user->can('Major-Delete')) { $btn .= '<button type="button" class="btn-reject btn-sm" onclick="deleteItem(' . $row->major_id . ')"><i class="bx bx-trash"></i></button>'; }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function approve($id)
    {
        $major = Major::findOrFail($id);
        $major->approve_status = 1;
        $major->reject_reason = null;
        $major->save();

        return response()->json(['success' => true, 'message' => 'Major approved successfully.']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([ 'reject_reason' => 'required|string' ]);
        $major = Major::findOrFail($id);
        $major->approve_status = 2;
        $major->reject_reason = $request->reject_reason;
        $major->save();

        return response()->json(['success' => true, 'message' => 'Major rejected.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'degree_id'  => 'required|exists:tbl_degree,degree_id',
            'major_name' => 'required|string|max:255',
        ]);

        Major::create([
            'degree_id'  => $request->degree_id,
            'major_name' => $request->major_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Major created successfully!']);
    }

    public function edit($id)
    {
        $major = Major::with('degree')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $major]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'degree_id'  => 'required|exists:tbl_degree,degree_id',
            'major_name' => 'required|string|max:255',
        ]);

        $major = Major::findOrFail($id);
        $major->update([
            'degree_id'  => $request->degree_id,
            'major_name' => $request->major_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Major updated successfully!']);
    }

    public function destroy($id)
    {
        $major = Major::findOrFail($id);
        $major->delete();

        return response()->json(['success' => true, 'message' => 'Major deleted successfully!']);
    }

    public function getAllMajors()
    {
        $majors = Major::orderBy('major_name')
            ->get(['major_id', 'major_name']);

        return response()->json(['success' => true, 'data' => $majors]);
    }

    public function details($id)
    {
        $major = Major::with('degree')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $major]);
    }
}
