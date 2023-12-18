<?php

namespace App\Http\Controllers\Company;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function categoryIndex ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $categories = $company->categories;
        return view('company.categories.index', [
            'title' => 'Category Index',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'categories' => $categories
        ]);
    }

    public function categoryOV ($cp_index, $ct_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $categories = $company->categories;
        $ct_index -= 1;
        $category = $categories[$ct_index];
        $products = $category->products;
        return view('company.categories.overview', [
            'title' => 'Category Index',
            'user' => $user,
            'cp_index' => $cp_index,
            'ct_index' => $ct_index,
            'company' => $company,
            'categories' => $categories,
            'category' => $category,
            'products' => $products
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
        Category::create($data);
        return redirect()->back();
    }

    public function update(Request $request, $category_id) {
        $data = $request->all();
        Category::findOrFail($category_id)->update($data);
        return redirect()->back();
    }

    public function destroy(Request $request, $category_id) {
        Category::findOrFail($category_id)->delete();
        return redirect()->back();
    }

}