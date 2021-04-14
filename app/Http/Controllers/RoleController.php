<?php

namespace App\Http\Controllers;

use App\Models\Role;
use DataTables;
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
                    $btn .= '<a href="#" class="btn btn-primary btn-sm mx-1"><i class="fas fa-fw fa-pencil-alt"></i></a>';
                    $btn .= '<a href="#" class="btn btn-danger btn-sm mx-1"><i class="fas fa-fw fa-trash-alt"></i></a>';
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
            'title' => __('roles.roles'),
            'breadcumbs' => [
                ['text' => __('dashboard.dashboard'), 'status' => null, 'link' => route('dashboard',['locale'=>config('app.locale')])],
                ['text' => __('roles.roles'), 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.roles.index', $data);
    }
}
