<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Spatie\WebhookServer\WebhookCall;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at')->paginate(8); //displays 8 products per page
        // $products = Product::all(); //display all products
        return view('products.productsTable', ['products' => $products]); //add the path of the view file; not the name of file in route
    }

    // public function create()
    // {
    //     return view('products.create');
    // }

    public function store(Request $request)
    {

        $data = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|decimal:0,2',
            'description' => 'nullable'
        ]);
        $newProduct = Product::create($data);

        return redirect('products')->with('success', 'Product created successfully');
    }

    // public function edit(Product $product)
    // {
    //     return view('products.edit', ['product' => $product]);
    // }

    // public function update(Product $product, Request $request)
    // {
    //     $data = $request->validate([
    //         'code' => 'required',
    //         'name' => 'required',
    //         'quantity' => 'required|numeric',
    //         'price' => 'required|decimal:0,2',
    //         'description' => 'nullable'
    //     ]); //validated data
    //     // $data = $request->all();  //unvalidated data

    //     $product->update($data);
    //     return redirect('products')->with('success', 'Product updated successfully');
    // }

    // public function destroy(Product $product)
    // {
    //     $product->delete();
    //     return redirect('products')->with('success', 'Product deleted successfully');
    // }
}
