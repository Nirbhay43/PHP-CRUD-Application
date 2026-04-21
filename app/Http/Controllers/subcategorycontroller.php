<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $subcat = Subcategory::get();
        $editdata = '';

        return view('subcategory', [
            'editdata' => $editdata,
            'catdata' => $categories,
            'subcatdata' => $subcat
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'subcatname' => 'required|min:3',
            ],
            [
                'subcatname.required' => 'Please enter category',
                'subcatname.min' => 'At least 3 characters required'
            ]
        );

        Subcategory::create([
            'subcatname' => $request->subcatname,
            'cat_id' => $request->cat_id
        ]);

        return redirect('/subcategory')->with('success', 'Subcategory saved successfully');
    }

    public function edit($id)
    {
        $subcat = Subcategory::get();
        $categories = Category::get();
        $data = Subcategory::find($id);

        return view('subcategory', [
            'editdata' => $data,
            'catdata' => $categories,
            'subcatdata' =>$subcat

        ]);
    }

   public function update(Request $request, $id)
{
    $data = subcategory::findOrFail($id);

    $data->update(['subcatname'=>$request->subcatname]);
    return response()->json(['message' => 'Subcategory updated successfully']);
}

public function destroy($id)
{
    $data = subcategory::findorfail($id);
    
    $data-> delete();
    return response()->json(['message' => 'Subcategory deleted successfully']);
}
}
