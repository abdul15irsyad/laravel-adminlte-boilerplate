<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use DataTables;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get_users(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with(['role'])->get();
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
            'title' => __('users.users'),
            'breadcumbs' => [
                ['text' => __('dashboard.dashboard'), 'status' => null, 'link' => route('dashboard',['locale'=>config('app.locale')])],
                ['text' => __('users.users'), 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.users.index', $data);
    }

    public function create()
    {
        $roles = Role::all();
        $data = [
            'title' => __('users.add-user'),
            'breadcumbs' => [
                ['text' => __('dashboard.dashboard'), 'status' => null, 'link' => route('dashboard',['locale'=>config('app.locale')])],
                ['text' => __('users.users'), 'status' => null, 'link' => route('users',['locale'=>config('app.locale')])],
                ['text' => __('users.add-user'), 'status' => 'active', 'link' => '#'],
            ],
            'roles' => $roles,
        ];
        return view('contents.users.create', $data);
    }
}
