<?php

namespace App\Http\Controllers\Company;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function accountIndex ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        return view('company.accounts.index', [
            'title' => 'Account Index',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'accounts' => $accounts
        ]);
    }

    public function accountOV ($cp_index, $ac_index) {
        $user = Auth::user();
        $companies = $user->companies;
        // $ac_index = (int)$ac_index;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        $ac_index -= 1;
        $account = $accounts[$ac_index];

        $sales = $account->sales;
        $purchases = $account->purchases;
        $cashins = $account->cashins;
        $payments = $account->payments;

        return view('company.accounts.overview', [
            'title' => 'Account Index',
            'user' => $user,
            'cp_index' => $cp_index,
            'ac_index' => $ac_index,
            'company' => $company,
            'accounts' => $accounts,
            'account' => $account,
            'sales' => $sales,
            'purchases' => $purchases,
            'cashins' => $cashins,
            'payments' => $payments
        ]);
    }

    public function store(Request $request) {
        $cp_index = $request->cp_index;
        $user = Auth::user();
        $companies = $user->companies;
        $company = $companies[$cp_index];
        $data = $request->all();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['company_id'] = $company->company_id;
        $data['balance'] = 0;
        Account::create($data);
        return redirect()->back();
    }

    public function update(Request $request, $account_id) {
        $data = $request->all();
        Account::findOrFail($account_id)->update($data);
        return redirect()->back();
    }

    public function destroy(Request $request, $account_id) {
        Account::findOrFail($account_id)->delete();
        return redirect()->back();
    }
}
