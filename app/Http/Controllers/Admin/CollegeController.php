<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Degree;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CollegeController extends Controller
{
    public function index()
    {
        $universities = University::where('status', 1)
            ->orderBy('university_name', 'asc')
            ->get(['id', 'university_name']);

        // Fetch all approved degrees for the multi-select dropdown
        $degrees = Degree::where('approve_status', 1)
            ->orderBy('degree_name', 'asc')
            ->get(['degree_id', 'degree_name']);

        return view('admin.college.index', compact('universities', 'degrees'));
    }

    public function getData(Request $request)
    {
        $status = (int) $request->get('status', 0);

        $data = College::with('university')->where('status', $status)->orderBy('created_at', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d M Y') : '';
            })
            ->addColumn('university_name', function ($row) {
                return $row->university ? $row->university->university_name : 'N/A';
            })
            ->addColumn('location', function ($row) {
                $parts = array_filter([$row->city, $row->state]);
                return implode(', ', $parts) ?: 'N/A';
            })
            ->addColumn('contact', function ($row) {
                $html = '<div style="font-size: 13px;">';
                if ($row->phone) {
                    $html .= '<div><i class="bx bx-phone"></i> ' . e($row->phone) . '</div>';
                }
                if ($row->email) {
                    $html .= '<div><i class="bx bx-envelope"></i> ' . e($row->email) . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('reject_reason', function ($row) {
                return $row->reject_reason ?? '';
            })
            ->addColumn('action', function ($row) use ($status) {
                $user = auth()->user();
                $actions = '';
                if ($status == 0) {
                    if ($user->can('College-View')) { $actions .= '<a href="' . url('admin/college-profile/' . $row->id) . '" class="btn btn-action btn-view btn-sm p-2"><i class="bx bx-show"></i></a>'; }
                    if ($user->can('College-Approve')) { $actions .= '<button class="btn btn-approve btn-sm p-2" onclick="approveCollege(' . $row->id . ')"><i class="bx bx-check"></i> Approve</button>'; }
                    if ($user->can('College-Reject')) { $actions .= '<button class="btn btn-reject btn-sm p-2" onclick="rejectCollege(' . $row->id . ')"><i class="bx bx-x"></i> Reject</button>'; }
                    if ($user->can('College-Delete')) { $actions .= '<button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(' . $row->id . ')"><i class="bx bx-trash"></i></button>'; }
                } elseif ($status == 1) {
                    if ($user->can('College-View')) { $actions .= '<a href="' . url('admin/college-profile/' . $row->id) . '" class="btn btn-action btn-view btn-sm p-2"><i class="bx bx-show"></i></a>'; }
                    if ($user->can('College-Edit')) { $actions .= '<button class="btn btn-action btn-edit btn-sm p-2" onclick="editCollege(' . $row->id . ')"><i class="bx bx-edit"></i></button>'; }
                    if ($user->can('College-Delete')) { $actions .= '<button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(' . $row->id . ')"><i class="bx bx-trash"></i></button>'; }
                } elseif ($status == 2) {
                    if ($user->can('College-Approve')) { $actions .= '<button class="btn btn-approve btn-sm p-2" onclick="approveCollege(' . $row->id . ')"><i class="bx bx-check"></i> Approve</button>'; }
                    if ($user->can('College-Delete')) { $actions .= '<button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(' . $row->id . ')"><i class="bx bx-trash"></i></button>'; }
                }
                return $actions;
            })
            ->rawColumns(['contact', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'college_name'   => 'required|string|max:255',
            'college_code'   => 'required|string|max:100',
            'university_id'  => 'required|integer|exists:tbl_university,id',
            'degree_ids'     => 'nullable|array',
            'degree_ids.*'   => 'integer|exists:tbl_degree,degree_id',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'pincode'        => 'required|string|max:10',
            'status'         => 'required|in:0,1,2',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'college_name'     => $request->college_name,
            'college_code'     => $request->college_code,
            'university_id'    => $request->university_id,
            // Cast in model handles JSON encoding automatically
            'degree_ids'       => $request->degree_ids ?? [],
            'email'            => $request->email,
            'phone'            => $request->phone,
            'website'          => $request->website,
            'established_year' => $request->established_year,
            'address'          => $request->address,
            'city'             => $request->city,
            'state'            => $request->state,
            'pincode'          => $request->pincode,
            'status'           => (int) $request->status,
            'role'             => 'College',
        ];

        if ($request->hasFile('logo')) {
            $logo     = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/college'), $logoName);
            $data['logo'] = 'uploads/college/' . $logoName;
        }

        College::create($data);

        return response()->json(['success' => true, 'message' => 'College created successfully!']);
    }

    public function show($id)
    {
        $college = College::with('university')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $college]);
    }

    public function edit($id)
    {
        $college = College::findOrFail($id);
        return response()->json(['success' => true, 'data' => $college]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'college_name'   => 'required|string|max:255',
            'college_code'   => 'required|string|max:100',
            'university_id'  => 'required|integer|exists:tbl_university,id',
            'degree_ids'     => 'nullable|array',
            'degree_ids.*'   => 'integer|exists:tbl_degree,degree_id',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'pincode'        => 'required|string|max:10',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $college = College::findOrFail($id);

        $data = [
            'college_name'     => $request->college_name,
            'college_code'     => $request->college_code,
            'university_id'    => $request->university_id,
            // Replace JSON array; cast in model handles encoding automatically
            'degree_ids'       => $request->degree_ids ?? [],
            'email'            => $request->email,
            'phone'            => $request->phone,
            'website'          => $request->website,
            'established_year' => $request->established_year,
            'address'          => $request->address,
            'city'             => $request->city,
            'state'            => $request->state,
            'pincode'          => $request->pincode,
            'role'             => 'College',
        ];

        if ($request->hasFile('logo')) {
            $logo     = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/college'), $logoName);
            $data['logo'] = 'uploads/college/' . $logoName;
        }

        $college->update($data);

        return response()->json(['success' => true, 'message' => 'College updated successfully!']);
    }

    public function approve(Request $request, $id)
    {
        $college = College::findOrFail($id);

        $updateData = [
            'status' => 1,
            'reject_reason' => null,
        ];

        // If email/password provided for college login credentials
        if ($request->filled('email')) {
            $updateData['email'] = $request->email;
        }

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $college->update($updateData);

        // Auto-approve the university if not already approved
        if ($college->university_id) {
            University::where('id', $college->university_id)
                ->where('status', '!=', 1)
                ->update(['status' => 1, 'reject_reason' => null]);
        }

        return response()->json(['success' => true, 'message' => 'College approved successfully!']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:1000',
        ]);

        $college = College::findOrFail($id);
        $college->update([
            'status' => 2,
            'reject_reason' => $request->reject_reason,
        ]);

        return response()->json(['success' => true, 'message' => 'College rejected successfully!']);
    }

    public function checkExists(Request $request)
    {
        $name = $request->get('college_name', '');
        $exists = College::where('college_name', $name)->where('status', 1)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function getAllColleges()
    {
        $colleges = College::with('university')
            ->where('status', 1)
            ->orderBy('college_name', 'asc')
            ->get(['id', 'college_name', 'university_id']);

        return response()->json(['data' => $colleges]);
    }

    public function replaceCollege(Request $request, $id)
    {
        $request->validate([
            'replace_with_id' => 'required|integer|exists:tbl_college,id',
        ]);

        $college = College::findOrFail($id);
        $oldUniversityId = $college->university_id;
        $replaceWith = College::with('university')->findOrFail($request->replace_with_id);

        // Update the current college's university_id to match the replacement college's university
        $college->update([
            'university_id' => $replaceWith->university_id,
        ]);

        // Delete the old college
        $college->delete();

        // Delete the old college's university
        if ($oldUniversityId) {
            University::where('id', $oldUniversityId)->delete();
        }

        return response()->json(['success' => true, 'message' => 'College replaced and old university deleted successfully!']);
    }

    public function destroy($id)
    {
        $college = College::findOrFail($id);
        $college->delete();

        return response()->json(['success' => true, 'message' => 'College deleted successfully!']);
    }
}
