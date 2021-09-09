<?php

namespace App\Http\Controllers;

use App\Models\Role;
use DataTables, ButtonHelper;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function get_roles(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::get();
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
                        'nickname' => $row->role_name,
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
            'title' => 'Roles',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard',['locale'=>config('app.locale')])],
                ['text' => 'Roles', 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.roles.index', $data);
    }
}
