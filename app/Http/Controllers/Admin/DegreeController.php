<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\DegreeLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DegreeController extends Controller
{
    public function index()
    {
        $degreeLevels = DegreeLevel::orderBy('degree_level_name')->get();
        return view('admin.degrees.degree', compact('degreeLevels'));
    }

    public function getData(Request $request)
    {
        $data = Degree::with('degreeLevel')->orderBy('created_at', 'desc');

        if ($request->has('approve_status') && $request->approve_status !== '') {
            $data->where('approve_status', $request->approve_status);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('degree_level_name', function ($row) {
                return $row->degreeLevel ? $row->degreeLevel->degree_level_name : 'N/A';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d F Y') : '';
            })
            ->addColumn('action', function ($row) {
                $user = auth()->user();
                $btn = '';
                if ($user->can('Degrees-Edit')) { $btn .= '<button type="button" class="btn btn-primary btn-sm me-1" onclick="editItem(' . $row->degree_id . ')"><i class="bx bx-edit"></i></button>'; }

                if ($row->approve_status == 0) {
                    if ($user->can('Degrees-Approve')) { $btn .= '<button type="button" class="btn-approve btn-sm me-1" onclick="openApproveModal(' . $row->degree_id . ', \'' . addslashes($row->degree_name) . '\')"><i class="bx bx-check"></i></button>'; }
                    if ($user->can('Degrees-Reject')) { $btn .= '<button type="button" class="btn-reject btn-sm me-1" onclick="openRejectModal(' . $row->degree_id . ', \'' . addslashes($row->degree_name) . '\')"><i class="bx bx-x"></i></button>'; }
                } elseif ($row->approve_status == 1) {
                    if ($user->can('Degrees-Reject')) { $btn .= '<button type="button" class="btn-reject btn-sm me-1" onclick="openRejectModal(' . $row->degree_id . ', \'' . addslashes($row->degree_name) . '\')"><i class="bx bx-x"></i></button>'; }
                } else {
                    if ($user->can('Degrees-Approve')) { $btn .= '<button type="button" class="btn-approve btn-sm me-1" onclick="openApproveModal(' . $row->degree_id . ', \'' . addslashes($row->degree_name) . '\')"><i class="bx bx-check"></i></button>'; }
                }

                if ($user->can('Degrees-Delete')) { $btn .= '<button type="button" class="btn-reject btn-sm" onclick="deleteItem(' . $row->degree_id . ')"><i class="bx bx-trash"></i></button>'; }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function approve($id)
    {
        $degree = Degree::findOrFail($id);
        $degree->approve_status = 1;
        $degree->reject_reason = null;
        $degree->save();

        // If majors selected, approve those majors as well
        if (request()->has('major_ids') && is_array(request()->major_ids) && count(request()->major_ids)) {
            \App\Models\Major::whereIn('major_id', request()->major_ids)->update(['approve_status' => 1, 'reject_reason' => null]);
        }

        return response()->json(['success' => true, 'message' => 'Degree approved successfully.']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([ 'reject_reason' => 'required|string' ]);
        $degree = Degree::findOrFail($id);
        $degree->approve_status = 2;
        $degree->reject_reason = $request->reject_reason;
        $degree->save();

        return response()->json(['success' => true, 'message' => 'Degree rejected.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'degree_level_id' => 'required|exists:tbl_degree_level,degree_level_id',
            'degree_name'     => 'required|string|max:255',
        ]);

        Degree::create([
            'degree_level_id' => $request->degree_level_id,
            'degree_name'     => $request->degree_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Degree created successfully!']);
    }

    public function edit($id)
    {
        $degree = Degree::findOrFail($id);
        return response()->json(['success' => true, 'data' => $degree]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'degree_level_id' => 'required|exists:tbl_degree_level,degree_level_id',
            'degree_name'     => 'required|string|max:255',
        ]);

        $degree = Degree::findOrFail($id);
        $degree->update([
            'degree_level_id' => $request->degree_level_id,
            'degree_name'     => $request->degree_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Degree updated successfully!']);
    }

    public function destroy($id)
    {
        $degree = Degree::findOrFail($id);
        $degree->delete();

        return response()->json(['success' => true, 'message' => 'Degree deleted successfully!']);
    }

    public function getDegreesByLevel(Request $request)
    {
        $degrees = Degree::where('degree_level_id', $request->degree_level_id)
            ->orderBy('degree_name')
            ->get(['degree_id', 'degree_name']);

        return response()->json(['success' => true, 'data' => $degrees]);
    }

   public function getAllDegrees()
    {
        $degrees = Degree::orderBy('degree_name')
            ->get(['degree_id', 'degree_name']);

        return response()->json(['success' => true, 'data' => $degrees]);
    }

    public function details($id)
    {
        $degree = Degree::with('majors')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $degree]);
    }
}
