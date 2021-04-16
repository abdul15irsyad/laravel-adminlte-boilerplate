<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use DataTables, TitleHelper, Hash, Route;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get_users(Request $request)
    {
        if ($request->ajax()) {
            $locale = $request->input('locale');
            $data = User::with(['role'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) use($locale){
                    $btn = '<div class="text-center">';
                    $btn .= '<a href="'.route('users.update',['locale' => $locale,'id' => $row->id]).'" class="btn btn-primary btn-sm mx-1"><i class="fas fa-fw fa-pencil-alt"></i></a>';
                    $btn .= '<a href="'.route('users.delete',['locale' => $locale,'id' => $row->id]).'" class="btn btn-danger btn-sm mx-1"><i class="fas fa-fw fa-trash-alt"></i></a>';
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
            'title' => __('users.create-user'),
            'breadcumbs' => [
                ['text' => __('dashboard.dashboard'), 'status' => null, 'link' => route('dashboard',['locale'=>config('app.locale')])],
                ['text' => __('users.users'), 'status' => null, 'link' => route('users',['locale'=>config('app.locale')])],
                ['text' => __('users.create-user'), 'status' => 'active', 'link' => '#'],
            ],
            'roles' => $roles,
        ];
        return view('contents.users.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'username' => 'required|min:3|regex:/^[a-z0-9\_]+$/|unique:users,user_username',
            'email' => 'required|email|unique:users,user_email',
            'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])./',
            'confirm_password' => 'same:password',
            'role' => 'required|exists:roles,role_slug',
        ]);

        $user = new User;
        $user->user_name = $request->input('name');
        $user->user_username = $request->input('username');
        $user->user_email = $request->input('email');
        $user->user_password  = Hash::make($request->input('password'));
        $role = Role::where('role_slug',$request->input('role'))->first();
        $user->role_id = $role->id;
        $user->save();

        return redirect()
            ->route('users',['locale'=>config('app.locale')])
            ->with('type', 'success')
            ->with('message', __('users.create-user-success'));
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $user = User::where('id',$id)->firstOrFail();
        $roles = Role::all();
        $data = [
            'title' => __('users.update-user'),
            'breadcumbs' => [
                ['text' => __('dashboard.dashboard'), 'status' => null, 'link' => route('dashboard',['locale'=>config('app.locale')])],
                ['text' => __('users.users'), 'status' => null, 'link' => route('users',['locale'=>config('app.locale')])],
                ['text' => __('users.update-user'), 'status' => 'active', 'link' => '#'],
            ],
            'user' => $user,
            'roles' => $roles,
        ];
        return view('contents.users.update', $data);
    }

    public function update_process(Request $request)
    {
        $id = $request->route('id');
        $this->validate($request, [
            'name' => 'required|min:3',
            'username' => 'required|min:3|regex:/^[a-z0-9\_]+$/|unique:users,user_username,' . $id . ',id',
            'email' => 'required|email|unique:users,user_email,' . $id . ',id',
            'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])./',
            'confirm_password' => 'same:password',
            'role' => 'required|exists:roles,role_slug',
        ]);

        
    }
}
