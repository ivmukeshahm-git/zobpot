<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StaffActivityController;
use App\Models\InterviewTip;
use App\Models\InterviewTipPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TipsController extends Controller
{
    public function index()
    {
        return view('admin.interview-tips.index');
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = InterviewTip::select([
                    'id',
                    'main_header',
                    'short_line',
                    'footer_title',
                    'footer_description',
                    'status',
                    DB::raw('DATE(datetime) as add_date'),
                ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_text', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge rounded-pill bg-success">Published</span>';
                    }

                    return '<span class="badge rounded-pill bg-danger">Draft</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';

                    if (auth()->user() && auth()->user()->can('InterviewTips-Edit')) {
                        $buttons .= '
                    <button type="button" data-id="' . $row->id . '" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>';
                    }

                    if (auth()->user() && auth()->user()->can('InterviewTips-Delete')) {
                        $buttons .= '
                    <button type="button" data-id="' . $row->id . '" class="btn delete-interview-tips-btn btn-sm rounded-pill btn-icon btn-danger">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>';
                    }

                    return $buttons;
                })
                ->filterColumn('main_header', function ($query, $keyword) {
                    $query->where('main_header', 'like', "%$keyword%");
                })
                ->filterColumn('short_line', function ($query, $keyword) {
                    $query->where('short_line', 'like', "%$keyword%");
                })
                ->filterColumn('add_date', function ($query, $keyword) {
                    $query->whereRaw("DATE(datetime) like ?", ["%$keyword%"]);
                })
                ->rawColumns(['action', 'status_text'])
                ->make(true);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_header' => 'required|string',
            'points' => 'required|array|min:1',
            'points.*.title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first(),
            ], 200);
        }

        try {
            $userId = Auth::user()->id;

            $tip = DB::transaction(function () use ($request, $userId) {
                $tip = InterviewTip::create([
                    'main_header' => $request->input('main_header'),
                    'short_line' => $request->input('short_line'),
                    'footer_title' => $request->input('footer_title'),
                    'footer_description' => $request->input('footer_description'),
                    'status' => $request->input('action_type'),
                    'datetime' => now(),
                    'created_by' => $userId,
                ]);

                $this->syncPoints($tip, $request->input('points', []), $userId, true);

                return $tip;
            });

            StaffActivityController::insertActivity($userId, 'Interview Tip Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Interview tip created successfully.',
                'data' => $tip,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong while creating the interview tip.',
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $tip = InterviewTip::with('points')->findOrFail($id);

        return response()->json([
            'status' => 1,
            'data' => [
                'id' => $tip->id,
                'main_header' => $tip->main_header,
                'short_line' => $tip->short_line,
                'footer_title' => $tip->footer_title,
                'footer_description' => $tip->footer_description,
                'status' => $tip->status,
                'points' => $tip->points->map(function ($point) {
                    return [
                        'title' => $point->title,
                        'description' => $point->description,
                    ];
                })->values(),
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'main_header' => 'required|string',
            'points' => 'required|array|min:1',
            'points.*.title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first(),
            ], 200);
        }

        try {
            $userId = Auth::user()->id;

            $tip = DB::transaction(function () use ($request, $id, $userId) {
                $tip = InterviewTip::findOrFail($id);

                $tip->update([
                    'main_header' => $request->input('main_header'),
                    'short_line' => $request->input('short_line'),
                    'footer_title' => $request->input('footer_title'),
                    'footer_description' => $request->input('footer_description'),
                    'status' => $request->input('action_type'),
                    'updated_by' => $userId,
                ]);

                $this->syncPoints($tip, $request->input('points', []), $userId, false);

                return $tip;
            });

            StaffActivityController::insertActivity($userId, 'Interview Tip updated Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Interview tip updated successfully.',
                'data' => $tip,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to update interview tip.',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $userId = Auth::user()->id;
            $tip = InterviewTip::findOrFail($id);

            foreach ($tip->points as $point) {
                $point->update(['deleted_by' => $userId]);
                $point->delete();
            }

            $tip->update(['deleted_by' => $userId]);
            $tip->delete();

            StaffActivityController::insertActivity($userId, 'Interview Tip Delete Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Interview tip deleted successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete interview tip.',
            ]);
        }
    }

    private function syncPoints(InterviewTip $tip, array $points, $userId, $isCreate)
    {
        if (!$isCreate) {
            foreach ($tip->points as $point) {
                $point->update(['deleted_by' => $userId]);
                $point->delete();
            }
        }

        foreach (array_values($points) as $index => $point) {
            if (empty($point['title'])) {
                continue;
            }

            InterviewTipPoint::create([
                'interview_tip_id' => $tip->id,
                'title' => $point['title'],
                'description' => $point['description'] ?? null,
                'sort_order' => $index + 1,
                'created_by' => $userId,
            ]);
        }
    }
}
