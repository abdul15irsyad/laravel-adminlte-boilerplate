<?php

namespace App\Http\Controllers;

use Carbon, DataTables, TitleHelper, ButtonHelper, TokenHelper, MailHelper, Hash, Route, Mail;
use App\Mail\UserMail;
use App\Models\{User, Role, Token};
use App\Rules\NotLastActiveSuperAdmin;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get_users(Request $request)
    {
        if ($request->ajax()) {
            if($request->get('page') == 'users'){
                $data = User::with(['role'])->get();
            }else if($request->get('page') == 'detail-role'){
                $data = User::with(['role'])->whereHas('role',function($query) use($request){
                    $query->where('role_slug',$request->get('role'));
                })->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="text-center">';
                    $btn .= ButtonHelper::datatable_button('detail',[
                        'href' => route('users.detail',['id' => $row->id]),
                        'title' => 'detail',
                        'icon' => 'fas fa-info',
                    ]);
                    $btn .= ButtonHelper::datatable_button('edit',[
                        'href' => route('users.update',['id' => $row->id]),
                        'title' => 'edit',
                        'icon' => 'far fa-edit',
                    ]);
                    $btn .= ButtonHelper::datatable_button('delete',[
                        'href' => route('users.delete',['id' => $row->id]),
                        'nickname' => $row->user_username,
                        'additional-attribute' => null,
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

    public function detail(Request $request)
    {
        $id = $request->route('id');
        $user = User::with(['role'])->findOrFail($id);
        $data = [
            'title' => 'Detail User',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Users', 'status' => null, 'link' => route('users')],
                ['text' => 'Detail', 'status' => 'active', 'link' => '#'],
            ],
            'user' => $user,
        ];
        return view('contents.users.detail', $data);
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
        $user->user_password = Hash::make($request->input('password'));
        $role = Role::where('role_slug',$request->input('role'))->first();
        $user->role_id = $role->id;
        $user->save();
        
        // create new token and then send to email
        $data = [
            'subject' => 'Email Verification',
            'markdown' => 'mails.verify-email',
        ];
        MailHelper::send_token_to_user($user,'email_verification',$data);
        
        // input activity log
        $properties = $user->only(['id','user_name', 'user_username','user_email', 'role_id']);
        activity()
            ->on($user)
            ->withProperties($properties)
            ->event('created')
            ->log('has created user ('. $user->user_username . ')');

        return redirect()
            ->route('users')
            ->with('type', 'success')
            ->with('message', 'Create user successfull');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $user = User::findOrFail($id);
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
            'status' => ['required','in:Active,Suspend', new NotLastActiveSuperAdmin($id)],
        ]);
        
        $user = User::findOrFail($id);
        $old_user = $user->replicate();
        $password_change = false;
        $user->user_status = $request->input('status') == 'Active' ? 'Y' : 'N';
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
            $password_change = true;
        }
        $role = Role::where('role_slug',$request->input('role'))->first();
        $user->role_id = $role->id;
        $user->save();

        // input activity log
        $properties = [
            'id' => $user->id,
            'old' => $old_user->only(['user_name', 'user_username', 'user_email', 'role_id', 'user_status']),
            'new' => $user->only(['user_name', 'user_username', 'user_email', 'role_id', 'user_status']),
        ];
        $properties['new']['password_change'] = $password_change;
        activity()
            ->on($user)
            ->withProperties($properties)
            ->event('updated')
            ->log('has updated user ('. $user->user_username . ')');

        return redirect()
            ->route('users')
            ->with('type', 'success')
            ->with('message', 'Update user successfull'); 
    }

    public function delete(Request $request)
    {
        $id = $request->route('id');
        $user = User::findOrFail($id);
        
        $super_admins = User::whereHas('role',fn($query) => $query->where('role_slug','super-admin'))->get();
        if($user->role->role_slug == 'super-admin' && $super_admins->count() <= 1){
            return redirect()
                ->route('users')
                ->with('type', 'danger')
                ->with('message', 'Delete user failed, there is must be at least 1 super admin');
        }

        $properties = $user->only(['id','user_username']);
        $user->delete();
        
        // input activity log
        activity()
            ->on($user)
            ->withProperties($properties)
            ->event('deleted')
            ->log('has deleted user ('. $user->user_username . ')');
        
        return redirect()
            ->route('users')
            ->with('type', 'success')
            ->with('message', 'Delete user successfull');
    }
}
