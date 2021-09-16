<?php

namespace App\Http\Controllers;

use App\Models\{User, Role};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $users = User::all();
        $roles = Role::all();
        $data = [
            'title' => 'Dashboard',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => 'active', 'link' => '#'],
            ],
            'users' => $users,
            'roles' => $roles,
        ];
        return view('contents.dashboard.index', $data);
    }
}
