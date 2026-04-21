<?php

namespace App\Http\Controllers;
use App\Models\subcategory;
use Illuminate\Http\Request;

class subapicontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = category::all();
        $data = subcategory::all();
        return response()->json(data: $data);
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
        $request->validate(
            [
                'subcatname' => 'required|min:3',
                'cat_id' => 'required'
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

       return response()->json([
            "msg"=>"subcategory save successfully."]);
    }

    
    public function edit(string $id)
    {
       $categories = \App\Models\category::get();
       $subcategory = \App\Models\subcategory::get();
        $data = \App\Models\subcategory::find($id);
        return response()->json([
            "msg"=>"Category get Successfully.",
            'editdata' => $data]);

        //return view('subcategory', [
          //  'editdata' => $data,
            //'catdata' => $categories,
            //'subcatdata' =>$subcat

        //]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = \App\Models\subcategory::findOrFail($id);
        $img = $data->image;
        if ($request->image != null) {
            if (file_exists(public_path('catimages/' . $img))) {
                unlink(public_path('catimages/' . $img));
            }
            $imgName = "img" . time() . "." . $request->image->extension();
                $request->image->move(public_path("catimages"), $imgName);
            $img = $imgName;
        }
        $data->update([
            'catname' => $request->catname,
            'image' => $img
        ]);
        return response()->json([
            "msg"=>"Category Update Successfully."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
