<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Dashboard',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.dashboard.index', $data);
    }
}
