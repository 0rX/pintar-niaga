<?php

namespace App\Http\Controllers\Company;

use App\Models\SoldProduct;
use App\Models\UsedIngredient;
use App\Models\Sale;
use App\Models\Account;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{

    public function saleIndex ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $accounts = $company->accounts;
        $sales = $company->sales;
        $ingredients = $company->ingredients;
        $products = $company->products;
        return view('company.sales.sale', [
            'title' => 'Sell Items',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'accounts' => $accounts,
            'sales' => $sales,
            'ingredients' => $ingredients,
            'products' => $products,
        ]);
    }

    public function saleHistory ($cp_index) {
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

    public function saleOV ($cp_index, $sl_index) {
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
        $products = $company->products;
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
        $saleData = [];
        $saleData['account_id'] = (int)$account_id;
        $saleData['company_id'] = $company->company_id;
        $saleData['total_amount'] = $total_amount;
        // Purchase::truncate();
        // PurchasedIngredient::truncate();
        $account = Account::find((int)$account_id);
        // dd($cart_items);
        foreach ($cart_items as $item) {
            $pd_index = $products->pluck('name')->search($item->itemName);
            $product = $products[$pd_index];
            // dd($product->recipe);
            $recipes = json_decode($product->recipe);
            // dd($recipes);
            foreach ($recipes as $recipe) {
                // dd($recipe->name);
                $ingredient = Ingredient::where('name', $recipe->name)->first();
                dd($ingredient); //LAST DEBUG !!!! DON'T FORGET !!
            }
            $update_stock = $product->stock - (int)$item->quantity;
        }
        $balance = $account->balance + $total_amount;
        $sale = Sale::create($saleData);
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