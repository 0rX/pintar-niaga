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

        $saleData = [];
        $saleData['account_id'] = (int)$account_id;
        $saleData['company_id'] = $company->company_id;
        $saleData['total_amount'] = $total_amount;
        // Sale::truncate();
        // UsedIngredient::truncate();
        // dd(Sale::all());
        $account = Account::find((int)$account_id);
        $balance = $account->balance + $total_amount;
        $sale = Sale::create($saleData);
        $account->update(['balance' => $balance]);
        foreach ($cart_items as $item) {
            $pd_index = $products->pluck('name')->search($item->itemName);
            $product = $products[$pd_index];
            // dd($product->recipe);
            $recipes = json_decode($product->recipe);
            // dd($item);
            foreach ($recipes as $recipe) {
                // dd($recipe->amount);
                $ingredient = null;
                foreach ($ingredients as $currentIngredient) {
                    if ($currentIngredient->name === $recipe->name) {
                        $ingredient = $currentIngredient;
                        break; // Found the ingredient, exit the loop
                    }
                }
                if ($ingredient === null) {
                    http_response_code(500);
                    exit;
                }
                $amount_used = (int)$item->quantity*(int)$recipe->amount;
                $update_stock = $ingredient->stock - $amount_used;
                $ingredient->update(['stock' => $update_stock]);
                $dataIngredientUsed = [];
                $dataIngredientUsed['sale_id'] = $sale->sale_id;
                $dataIngredientUsed['ingredient_id'] = $ingredient->ingredient_id;
                $dataIngredientUsed['quantity'] = $amount_used;
                UsedIngredient::create($dataIngredientUsed);
            }
        }
        foreach ($cart_items as $item) {
            $pd_index = $products->pluck('name')->search($item->itemName);
            $product = $products[$pd_index];
            $data = [];
            $data['sale_id'] = $sale->sale_id;
            $data['product_id'] = $product->product_id;
            $data['quantity'] = (int)$item->quantity;
            $data['amount'] = $item->total;
            SoldProduct::create($data);
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