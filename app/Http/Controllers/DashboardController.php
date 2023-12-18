<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index () {
        $user = Auth::user();
        $companies = $user->companies;
        return view('dashboard', [
            'title'=> 'Manage Companies',
            'user' => $user,
            'companies' => $companies,
        ]);
    }

    public function store(Request $request) {
        $data = $request->all();
        $data['name'] = $request->name;
        $data['slug'] = Str::slug($request->name);
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['website'] = $request->website;
        $data['description'] = $request->description;
        $data['is_active'] = "true";
        $data['user_id'] = Auth::user()->user_id;
        Company::create($data);
        return redirect()->back();
    }

    public function update(Request $request, $company_id) {
        $data = $request->all();
        Company::findOrFail($company_id)->update($data);
        return redirect()->back();
    }

    public function destroy(Request $request, $company_id) {
        Company::findOrFail($company_id)->delete();
        return redirect()->back();
    }
}