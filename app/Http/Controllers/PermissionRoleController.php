<?php

namespace App\Http\Controllers;

use App\Models\PermissionRole;
use DataTables, ButtonHelper;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    public function get_permission_roles(Request $request)
    {
        if ($request->ajax()) {
            $data = PermissionRole::with(['role','permission'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="text-center">';
                    $btn .= ButtonHelper::datatable_button('edit',[
                        'href' => '#',
                        'title' => 'edit',
                        'icon' => 'far fa-edit',
                    ]);
                    $btn .= ButtonHelper::datatable_button('delete',[
                        'href' => '#',
                        'nickname' => 'test',
                        'title' => 'delete',
                        'icon' => 'far fa-trash-alt',
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
        'title' => 'Permission Role',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard',['locale'=>config('app.locale')])],
                ['text' => 'Permission Role', 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.permission-roles.index', $data);
    }
}
