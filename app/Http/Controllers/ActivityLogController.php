<?php

namespace App\Http\Controllers;

use DataTables, ButtonHelper;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function get_activities(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::with(['causer','subject'])->orderBy('created_at','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="text-center">';
                    $btn .= ButtonHelper::datatable_button('detail',[
                        'href' => route('activity-log.detail',['id' => $row->id]),
                        'title' => 'detail',
                        'icon' => 'fas fa-info',
                    ]);
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Activity Log',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Activity Log', 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.activity-log.index', $data);
    }

    public function detail(Request $request)
    {
        $id = $request->route('id');
        $activity_log = Activity::with(['causer','subject'])->findOrFail($id);
        $data = [
            'title' => 'Detail Activity Log',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Activity Log', 'status' => null, 'link' => route('activity-log')],
                ['text' => 'Detail', 'status' => 'active', 'link' => '#'],
            ],
            'activity_log' => $activity_log,
        ];
        return view('contents.activity-log.index', $data);
    }
}
