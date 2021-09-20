<?php

namespace App\Http\Controllers;

use DataTables, ButtonHelper;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function get_permissions(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="text-center">';
                    $btn .= ButtonHelper::datatable_button('detail',[
                        'href' => route('permission.detail',['id' => $row->id]),
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
            'title' => 'Permissions',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Permissions', 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.permissions.index', $data);
    }
}
