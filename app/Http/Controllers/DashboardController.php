<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        $users = User::all();
        $data = [
            'title' => 'Dashboard',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => 'active', 'link' => '#'],
            ],
            'users' => $users,
        ];
        return view('contents.dashboard.index', $data);
    }
}
