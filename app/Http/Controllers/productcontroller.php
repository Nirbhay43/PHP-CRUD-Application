<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use \App\Models\product;
use \App\Models\subcategory;
use \App\Models\category;
use Illuminate\Http\Request;


class productcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();
        $subcat = Subcategory::get();
        $products = product::get();
        $editdata = '';

        return view('product', [
            'editdata' => $editdata,
            'catdata' => $categories,
            'subcatdata' => $subcat,
            'products' => $products
        ]);
    }
    public function getSubcat(Request $request)
    {
        $products =Subcategory::where('cat_id', $request->cat_id)->get();
        return $products;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'cat_id'=>'required',
            'subcat_id'=> 'required',
            'name'=> 'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif'
        ]);
        //img name 
        
        $imgName = "image".time().".".$request->image->extension();
        $request->image->move(public_path("productimages"), $imgName);
        $data = product::create([
        'cat_id' => $request->cat_id,
        'subcat_id' => $request->subcat_id,
        'name' => $request->name,
        'price' => $request->price,
        'image' => $imgName]);
        return redirect('/product')->with('success', 'Product save successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = \App\Models\category::get();
        $subcat = Subcategory::get();
        $products = product::get();
        $editdata = product::find( $id );
        return view('product', [
            'editdata' => $editdata,
            'catdata' => $categories,
            'subcatdata'=>$subcat,
            'products'=>$products
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $data = product::find($id);
        $data->update($request->all());
        return redirect('/product')->with('success', value: 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('/product')->with('success', 'Product deleted successfully');
    }
}
