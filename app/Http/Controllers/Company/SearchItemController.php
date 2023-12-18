<?php

namespace App\Http\Controllers\Company;

use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SearchItemController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        $cp_index = $request->get('cp_index');
        $cp_index -= 1;
        $user = Auth::user();
        $company = $user->companies[$cp_index];

        // Perform the search operation on your data source
        $filteredItems = Ingredient::where('name', 'like', '%' . $query . '%')
                            ->where('company_id', $company->company_id)
                            ->get();

        // Return the filtered items as a response
        return view('company.purchases.search-results')->with('items', $filteredItems);
    }

    public function searchProduct(Request $request)
    {
        $query = $request->get('query');
        $cp_index = $request->get('cp_index');
        $cp_index -= 1;
        $user = Auth::user();
        $company = $user->companies[$cp_index];

        // Perform the search operation on your data source
        $filteredItems = Product::where('name', 'like', '%' . $query . '%')
                            ->where('company_id', $company->company_id)
                            ->get();

        // Return the filtered items as a response
        return view('company.sales.search-results')->with(
            ['products' => $filteredItems,
            'cp_index' => $cp_index,
            'company' => $company
        ]);
    }

}
