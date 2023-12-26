<?php

namespace App\Http\Controllers\Company;

use App\Models\Sale;
use App\Models\Category;
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
        $accounts = $company->accounts;
        $products = $company->products;
        $categories = $company->categories;
        $sales = Sale::whereIn('account_id', $accounts->pluck('account_id'))->get();
        $soldProducts = $sales->pluck('soldProducts')->flatten();
        $productsCategories = $soldProducts->pluck('product')->pluck('category_id')->unique();
        // dd($soldProducts);

        $amountSoldByProduct = [];
        foreach ($soldProducts as $index => $soldProduct) {
            $amountSold = $soldProduct->amount;
            $product_id = $soldProduct->product_id;
            if (!isset($amountSoldByProduct[$product_id])) {
                $amountSoldByProduct[$product_id] = $soldProduct->product;
                $amountSoldByProduct[$product_id]['total_sold'] = 0;
            }
            $amountSoldByProduct[$product_id]['total_sold'] += $amountSold;
            // $amountSoldByProduct[$productId] = $product->product;
            // $amountSoldByProduct[$productId]['amountSold'] += $amountSold;
        }

        $soldCategories = Category::whereIn('category_id', $productsCategories)->get();
        $amountSoldByCategory = [];
        foreach ($soldCategories as $index => $category) {
            $currentMonth = now()->format('m');
            $amountSold = $soldProducts
                ->filter(function ($soldProduct) use ($currentMonth, $category) {
                    return $soldProduct->product->category_id == $category->category_id
                        && $soldProduct->created_at->format('m') == $currentMonth;
                })
                ->sum('amount');
            // $amountSold = $soldProducts->where('product.category_id', $category->category_id)->sum('amount');
            if ($amountSold != 0) {
                $amountSoldByCategory[$index] = $category;
                $amountSoldByCategory[$index]['total_sold'] = $amountSold;
            }
        }
        // dd($amountSoldByCategory);
        
        return view('company.dashboard.dashboard', [
            'title' => 'Company Dashboard',
            'user' => $user,
            'company' => $company,
            'accounts' => $accounts,
            'products' => $products,
            'amountSoldByProduct' => $amountSoldByProduct,
            'amountSoldByCategory' => $amountSoldByCategory,
            'sales' => $sales
        ]);
    }
}
