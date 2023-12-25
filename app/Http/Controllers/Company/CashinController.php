<?php

namespace App\Http\Controllers\Company;

use App\Models\Account;
use App\Models\CashIn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CashinController extends Controller
{

    public function cashinIndex ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        return view('company.cashins.index', [
            'title' => 'Deposit',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'accounts' => $accounts
        ]);
    }

    public function cashinOV ($cp_index, $ac_index, $ci_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        $ac_index -= 1;
        $account = $accounts[$ac_index];
        $ci_index -= 1;
        $cashin = $account->cashins[$ci_index];
        return view('company.cashins.overview', [
            'title' => 'Transaction Overview',
            'user' => $user,
            'cp_index' => $cp_index,
            'ac_index' => $ac_index,
            'company' => $company,
            'accounts' => $accounts,
            'account' => $account,
            'cashin' => $cashin,
        ]);
    }

    public function newcashin ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        return view('company.accounts.cashin', [
            'title' => 'Account Index',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'accounts' => $accounts
        ]);
    }

    public function cashin(Request $request) {
        $data = $request->all();
        dd($request);
    }

    public function store(Request $request) {
        $cp_index = $request->cp_index;
        $user = Auth::user();
        $companies = $user->companies;
        $company = $companies[$cp_index];
        $data = $request->all();
        $account = $company->accounts->find($request->account_id);
        $balance = $account->balance + $request->total_amount;
        // dd($cp_index);
        $data['title'] = $request->title;
        $data['total_amount'] = $request->total_amount;
        $data['description'] = $request->description;
        $data['account_id'] = $request->account_id;
        $data['company_id'] = $company->company_id;
        $cashin = CashIn::create($data);
        $ci_index = $account->cashins->pluck('cash_in_id')->search($cashin->cash_in_id);
        $ac_index = $company->accounts->pluck('account_id')->search($account->account_id);
        $account->update(['balance' => $balance]);
        $cp_index += 1;
        $ac_index += 1;
        $ci_index += 1;
        return redirect()->route('cashin', ['cp_index' => $cp_index, 'ac_index' => $ac_index, 'ci_index' => $ci_index]);
    }

    public function update(Request $request, $cash_in_id) {
        $data = $request->all();
        CashIn::findOrFail($cash_in_id)->update($data);
        return redirect()->back();
    }

    public function destroy(Request $request, $cash_in_id) {
        Payment::findOrFail($cash_in_id)->delete();
        return redirect()->back();
    }
}
