<?php

namespace App\Http\Controllers\Company;

use App\Models\Ingredient;
use App\Models\PurchasedIngredient;
use App\Models\Purchase;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{

    public function purchaseIndex ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        $purchases = $company->purchases;
        $ingredients = $company->ingredients;
        return view('company.purchases.purchase', [
            'title' => 'Purchase Items',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'accounts' => $accounts,
            'purchases' => $purchases,
            'ingredients' => $ingredients,
        ]);
    }

    public function purchaseHistory ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $purchases = $company->purchases;
        return view('company.purchases.history', [
            'title' => 'Purchase History',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'purchases' => $purchases,
        ]);
    }

    public function purchaseOV ($cp_index, $pc_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $purchases = $company->purchases;
        $ingredients = $company->ingredients;
        $pc_index -= 1;
        $purchase = $purchases[$pc_index];
        return view('company.purchases.overview', [
            'title' => 'Purchase Detail',
            'user' => $user,
            'cp_index' => $cp_index,
            'pc_index' => $pc_index,
            'company' => $company,
            'purchases' => $purchases,
            'purchase' => $purchase,
            'ingredients' => $ingredients,
        ]);
    }

    public function store(Request $request) {
        $cartData = json_decode($request->cartData);
        $cp_index = $cartData[0]->cp_index;
        $cp_index -= 1;
        $account_id = $cartData[0]->account_id;
        $cart_items = $cartData[1];
        // dd($cartData);
        $user = Auth::user();
        $companies = $user->companies;
        $company = $companies[$cp_index];
        $ingredients = $company->ingredients;
        $accounts = $company->accounts;
        $accountFound = false;
        // dd($accounts);
        foreach ($accounts as $account) {
            if ($account->account_id == $account_id) {
                $accountFound = true;
                // dd($accountFound);
            }
        }
        if ($accountFound === false) {
            return redirect()->back();
        }
        $total_amount = 0;
        foreach ($cart_items as $item) {
            $total_amount += $item->total;
        }
        // dd($total_amount);

        // dd($cart_items);
        $purchaseData = [];
        $purchaseData['account_id'] = (int)$account_id;
        $purchaseData['company_id'] = $company->company_id;
        $purchaseData['total_amount'] = $total_amount;
        // Purchase::truncate();
        // PurchasedIngredient::truncate();
        $account = Account::find((int)$account_id);
        // dd($account);
        $balance = $account->balance - $total_amount;
        $purchase = Purchase::create($purchaseData);
        $account->update(['balance' => $balance]);
        foreach ($cart_items as $item) {
            $ig_index = $ingredients->pluck('name')->search($item->itemName);
            $ingredient = $ingredients[$ig_index];
            $update_stock = $ingredient->stock + (int)$item->quantity;
            $data = [];
            $data['purchase_id'] = $purchase->purchase_id;
            $data['ingredient_id'] = $ingredient->ingredient_id;
            $data['quantity'] = (int)$item->quantity;
            $data['amount'] = $item->total;
            PurchasedIngredient::create($data);
            $ingredient->update(['stock' => $update_stock]);
        }
        return redirect()->back();
    }

    public function update(Request $request, $ingredient_id) {
        $data = $request->all();
        Ingredient::findOrFail($ingredient_id)->update($data);
        return redirect()->back();
    }

    public function destroy(Request $request, $ingredient_id) {
        Ingredient::findOrFail($ingredient_id)->delete();
        return redirect()->back();
    }

}