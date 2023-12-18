<?php

namespace App\Http\Controllers\Company;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{

    public function inventoryIndex ($cp_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $products = $company->products;
        $ingredients = $company->ingredients;
        return view('company.inventory.index', [
            'title' => 'Inventory',
            'user' => $user,
            'cp_index' => $cp_index,
            'company' => $company,
            'products' => $products,
            'ingredients' => $ingredients,
        ]);
    }

    public function itemOV ($cp_index, $ig_index) {
        $user = Auth::user();
        $companies = $user->companies;
        $cp_index -= 1;
        $company = $companies[$cp_index];
        $products = $company->products;
        $ingredients = $company->ingredients;
        $ig_index -= 1;
        $ingredient = $ingredients[$ig_index];
        return view('company.inventory.overview', [
            'title' => 'Item Index',
            'user' => $user,
            'cp_index' => $cp_index,
            'ig_index' => $ig_index,
            'company' => $company,
            'products' => $products,
            'ingredients' => $ingredients,
            'ingredient' => $ingredient
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
        $data['stock'] = $request->stock;
        $data['amount_unit'] = $request->amount_unit;
        $data['purchase_price'] = $request->purchase_price;
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $random_name = rand(100000, 999999) . $file->getClientOriginalName();
            $data['image'] = $random_name;
            $filename = $random_name;
            $file = $file->move(public_path('storage/images'), $filename);
        };
        Ingredient::create($data);
        return redirect()->back();
    }

    public function update(Request $request, $ingredient_id) {
        $data = $request->all();
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $random_name = rand(100000, 999999) . $file->getClientOriginalName();
            $data['image'] = $random_name;
            $filename = $random_name;
            $file = $file->move(public_path('storage/images'), $filename);
        };
        Ingredient::findOrFail($ingredient_id)->update($data);
        return redirect()->back();
    }

    public function destroy(Request $request, $ingredient_id) {
        Ingredient::findOrFail($ingredient_id)->delete();
        return redirect()->back();
    }

}