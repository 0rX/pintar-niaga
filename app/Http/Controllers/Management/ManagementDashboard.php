<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagementDashboard extends Controller
{
    public function index () {
        return view('management.dashboard');
    }
}
