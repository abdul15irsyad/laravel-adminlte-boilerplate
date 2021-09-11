<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;
use DataTables, ButtonHelper, Str;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function get_roles(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::with(['permission_roles','permission_roles.permission'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="text-center">';
                    $btn .= ButtonHelper::datatable_button('edit',[
                        'href' => route('roles.update',['id' => $row->id]),
                        'title' => 'edit',
                        'icon' => 'far fa-edit',
                    ]);
                    $btn .= ButtonHelper::datatable_button('delete',[
                        'href' => route('roles.delete',['id' => $row->id]),
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

    public function create()
    {
        $permissions = Permission::all();
        $data = [
            'title' => 'Create Role',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Roles', 'status' => null, 'link' => route('roles')],
                ['text' => 'Create', 'status' => 'active', 'link' => '#'],
            ],
            'permissions' => $permissions,
        ];
        return view('contents.roles.create', $data);
    }

    public function store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);
        $this->validate($request, [
            'name' => 'required|min:3',
            'slug' => 'unique:roles,role_slug',
            'desc' => 'nullable',
            'permissions' => 'nullable',
        ],[
            'slug.unique' => 'role name is already exist'
        ]);
        
        // dd($request->all());

        $role = new Role;
        $role->role_name = $request->input('name');
        $role->role_slug = $request->input('slug');
        $role->role_desc = $request->input('desc');
        $role->save();
        
        foreach($request->input('permission') as $permission_slug){
            $permission_role = new PermissionRole;
            $permission_role->role_id = $role->id;
            $permission = Permission::where('permission_slug',$permission_slug)->first();
            $permission_role->permission_id = $permission->id;
            $permission_role->save();
        }
        
        return redirect()
            ->route('roles')
            ->with('type', 'success')
            ->with('message', 'Create role successfull');
    }
}
