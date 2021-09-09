<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Token;
use Carbon, DataTables, TitleHelper, ButtonHelper, TokenHelper, MailHelper, Hash, Route;
use Illuminate\Http\Request;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;

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
                    $btn .= ButtonHelper::datatable_button('edit',[
                        'href' => route('users.update',['id' => $row->id]),
                        'title' => 'edit',
                        'icon' => 'far fa-edit',
                    ]);
                    $btn .= ButtonHelper::datatable_button('delete',[
                        'href' => route('users.delete',['id' => $row->id]),
                        'nickname' => $row->user_username,
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
            'title' => 'Users',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Users', 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.users.index', $data);
    }

    public function create()
    {
        $roles = Role::all();
        $data = [
            'title' => 'Create User',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Users', 'status' => null, 'link' => route('users')],
                ['text' => 'Create', 'status' => 'active', 'link' => '#'],
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
        
        // create new token and then send to email
        $data = [
            'subject' => 'Email Verification',
            'markdown' => 'mails.verify-email',
        ];
        MailHelper::send_token_to_user($user,'email_verification',$data);

        return redirect()
            ->route('users')
            ->with('type', 'success')
            ->with('message', 'Create user successfull');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $user = User::where('id',$id)->firstOrFail();
        $roles = Role::all();
        $data = [
            'title' => 'Update User',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Users', 'status' => null, 'link' => route('users')],
                ['text' => 'Update User', 'status' => 'active', 'link' => '#'],
            ],
            'user' => $user,
            'roles' => $roles,
        ];
        return view('contents.users.update', $data);
    }

    public function save(Request $request)
    {
        $id = $request->route('id');
        $this->validate($request, [
            'name' => 'required|min:3',
            'username' => 'required|min:3|regex:/^[a-z0-9\_]+$/|unique:users,user_username,' . $id . ',id',
            'email' => 'required|email|unique:users,user_email,' . $id . ',id',
            'password' => 'nullable|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])./',
            'confirm_password' => $request->input('password') ? 'same:password' : 'nullable',
            'role' => 'required|exists:roles,role_slug',
        ]);

        $user = User::find($id);
        $user->user_name = $request->input('name');
        $user->user_username = $request->input('username');
        if($user->user_email != $request->input('email')){
            $user->user_email = $request->input('email');
            // create new token and then send to email
            $data = [
                'subject' => 'Email Verification',
                'markdown' => 'mails.verify-email',
            ];
            MailHelper::send_token_to_user($user,'email_verification',$data);
        }
        if($request->input('password')){
            $user->user_password  = Hash::make($request->input('password'));
        }
        $role = Role::where('role_slug',$request->input('role'))->first();
        $user->role_id = $role->id;
        $user->save();

        return redirect()
            ->route('users')
            ->with('type', 'success')
            ->with('message', 'Update user successfull');        
    }

    public function delete(Request $request)
    {
        $id = $request->route('id');
        $user = User::where('id',$id)->firstOrFail();
        
        $super_admins = User::whereHas('role',function($query){
            $query->where('role_slug','super-admin');
        })->get();
        if($user->role->role_slug == 'super-admin' && $super_admins->count() <= 1){
            return redirect()
            ->route('users')
            ->with('type', 'danger')
            ->with('message', 'Delete user failed, must be at least 1 super admin');
        }

        $user->delete();
        
        return redirect()
            ->route('users')
            ->with('type', 'success')
            ->with('message', 'Delete user successfull');
    }
}
