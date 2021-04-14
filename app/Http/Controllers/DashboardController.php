<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $data = [
            'title' => __('dashboard.dashboard'),
            'breadcumbs' => [
                ['text' => __('dashboard.dashboard'), 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('contents.dashboard.index', $data);
    }
}
