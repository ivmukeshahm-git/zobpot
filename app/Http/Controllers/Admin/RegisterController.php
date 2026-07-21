<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Registration;

use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{

    public function TodaySkillthonRegisterList(Request $request)
    {
        if ($request->ajax()) {

            $query = Registration::where('type', 1)
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('phone_no', function ($row) {
                    return $row->phone_no;
                })

                ->addColumn('degree', function ($row) {
                    return $row->degree;
                })

                ->addColumn('city', function ($row) {
                    return $row->city; // static / or dynamic
                })

                // ->addColumn('action', function ($row) {
                //     return '
                //         <button class="btn btn-sm btn-primary viewBtn"
                //             data-id="'.$row->id.'">
                //             View
                //         </button>
                //     ';
                // })

                // ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function TodayInternshipRegisterList(Request $request)
    {
        if ($request->ajax()) {

            $query = Registration::where('type', 2)
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('phone_no', function ($row) {
                    return $row->phone_no;
                })

                ->addColumn('degree', function ($row) {
                    return $row->degree;
                })

                ->addColumn('city', function ($row) {
                    return $row->city; // static / or dynamic
                })

                // ->addColumn('action', function ($row) {
                //     return '
                //         <button class="btn btn-sm btn-primary viewBtn"
                //             data-id="'.$row->id.'">
                //             View
                //         </button>
                //     ';
                // })

                // ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function skillthonIndex()
    {
        return view('admin.register.skillthon');
    }

    public function SkillthonRegisterList(Request $request)
    {
        if ($request->ajax()) {

            $query = Registration::where('type', 1) // Skillthon
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('name', function ($row) {
                    return $row->name;
                })

                ->addColumn('email', function ($row) {
                    return $row->email;
                })

                ->addColumn('phone_no', function ($row) {
                    return $row->phone_no;
                })

                ->addColumn('city', function ($row) {
                    return $row->city ?? '-';
                })

                ->addColumn('pincode', function ($row) {
                    return $row->pincode ?? '-';
                })

                ->addColumn('university', function ($row) {
                    return $row->university ?? '-';
                })

                ->addColumn('degree', function ($row) {
                    return $row->degree ?? '-';
                })

                ->addColumn('gender', function ($row) {
                    if ($row->gender == 1) {
                        return '<span class="badge bg-primary">Male</span>';
                    } elseif ($row->gender == 2) {
                        return '<span class="badge bg-pink">Female</span>';
                    } else {
                        return '<span class="badge bg-secondary">Other</span>';
                    }
                })


                ->addColumn('status', function ($row) {

                $class = $row->status == 0 ? 'status-pending'
                    : ($row->status == 1 ? 'status-complete'
                    : 'status-cancel');

                return '
                    <select class="form-select form-select-sm changeStatus '.$class.'"
                        data-id="'.$row->id.'">
                        <option value="0" '.($row->status == 0 ? 'selected' : '').'>Pending</option>
                        <option value="1" '.($row->status == 1 ? 'selected' : '').'>Complete</option>
                        <option value="2" '.($row->status == 2 ? 'selected' : '').'>Cancel</option>
                    </select>
                ';
            })


                ->rawColumns(['status', 'gender'])
                ->make(true);
        }
    }
    public function updateSkillthonStatus(Request $request)
    {
        Registration::where('id', $request->id)
            ->update(['status' => $request->status]);

        return response()->json([
            'status' => 1,
            'message' => 'Status updated'
        ]);
    }


    public function InternshipIndex()
    {
        return view('admin.register.internship');
    }

    public function InternshipRegisterList(Request $request)
        {
        if ($request->ajax()) {

            $query = Registration::where('type', 2) // Internship
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('name', function ($row) {
                    return $row->name;
                })

                ->addColumn('email', function ($row) {
                    return $row->email;
                })

                ->addColumn('phone_no', function ($row) {
                    return $row->phone_no;
                })

                ->addColumn('city', function ($row) {
                    return $row->city ?? '-';
                })

                ->addColumn('pincode', function ($row) {
                    return $row->pincode ?? '-';
                })

                ->addColumn('university', function ($row) {
                    return $row->university ?? '-';
                })

                ->addColumn('degree', function ($row) {
                    return $row->degree ?? '-';
                })

                ->addColumn('gender', function ($row) {
                    if ($row->gender == 1) {
                        return '<span class="badge bg-primary">Male</span>';
                    } elseif ($row->gender == 2) {
                        return '<span class="badge bg-pink">Female</span>';
                    } else {
                        return '<span class="badge bg-secondary">Other</span>';
                    }
                })


                ->addColumn('status', function ($row) {

                    $class = $row->status == 0 ? 'status-pending'
                        : ($row->status == 1 ? 'status-complete'
                        : 'status-cancel');

                    return '
                        <select class="form-select form-select-sm changeStatus '.$class.'"
                            data-id="'.$row->id.'">
                            <option value="0" '.($row->status == 0 ? 'selected' : '').'>Pending</option>
                            <option value="1" '.($row->status == 1 ? 'selected' : '').'>Complete</option>
                            <option value="2" '.($row->status == 2 ? 'selected' : '').'>Cancel</option>
                        </select>
                    ';
                })


                ->rawColumns(['status','gender'])
                ->make(true);
        }
    }

    public function updateInternshipStatus(Request $request)
    {
        Registration::where('id', $request->id)
            ->update(['status' => $request->status]);

        return response()->json([
            'status' => 1,
            'message' => 'Status updated'
        ]);
    }



}
