<?php

namespace App\Http\Controllers;

use App\Models\{User, Role, Permission};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $data = [
            'title' => 'Dashboard',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => 'active', 'link' => '#'],
            ],
            'users' => $users,
            'roles' => $roles,
            'permissions' => $permissions,
        ];
        return view('contents.dashboard.index', $data);
    }
}
