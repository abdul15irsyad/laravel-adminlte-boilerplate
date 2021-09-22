<?php

namespace App\Http\Controllers;

use DataTables, ButtonHelper, Str;
use App\Models\{Permission, Role, User, PermissionRole};
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function get_roles(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::with(['users','permissions'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="text-center">';
                    $btn .= ButtonHelper::datatable_button('detail',[
                        'href' => route('roles.detail',['id' => $row->id]),
                        'title' => 'detail',
                        'icon' => 'fas fa-info',
                    ]);
                    if($row->role_slug != 'super-admin'){
                        $btn .= ButtonHelper::datatable_button('edit',[
                            'href' => route('roles.update',['id' => $row->id]),
                            'title' => 'edit',
                            'icon' => 'far fa-edit',
                        ]);
                        $btn .= ButtonHelper::datatable_button('delete',[
                            'href' => route('roles.delete',['id' => $row->id]),
                            'nickname' => $row->role_name,
                            'additional-attribute' => 'data-user-count="'.$row->users->count().'"',
                            'title' => 'delete',
                            'icon' => 'far fa-trash-alt',
                        ]);
                    }
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
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Roles', 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.roles.index', $data);
    }

    public function detail(Request $request)
    {
        $id = $request->route('id');
        $role = Role::with(['users','permissions'])->findOrFail($id);
        $data = [
            'title' => 'Detail Role',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Roles', 'status' => null, 'link' => route('roles')],
                ['text' => 'Detail', 'status' => 'active', 'link' => '#'],
            ],
            'role' => $role,
        ];
        return view('contents.roles.detail', $data);
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
            'permission' => 'array',
            'permission.*' => 'exists:permissions,permission_slug',
        ],[
            'slug.unique' => 'role name is already exist',
            'permission.*.exists' => 'some permission didn\'t exist',
        ]);

        $role = new Role;
        $role->role_name = $request->input('name');
        $role->role_slug = $request->input('slug');
        $role->role_desc = $request->input('desc');
        $role->save();
        
        foreach($request->input('permission') ?? [] as $permission_slug){
            $permission_role = new PermissionRole;
            $permission_role->role_id = $role->id;
            $permission = Permission::where('permission_slug',$permission_slug)->first();
            $permission_role->permission_id = $permission->id;
            $permission_role->save();
        }

        // input activity log
        $properties = array_merge($role->only(['role_name','role_desc']),[
            'permissions' => $role->permissions->map(fn($permission)=>$permission->permission_title)
        ]);
        activity()
            ->on($role)
            ->withProperties($properties)
            ->event('created')
            ->log('has created role ('. $role->role_name . ')');
        
        return redirect()
            ->route('roles')
            ->with('type', 'success')
            ->with('message', 'Create role successfull');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $role = Role::with(['permissions'])->findOrFail($id);
        $role_permissions = [];
        foreach($role->permissions as $permission){
            array_push($role_permissions,$permission->permission_slug);
        }
        $permissions = Permission::all();
        $data = [
            'title' => 'Update Role',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Roles', 'status' => null, 'link' => route('roles')],
                ['text' => 'Update Role', 'status' => 'active', 'link' => '#'],
            ],
            'role' => $role,
            'role_permissions' => $role_permissions,
            'permissions' => $permissions,
        ];
        return view('contents.roles.update', $data);
    }

    public function save(Request $request)
    {
        $id = $request->route('id');
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);
        $this->validate($request, [
            'name' => 'required|min:3',
            'slug' => 'unique:roles,role_slug,'.$id.',id',
            'desc' => 'nullable',
            'permission' => 'array',
            'permission.*' => 'exists:permissions,permission_slug',
        ],[
            'slug.unique' => 'role name is already exist',
            'permission.*.exists' => 'some permission didn\'t exist',
        ]);

        $role = Role::with(['permissions'])->findOrFail($id);
        $old_role = $role->replicate();
        $role->role_name = $request->input('name');
        $role->role_slug = $request->input('slug');
        $role->role_desc = $request->input('desc');
        $role->save();

        foreach($role->permission_roles as $permission_role){
            if(!in_array($permission_role->permission->permission_slug,$request->input('permission') ?? [])){
                $permission_role->delete();
            }
        }
        
        foreach($request->input('permission') ?? [] as $permission_slug){
            $permission = Permission::where('permission_slug',$permission_slug)->first();
            $permission_role = $role->permission_roles->where('permission_id',$permission->id)->first();
            if(!$permission_role){
                $permission_role = new PermissionRole;
                $permission_role->role_id = $role->id;
                $permission = Permission::where('permission_slug',$permission_slug)->first();
                $permission_role->permission_id = $permission->id;
                $permission_role->save();
            }
        }

        // input activity log
        // old data
        $properties['old'] = array_merge($old_role->only(['role_name', 'role_desc']),[
            'permissions' => $old_role->permissions->map(fn($permission)=>$permission->permission_title)
        ]);
        // new data
        $role = Role::with(['permissions'])->findOrFail($role->id);
        $properties['new'] = array_merge($role->only(['role_name', 'role_desc']),[
            'permissions' => $role->permissions->map(fn($permission)=>$permission->permission_title)
        ]);
        activity()
            ->on($role)
            ->withProperties($properties)
            ->event('updated')
            ->log('has updated role ('. $role->role_name . ')');
        
        return redirect()
            ->route('roles')
            ->with('type', 'success')
            ->with('message', 'Update role successfull');
    }

    public function delete(Request $request)
    {
        $id = $request->route('id');
        $role = Role::with(['users'])->findOrFail($id);
        if($role->role_slug == 'super-admin'){
            return redirect()
                ->route('roles')
                ->with('type', 'danger')
                ->with('message', 'Delete role failed, cannot delete super admin');
        }
        if($role->users->count()>0){
            return redirect()
                ->route('roles')
                ->with('type', 'danger')
                ->with('message', 'Delete role failed, there are 2 users in this role');
        }

        $properties = $role->only(['id','role_name']);
        $role->delete();

        // input activity log
        activity()
            ->on($role)
            ->withProperties($properties)
            ->event('deleted')
            ->log('has deleted role ('. $role->role_name . ')');
        
        return redirect()
            ->route('roles')
            ->with('type', 'success')
            ->with('message', 'Delete role successfull');
    }
}
