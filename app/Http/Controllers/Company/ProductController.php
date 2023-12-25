<?php

namespace App\Http\Controllers\Company;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{

    public function productIndex ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $categories = $company->categories;
        $products = $company->products;
        $ingredients = $company->ingredients;
        return view('company.products.index', [
            'title' => 'Product List',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'categories' => $categories,
            'products' => $products,
            'ingredients' => $ingredients,
        ]);
    }

    public function productOV ($cp_index, $pd_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $categories = $company->categories;
        $products = $company->products;
        $pd_index -= 1;
        $product = $products[$pd_index];
        $ingredients = $company->ingredients;
        return view('company.products.overview', [
            'title' => 'Product Index',
            'user' => $user,
            'cp_index' => $cp_index,
            'pd_index' => $pd_index,
            'company' => $company,
            'categories' => $categories,
            'product' => $product,
            'ingredients' => $ingredients,
        ]);
    }

    public function store(Request $request) {
        $cp_index = $request->cp_index;
        $user = Auth::user();
        $companies = $user->companies;
        $company = $companies[$cp_index];
        $data = $request->all();
        $ingredientsJson = json_encode($request->ingredients);
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['company_id'] = $company->company_id;
        $data['category_id'] = $request->category_id;
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $random_name = rand(100000, 999999) . $file->getClientOriginalName();
            $random_name = preg_replace('/[^A-Za-z0-9]/', '', Hash::make($random_name)) . "." . $file->getClientOriginalExtension();
            $data['image'] = $random_name;
            $filename = $random_name;
            $file->move(public_path('storage/images'), $filename);
        };
        $data['sale_price'] = $request->sale_price;
        $data['recipe'] = $ingredientsJson;
        Product::create($data);
        return redirect()->back();
    }

    public function update(Request $request, $product_id) {
        $data = $request->all();
        // dd($data);
        $ingredientsJson = json_encode($request->ingredients);
        $data['recipe'] = $ingredientsJson;
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $random_name = rand(100000, 999999) . $file->getClientOriginalName();
            $random_name = preg_replace('/[^A-Za-z0-9]/', '', Hash::make($random_name)) . "." . $file->getClientOriginalExtension();
            $data['image'] = $random_name;
            $filename = $random_name;
            $file->move(public_path('storage/images'), $filename);
        };
        Product::findOrFail($product_id)->update($data);
        return redirect()->back();
    }

    public function destroy(Request $request, $product_id) {
        $companies = Auth::user()->companies;
        $cp_name = Product::findOrFail($product_id)->company->name;
        $cp_index = $companies->pluck('name')->search($cp_name);
        // dd($cp_index);
        $cp_index += 1;
        Product::findOrFail($product_id)->delete();
        return redirect('/manage/'.$cp_index.'/products/');
    }

}