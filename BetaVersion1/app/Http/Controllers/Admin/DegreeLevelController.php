<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DegreeLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DegreeLevelController extends Controller
{
    public function index()
    {
        return view('admin.degrees.degree-level');
    }

    public function getData(Request $request)
    {
        $data = DegreeLevel::orderBy('created_at', 'desc');

        if ($request->has('approve_status') && $request->approve_status !== '') {
            $data->where('approve_status', $request->approve_status);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d F Y') : '';
            })
            ->addColumn('action', function ($row) {
                $user = auth()->user();
                $btn = '';

                if ($row->approve_status == 0) {
                    if ($user->can('Degree_Level-Approve')) { $btn .= '<button type="button" class="btn-approve btn-sm" onclick="openApproveModal(' . $row->degree_level_id . ', \'' . addslashes($row->degree_level_name) . '\')"><i class="bx bx-check"></i></button>'; }
                    if ($user->can('Degree_Level-Reject')) { $btn .= '<button type="button" class="btn-reject btn-sm" onclick="openRejectModal(' . $row->degree_level_id . ', \'' . addslashes($row->degree_level_name) . '\')"><i class="bx bx-x"></i></button>'; }
                    return $btn;
                }

                if ($row->approve_status == 1) {
                    if ($user->can('Degree_Level-Edit')) { $btn .= '<button type="button" class="btn btn-primary btn-sm me-1" onclick="editItem(' . $row->degree_level_id . ')"><i class="bx bx-edit"></i></button>'; }
                    if ($user->can('Degree_Level-Reject')) { $btn .= '<button type="button" class="btn-reject btn-sm me-1" onclick="openRejectModal(' . $row->degree_level_id . ', \'' . addslashes($row->degree_level_name) . '\')"><i class="bx bx-x"></i></button>'; }
                    if ($user->can('Degree_Level-Delete')) { $btn .= '<button type="button" class="btn-reject btn-sm" onclick="deleteItem(' . $row->degree_level_id . ')"><i class="bx bx-trash"></i></button>'; }
                    return $btn;
                }

                if ($user->can('Degree_Level-Edit')) { $btn .= '<button type="button" class="btn btn-primary btn-sm me-1" onclick="editItem(' . $row->degree_level_id . ')"><i class="bx bx-edit"></i></button>'; }
                if ($user->can('Degree_Level-Approve')) { $btn .= '<button type="button" class="btn-approve btn-sm me-1" onclick="openApproveModal(' . $row->degree_level_id . ', \'' . addslashes($row->degree_level_name) . '\')"><i class="bx bx-check"></i></button>'; }
                if ($user->can('Degree_Level-Delete')) { $btn .= '<button type="button" class="btn-reject btn-sm" onclick="deleteItem(' . $row->degree_level_id . ')"><i class="bx bx-trash"></i></button>'; }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function details($id)
    {
        $degreeLevel = DegreeLevel::with(['degrees.majors'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $degreeLevel]);
    }

    public function approve(Request $request, $id)
    {
        $degreeLevel = DegreeLevel::findOrFail($id);

        // Approve degree level
        $degreeLevel->approve_status = 1;
        $degreeLevel->reject_reason = null;
        $degreeLevel->save();

        // Approve degrees (if provided)
        if ($request->has('degree_ids') && is_array($request->degree_ids)) {
            \App\Models\Degree::whereIn('degree_id', $request->degree_ids)->update(['approve_status' => 1, 'reject_reason' => null]);
        }

        // Approve majors (if provided)
        if ($request->has('major_ids') && is_array($request->major_ids)) {
            \App\Models\Major::whereIn('major_id', $request->major_ids)->update(['approve_status' => 1, 'reject_reason' => null]);
        }

        return response()->json(['success' => true, 'message' => 'Degree Level and selected items approved successfully.']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([ 'reject_reason' => 'required|string' ]);
        $degreeLevel = DegreeLevel::findOrFail($id);
        $degreeLevel->approve_status = 2;
        $degreeLevel->reject_reason = $request->reject_reason;
        $degreeLevel->save();

        return response()->json(['success' => true, 'message' => 'Degree Level rejected.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'degree_level_name' => 'required|string|max:255|unique:tbl_degree_level,degree_level_name',
        ]);

        DegreeLevel::create([
            'degree_level_name' => $request->degree_level_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Degree Level created successfully!']);
    }

    public function edit($id)
    {
        $degreeLevel = DegreeLevel::findOrFail($id);
        return response()->json(['success' => true, 'data' => $degreeLevel]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'degree_level_name' => 'required|string|max:255|unique:tbl_degree_level,degree_level_name,' . $id . ',degree_level_id',
        ]);

        $degreeLevel = DegreeLevel::findOrFail($id);
        $degreeLevel->update([
            'degree_level_name' => $request->degree_level_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Degree Level updated successfully!']);
    }

    public function destroy($id)
    {
        $degreeLevel = DegreeLevel::findOrFail($id);
        $degreeLevel->delete();

        return response()->json(['success' => true, 'message' => 'Degree Level deleted successfully!']);
    }
}
