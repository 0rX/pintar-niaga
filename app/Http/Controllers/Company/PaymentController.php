<?php

namespace App\Http\Controllers\Company;

use App\Models\Account;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function paymentIndex ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        return view('company.payments.index', [
            'title' => 'Payment',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'accounts' => $accounts
        ]);
    }

    public function paymentOV ($cp_index, $ac_index, $pm_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        $ac_index -= 1;
        $account = $accounts[$ac_index];
        $pm_index -= 1;
        $payment = $account->payments[$pm_index];
        return view('company.payments.overview', [
            'title' => 'Transaction Overview',
            'user' => $user,
            'cp_index' => $cp_index,
            'ac_index' => $ac_index,
            'company' => $company,
            'accounts' => $accounts,
            'account' => $account,
            'payment' => $payment,
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
        $balance = $account->balance - $request->total_amount;
        // dd($cp_index);
        $data['title'] = $request->title;
        $data['total_amount'] = $request->total_amount;
        $data['description'] = $request->description;
        $data['account_id'] = $request->account_id;
        $data['company_id'] = $company->company_id;
        $payment = Payment::create($data);
        $pm_index = $account->payments->pluck('payment_id')->search($payment->payment_id);
        $ac_index = $company->accounts->pluck('account_id')->search($account->account_id);
        $account->update(['balance' => $balance]);
        $cp_index += 1;
        $ac_index += 1;
        $pm_index += 1;
        return redirect()->route('payment', ['cp_index' => $cp_index, 'ac_index' => $ac_index, 'pm_index' => $pm_index]);
    }

    public function update(Request $request, $payment_id) {
        $data = $request->all();
        Payment::findOrFail($payment_id)->update($data);
        return redirect()->back();
    }

    public function destroy(Request $request, $payment_id) {
        Payment::findOrFail($payment_id)->delete();
        return redirect()->back();
    }
}
