<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyDashboard extends Controller
{
    public function index () {
        return view('management.dashboard');
    }

    public function companyDashboard ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        if ($cp_index > $companies->count()) {
            abort(404);
        };
        $cp_index -= 1;
        $company = $companies[$cp_index];
        return view('company.dashboard.dashboard', [
            'title' => 'Company Dashboard',
            'user' => $user,
            'company' => $company
        ]);
    }
}
