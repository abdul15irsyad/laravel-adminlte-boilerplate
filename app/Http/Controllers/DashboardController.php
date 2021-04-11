<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Dasbor',
            'breadcumbs' => [
                ['text' => 'Dasbor', 'status' => 'active', 'link' => '#'],
            ],
        ];
        return view('content.dashboard.index', $data);
    }
}
