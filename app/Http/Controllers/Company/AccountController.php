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

    public function report($cp_index, $ac_index ) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        $ac_index -= 1;
        $account = $accounts[$ac_index];
        $transactions = [];
        $sales = [];
        $purchases = [];
        $payments = [];
        $cashins = [];
        foreach ($account->sales as $key => $sale) {
            $sale['type'] = 'sale';
            $sale['description'] = '-';
            array_push($sales, $sale);
        }
        foreach ($account->purchases as $key => $purchase) {
            $purchase['type'] = 'purchase';
            $purchase['description'] = '-';
            array_push($purchases, $purchase);
        }
        foreach ($account->cashins as $key => $cashin) {
            $cashin['type'] = 'cashin';
            if ($cashin->description == null) {
                $cashin['description'] = $cashin->title.' - no description';
            } else {
                $cashin['description'] = $cashin->title.' - '.$cashin->description;
            }
            array_push($cashins, $cashin);
        }
        foreach ($account->payments as $key => $payment) {
            $payment['type'] = 'payment';
            if ($payment->description == null) {
                $payment['description'] = $payment->title.' - no description';
            } else {
                $payment['description'] = $payment->title.' - '.$payment->description;
            }
            array_push($payments, $payment);
        }
        foreach ($sales as $key => $sale) {
            array_push($transactions, $sale);
        }
        foreach ($purchases as $key => $purchase) {
            array_push($transactions, $purchase);
        }
        foreach ($cashins as $key => $cashin) {
            array_push($transactions, $cashin);
        }
        foreach ($payments as $key => $payment) {
            array_push($transactions, $payment);
        }
        // dd($transactions);
        $total_income = 0 ;
        $total_expense = 0 ;
        foreach ($transactions as $transaction) {
                // dd($transaction);
                if ($transaction->type == 'sale' || $transaction->type == 'cashin') {
                    $total_income += $transaction->total_amount;
                } else {
                    $total_expense -= $transaction->total_amount;
                }
        }
        // dd($total_income,$total_expense);
        return view('company.accounts.report',[
            'title' => 'Account Report',
            'user' => $user,
            'cp_index' => $cp_index,
            'ac_index' => $ac_index,
            'company' => $company,
            'accounts' => $accounts,
            'account' => $account,
            'transactions' => $transactions,
            'total_income' => $total_income,
            'total_expense' => $total_expense
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
